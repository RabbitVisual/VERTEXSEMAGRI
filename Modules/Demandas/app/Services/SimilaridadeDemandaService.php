<?php

namespace Modules\Demandas\App\Services;

use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Models\DemandaInteressado;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Service avançado para detecção de demandas duplicadas/similares
 *
 * Utiliza múltiplos algoritmos de similaridade:
 * - Levenshtein Distance para textos curtos
 * - Jaccard Similarity para conjuntos de palavras
 * - TF-IDF simplificado para relevância de termos
 * - Soundex/Metaphone para similaridade fonética
 * - Geolocalização para proximidade espacial
 *
 * @author Sistema SEMAGRI
 * @version 2.0.0
 */
class SimilaridadeDemandaService
{
    // Configurações de threshold
    const THRESHOLD_ALTA_SIMILARIDADE = 85;    // Muito provável duplicata
    const THRESHOLD_MEDIA_SIMILARIDADE = 70;   // Provável duplicata
    const THRESHOLD_BAIXA_SIMILARIDADE = 55;   // Possível duplicata
    const THRESHOLD_MINIMO = 40;               // Mínimo para considerar

    // Pesos para cada critério de similaridade
    const PESO_LOCALIDADE = 35;      // Mesma localidade é muito importante
    const PESO_TIPO = 25;            // Mesmo tipo é importante
    const PESO_DESCRICAO = 20;       // Descrição similar
    const PESO_MOTIVO = 15;          // Motivo similar
    const PESO_TEMPORAL = 5;         // Proximidade temporal

    // Stopwords em português (palavras comuns a ignorar)
    private array $stopwords = [
        'a', 'o', 'e', 'de', 'da', 'do', 'em', 'um', 'uma', 'para', 'com', 'não',
        'que', 'os', 'as', 'dos', 'das', 'por', 'mais', 'como', 'mas', 'foi',
        'ao', 'ele', 'ela', 'entre', 'era', 'depois', 'sem', 'mesmo', 'aos',
        'ter', 'seus', 'sua', 'seu', 'nas', 'nos', 'já', 'está', 'eu', 'também',
        'só', 'pelo', 'pela', 'até', 'isso', 'quando', 'muito', 'ser', 'são',
        'tem', 'há', 'meu', 'minha', 'numa', 'num', 'este', 'esta', 'esse', 'essa',
        'aqui', 'ali', 'lá', 'onde', 'aquele', 'aquela', 'qual', 'quais',
        'problema', 'problemas', 'situação', 'favor', 'precisa', 'precisando',
        'urgente', 'urgência', 'ajuda', 'socorro', 'atenção', 'solicito', 'solicita',
    ];

    // Sinônimos comuns para normalização
    private array $sinonimos = [
        // Iluminação
        'poste' => ['poste', 'postes', 'luminária', 'luminarias', 'lampada', 'lampadas', 'luz', 'luzes'],
        'braço' => ['braço', 'bracos', 'braco', 'suporte', 'haste'],
        'quebrado' => ['quebrado', 'quebrada', 'quebrados', 'danificado', 'danificada', 'estragado', 'estragada', 'queimado', 'queimada', 'apagado', 'apagada', 'sem funcionar', 'não funciona', 'defeito'],
        'escuro' => ['escuro', 'escura', 'sem luz', 'apagado', 'apagada'],

        // Água
        'vazamento' => ['vazamento', 'vazando', 'vaza', 'furo', 'furado', 'rompimento', 'rompido', 'estourou', 'estouro'],
        'falta' => ['falta', 'faltando', 'sem', 'acabou', 'não tem', 'nao tem'],
        'agua' => ['agua', 'água', 'cano', 'tubulação', 'encanamento', 'torneira'],
        'caixa' => ['caixa', 'reservatório', 'reservatorio', 'cisterna', 'tanque'],

        // Estradas
        'buraco' => ['buraco', 'buracos', 'cratera', 'erosão', 'erosao', 'afundamento'],
        'estrada' => ['estrada', 'estradas', 'rua', 'ruas', 'via', 'vias', 'caminho', 'acesso', 'pista'],
        'patrolamento' => ['patrolamento', 'patrolagem', 'nivelamento', 'terraplanagem'],
        'cascalho' => ['cascalho', 'piçarra', 'picarra', 'pedra', 'pedras', 'brita'],

        // Poços
        'poco' => ['poco', 'poço', 'poços', 'pocos', 'cisterna', 'cacimba'],
        'bomba' => ['bomba', 'bombas', 'motor', 'motobomba'],
    ];

    // Cache de palavras-chave por demanda
    private array $cacheKeywords = [];

    /**
     * Busca demandas similares à nova demanda sendo criada
     *
     * @param array $dadosNovaDemanda Dados da nova demanda
     * @param int $limite Número máximo de resultados
     * @return Collection Coleção de demandas similares com scores
     */
    public function buscarSimilares(array $dadosNovaDemanda, int $limite = 5): Collection
    {
        $localidadeId = $dadosNovaDemanda['localidade_id'] ?? null;
        $tipo = $dadosNovaDemanda['tipo'] ?? null;
        $motivo = $dadosNovaDemanda['motivo'] ?? '';
        $descricao = $dadosNovaDemanda['descricao'] ?? '';

        if (!$localidadeId || !$tipo) {
            return collect([]);
        }

        // Buscar demandas candidatas (mesma localidade OU tipo, status aberta/em_andamento)
        $candidatas = Demanda::with(['localidade', 'interessados'])
            ->where(function($query) use ($localidadeId, $tipo) {
                $query->where('localidade_id', $localidadeId)
                      ->orWhere('tipo', $tipo);
            })
            ->whereIn('status', ['aberta', 'em_andamento'])
            ->where('created_at', '>=', now()->subDays(90)) // Últimos 90 dias
            ->get();

        if ($candidatas->isEmpty()) {
            return collect([]);
        }

        // Calcular score de similaridade para cada candidata
        $resultados = $candidatas->map(function($demanda) use ($dadosNovaDemanda) {
            $score = $this->calcularScoreSimilaridade($demanda, $dadosNovaDemanda);

            return [
                'demanda' => $demanda,
                'score' => $score,
                'detalhes' => $this->getDetalhesSimilaridade($demanda, $dadosNovaDemanda),
            ];
        })
        ->filter(fn($item) => $item['score'] >= self::THRESHOLD_MINIMO)
        ->sortByDesc('score')
        ->take($limite)
        ->values();

        return $resultados;
    }

    /**
     * Calcula o score de similaridade entre uma demanda existente e os dados da nova
     *
     * @param Demanda $demandaExistente
     * @param array $dadosNova
     * @return float Score de 0 a 100
     */
    public function calcularScoreSimilaridade(Demanda $demandaExistente, array $dadosNova): float
    {
        $scoreTotal = 0;

        // 1. Similaridade de Localidade (35%)
        $scoreLocalidade = $this->calcularSimilaridadeLocalidade(
            $demandaExistente->localidade_id,
            $dadosNova['localidade_id'] ?? null
        );
        $scoreTotal += $scoreLocalidade * (self::PESO_LOCALIDADE / 100);

        // 2. Similaridade de Tipo (25%)
        $scoreTipo = $this->calcularSimilaridadeTipo(
            $demandaExistente->tipo,
            $dadosNova['tipo'] ?? null
        );
        $scoreTotal += $scoreTipo * (self::PESO_TIPO / 100);

        // 3. Similaridade de Descrição (20%)
        $scoreDescricao = $this->calcularSimilaridadeTexto(
            $demandaExistente->descricao ?? '',
            $dadosNova['descricao'] ?? ''
        );
        $scoreTotal += $scoreDescricao * (self::PESO_DESCRICAO / 100);

        // 4. Similaridade de Motivo (15%)
        $scoreMotivo = $this->calcularSimilaridadeTexto(
            $demandaExistente->motivo ?? '',
            $dadosNova['motivo'] ?? ''
        );
        $scoreTotal += $scoreMotivo * (self::PESO_MOTIVO / 100);

        // 5. Proximidade Temporal (5%)
        $scoreTemporal = $this->calcularProximidadeTemporal($demandaExistente->created_at);
        $scoreTotal += $scoreTemporal * (self::PESO_TEMPORAL / 100);

        // Bônus: Se mesma localidade E mesmo tipo, aumentar score
        if ($scoreLocalidade === 100 && $scoreTipo === 100) {
            $scoreTotal = min(100, $scoreTotal * 1.15); // +15% de bônus
        }

        return round($scoreTotal, 2);
    }

    /**
     * Calcula similaridade de localidade
     */
    private function calcularSimilaridadeLocalidade(?int $localidade1, ?int $localidade2): float
    {
        if ($localidade1 === null || $localidade2 === null) {
            return 0;
        }

        // Mesma localidade = 100%
        if ($localidade1 === $localidade2) {
            return 100;
        }

        // TODO: Implementar verificação de localidades próximas geograficamente
        // Por enquanto, localidades diferentes = 0%
        return 0;
    }

    /**
     * Calcula similaridade de tipo
     */
    private function calcularSimilaridadeTipo(?string $tipo1, ?string $tipo2): float
    {
        if ($tipo1 === null || $tipo2 === null) {
            return 0;
        }

        // Mesmo tipo = 100%
        if ($tipo1 === $tipo2) {
            return 100;
        }

        // Tipos relacionados (ex: agua e poco)
        $tiposRelacionados = [
            'agua' => ['poco'],
            'poco' => ['agua'],
        ];

        if (isset($tiposRelacionados[$tipo1]) && in_array($tipo2, $tiposRelacionados[$tipo1])) {
            return 50; // 50% de similaridade para tipos relacionados
        }

        return 0;
    }

    /**
     * Calcula similaridade textual avançada usando múltiplos algoritmos
     */
    private function calcularSimilaridadeTexto(string $texto1, string $texto2): float
    {
        if (empty($texto1) || empty($texto2)) {
            return 0;
        }

        // Normalizar textos
        $texto1Norm = $this->normalizarTexto($texto1);
        $texto2Norm = $this->normalizarTexto($texto2);

        if (empty($texto1Norm) || empty($texto2Norm)) {
            return 0;
        }

        // 1. Jaccard Similarity (40% do peso)
        $palavras1 = $this->extrairPalavrasChave($texto1Norm);
        $palavras2 = $this->extrairPalavrasChave($texto2Norm);
        $jaccard = $this->calcularJaccardSimilarity($palavras1, $palavras2);

        // 2. Similaridade de N-gramas (30% do peso)
        $ngrams = $this->calcularNgramSimilarity($texto1Norm, $texto2Norm, 3);

        // 3. Levenshtein normalizado para textos curtos (20% do peso)
        $levenshtein = $this->calcularLevenshteinNormalizado($texto1Norm, $texto2Norm);

        // 4. Similaridade fonética (10% do peso)
        $fonetica = $this->calcularSimilaridadeFonetica($palavras1, $palavras2);

        // Combinar scores com pesos
        $scoreTotal = ($jaccard * 0.40) + ($ngrams * 0.30) + ($levenshtein * 0.20) + ($fonetica * 0.10);

        return round($scoreTotal, 2);
    }

    /**
     * Normaliza texto removendo acentos, convertendo para minúsculas, etc.
     */
    private function normalizarTexto(string $texto): string
    {
        // Converter para minúsculas
        $texto = mb_strtolower($texto, 'UTF-8');

        // Remover acentos
        $texto = $this->removerAcentos($texto);

        // Remover caracteres especiais, manter apenas letras, números e espaços
        $texto = preg_replace('/[^a-z0-9\s]/', ' ', $texto);

        // Remover espaços múltiplos
        $texto = preg_replace('/\s+/', ' ', $texto);

        return trim($texto);
    }

    /**
     * Remove acentos de uma string
     */
    private function removerAcentos(string $texto): string
    {
        $acentos = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];

        return strtr($texto, $acentos);
    }

    /**
     * Extrai palavras-chave relevantes do texto
     */
    private function extrairPalavrasChave(string $texto): array
    {
        $palavras = explode(' ', $texto);

        // Remover stopwords
        $palavras = array_filter($palavras, function($palavra) {
            return strlen($palavra) > 2 && !in_array($palavra, $this->stopwords);
        });

        // Normalizar sinônimos
        $palavras = array_map(function($palavra) {
            return $this->normalizarSinonimo($palavra);
        }, $palavras);

        return array_values(array_unique($palavras));
    }

    /**
     * Normaliza sinônimos para uma palavra base
     */
    private function normalizarSinonimo(string $palavra): string
    {
        foreach ($this->sinonimos as $base => $variantes) {
            if (in_array($palavra, $variantes)) {
                return $base;
            }
        }
        return $palavra;
    }

    /**
     * Calcula Jaccard Similarity entre dois conjuntos de palavras
     */
    private function calcularJaccardSimilarity(array $set1, array $set2): float
    {
        if (empty($set1) && empty($set2)) {
            return 0;
        }

        $intersecao = count(array_intersect($set1, $set2));
        $uniao = count(array_unique(array_merge($set1, $set2)));

        if ($uniao === 0) {
            return 0;
        }

        return ($intersecao / $uniao) * 100;
    }

    /**
     * Calcula similaridade baseada em N-gramas
     */
    private function calcularNgramSimilarity(string $texto1, string $texto2, int $n = 3): float
    {
        $ngrams1 = $this->gerarNgrams($texto1, $n);
        $ngrams2 = $this->gerarNgrams($texto2, $n);

        if (empty($ngrams1) || empty($ngrams2)) {
            return 0;
        }

        $intersecao = count(array_intersect($ngrams1, $ngrams2));
        $total = max(count($ngrams1), count($ngrams2));

        return ($intersecao / $total) * 100;
    }

    /**
     * Gera N-gramas de um texto
     */
    private function gerarNgrams(string $texto, int $n): array
    {
        $texto = str_replace(' ', '', $texto);
        $length = strlen($texto);

        if ($length < $n) {
            return [$texto];
        }

        $ngrams = [];
        for ($i = 0; $i <= $length - $n; $i++) {
            $ngrams[] = substr($texto, $i, $n);
        }

        return $ngrams;
    }

    /**
     * Calcula distância de Levenshtein normalizada
     */
    private function calcularLevenshteinNormalizado(string $texto1, string $texto2): float
    {
        // Limitar tamanho para performance
        $texto1 = substr($texto1, 0, 255);
        $texto2 = substr($texto2, 0, 255);

        $maxLen = max(strlen($texto1), strlen($texto2));

        if ($maxLen === 0) {
            return 100;
        }

        $distancia = levenshtein($texto1, $texto2);

        return (1 - ($distancia / $maxLen)) * 100;
    }

    /**
     * Calcula similaridade fonética usando Soundex
     */
    private function calcularSimilaridadeFonetica(array $palavras1, array $palavras2): float
    {
        if (empty($palavras1) || empty($palavras2)) {
            return 0;
        }

        $soundex1 = array_map('soundex', $palavras1);
        $soundex2 = array_map('soundex', $palavras2);

        $intersecao = count(array_intersect($soundex1, $soundex2));
        $total = max(count($soundex1), count($soundex2));

        return ($intersecao / $total) * 100;
    }

    /**
     * Calcula proximidade temporal (demandas recentes são mais relevantes)
     */
    private function calcularProximidadeTemporal($dataCriacao): float
    {
        if (!$dataCriacao) {
            return 0;
        }

        $diasAtras = now()->diffInDays($dataCriacao);

        if ($diasAtras <= 7) {
            return 100; // Última semana = 100%
        } elseif ($diasAtras <= 30) {
            return 80; // Último mês = 80%
        } elseif ($diasAtras <= 60) {
            return 50; // Últimos 2 meses = 50%
        } elseif ($diasAtras <= 90) {
            return 30; // Últimos 3 meses = 30%
        }

        return 0;
    }

    /**
     * Retorna detalhes da análise de similaridade
     */
    public function getDetalhesSimilaridade(Demanda $demanda, array $dadosNova): array
    {
        return [
            'localidade' => [
                'match' => $demanda->localidade_id === ($dadosNova['localidade_id'] ?? null),
                'score' => $this->calcularSimilaridadeLocalidade($demanda->localidade_id, $dadosNova['localidade_id'] ?? null),
                'nome' => $demanda->localidade?->nome,
            ],
            'tipo' => [
                'match' => $demanda->tipo === ($dadosNova['tipo'] ?? null),
                'score' => $this->calcularSimilaridadeTipo($demanda->tipo, $dadosNova['tipo'] ?? null),
                'existente' => $demanda->tipo_texto,
            ],
            'descricao' => [
                'score' => $this->calcularSimilaridadeTexto($demanda->descricao ?? '', $dadosNova['descricao'] ?? ''),
                'palavras_comum' => $this->getPalavrasComuns(
                    $this->extrairPalavrasChave($this->normalizarTexto($demanda->descricao ?? '')),
                    $this->extrairPalavrasChave($this->normalizarTexto($dadosNova['descricao'] ?? ''))
                ),
            ],
            'motivo' => [
                'score' => $this->calcularSimilaridadeTexto($demanda->motivo ?? '', $dadosNova['motivo'] ?? ''),
                'existente' => $demanda->motivo,
            ],
            'temporal' => [
                'dias_atras' => now()->diffInDays($demanda->created_at),
                'score' => $this->calcularProximidadeTemporal($demanda->created_at),
            ],
            'interessados' => [
                'total' => $demanda->total_interessados ?? 1,
            ],
        ];
    }

    /**
     * Retorna palavras em comum entre dois conjuntos
     */
    private function getPalavrasComuns(array $palavras1, array $palavras2): array
    {
        return array_values(array_intersect($palavras1, $palavras2));
    }

    /**
     * Verifica se uma nova demanda é duplicata provável
     */
    public function verificarDuplicata(array $dadosNova): ?array
    {
        $similares = $this->buscarSimilares($dadosNova, 1);

        if ($similares->isEmpty()) {
            return null;
        }

        $melhorMatch = $similares->first();

        if ($melhorMatch['score'] >= self::THRESHOLD_ALTA_SIMILARIDADE) {
            return [
                'is_duplicata' => true,
                'confianca' => 'alta',
                'demanda' => $melhorMatch['demanda'],
                'score' => $melhorMatch['score'],
                'detalhes' => $melhorMatch['detalhes'],
                'mensagem' => 'Esta demanda é muito similar a uma já existente. Recomendamos vincular-se à demanda existente.',
            ];
        }

        if ($melhorMatch['score'] >= self::THRESHOLD_MEDIA_SIMILARIDADE) {
            return [
                'is_duplicata' => true,
                'confianca' => 'media',
                'demanda' => $melhorMatch['demanda'],
                'score' => $melhorMatch['score'],
                'detalhes' => $melhorMatch['detalhes'],
                'mensagem' => 'Encontramos uma demanda similar. Você pode vincular-se a ela ou criar uma nova.',
            ];
        }

        return null;
    }

    /**
     * Vincula um interessado a uma demanda existente
     */
    public function vincularInteressado(Demanda $demanda, array $dadosInteressado, float $scoreSimilaridade = null, string $metodo = 'manual'): DemandaInteressado
    {
        DB::beginTransaction();

        try {
            // Verificar se já não está vinculado
            $existente = DemandaInteressado::where('demanda_id', $demanda->id)
                ->where(function($query) use ($dadosInteressado) {
                    if (!empty($dadosInteressado['pessoa_id'])) {
                        $query->where('pessoa_id', $dadosInteressado['pessoa_id']);
                    } elseif (!empty($dadosInteressado['cpf'])) {
                        $query->orWhere('cpf', $dadosInteressado['cpf']);
                    } elseif (!empty($dadosInteressado['email'])) {
                        $query->orWhere('email', $dadosInteressado['email']);
                    }
                })
                ->first();

            if ($existente) {
                // Atualizar dados existentes
                $existente->update([
                    'descricao_adicional' => $dadosInteressado['descricao_adicional'] ?? $existente->descricao_adicional,
                    'telefone' => $dadosInteressado['telefone'] ?? $existente->telefone,
                ]);

                DB::commit();
                return $existente;
            }

            // Criar novo vínculo
            $interessado = DemandaInteressado::create([
                'demanda_id' => $demanda->id,
                'pessoa_id' => $dadosInteressado['pessoa_id'] ?? null,
                'nome' => $dadosInteressado['nome'],
                'apelido' => $dadosInteressado['apelido'] ?? null,
                'telefone' => $dadosInteressado['telefone'] ?? null,
                'email' => $dadosInteressado['email'] ?? null,
                'cpf' => $dadosInteressado['cpf'] ?? null,
                'descricao_adicional' => $dadosInteressado['descricao_adicional'] ?? null,
                'fotos' => $dadosInteressado['fotos'] ?? null,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'notificar' => $dadosInteressado['notificar'] ?? true,
                'score_similaridade' => $scoreSimilaridade,
                'metodo_vinculo' => $metodo,
                'data_vinculo' => now(),
            ]);

            // Atualizar contador na demanda
            $demanda->increment('total_interessados');

            // Atualizar prioridade automaticamente se muitos interessados
            $this->atualizarPrioridadePorInteressados($demanda);

            // ========== VINCULAR LOCALIDADE À PESSOA AUTOMATICAMENTE ==========
            // Se a pessoa do CadÚnico foi vinculada e não tem localidade,
            // vincular a localidade da demanda a ela automaticamente
            if (!empty($dadosInteressado['pessoa_id']) && $demanda->localidade_id) {
                $this->vincularLocalidadePessoa($dadosInteressado['pessoa_id'], $demanda->localidade_id);
            }

            DB::commit();

            Log::info('Interessado vinculado à demanda', [
                'demanda_id' => $demanda->id,
                'interessado_id' => $interessado->id,
                'score' => $scoreSimilaridade,
                'metodo' => $metodo,
            ]);

            return $interessado;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao vincular interessado', [
                'demanda_id' => $demanda->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Vincula a localidade da demanda à pessoa do CadÚnico se ela não tiver uma
     *
     * Quando uma pessoa é vinculada a uma demanda (seja como solicitante original
     * ou como interessado), a localidade da demanda é automaticamente associada
     * à pessoa se ela ainda não tiver uma localidade definida.
     *
     * @param int $pessoaId ID da pessoa no CadÚnico
     * @param int $localidadeId ID da localidade da demanda
     * @return bool True se a localidade foi vinculada, false se já tinha ou erro
     */
    private function vincularLocalidadePessoa(int $pessoaId, int $localidadeId): bool
    {
        try {
            // Verificar se o módulo Pessoas está habilitado
            if (!class_exists(\Modules\Pessoas\App\Models\PessoaCad::class)) {
                return false;
            }

            $pessoa = \Modules\Pessoas\App\Models\PessoaCad::find($pessoaId);

            if (!$pessoa) {
                Log::warning('Pessoa não encontrada para vincular localidade', [
                    'pessoa_id' => $pessoaId,
                    'localidade_id' => $localidadeId,
                ]);
                return false;
            }

            // Se a pessoa já tem localidade, não sobrescrever
            if ($pessoa->localidade_id) {
                Log::debug('Pessoa já possui localidade vinculada', [
                    'pessoa_id' => $pessoaId,
                    'localidade_atual' => $pessoa->localidade_id,
                    'localidade_demanda' => $localidadeId,
                ]);
                return false;
            }

            // Vincular a localidade da demanda à pessoa
            $pessoa->localidade_id = $localidadeId;
            $pessoa->save();

            Log::info('Localidade vinculada automaticamente à pessoa via demanda', [
                'pessoa_id' => $pessoaId,
                'pessoa_nome' => $pessoa->nom_pessoa,
                'localidade_id' => $localidadeId,
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao vincular localidade à pessoa', [
                'pessoa_id' => $pessoaId,
                'localidade_id' => $localidadeId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Atualiza a prioridade da demanda baseado no número de interessados
     */
    private function atualizarPrioridadePorInteressados(Demanda $demanda): void
    {
        $totalInteressados = $demanda->total_interessados;
        $prioridadeAtual = $demanda->prioridade;

        // Regras de escalonamento automático
        $novaPrioridade = $prioridadeAtual;

        if ($totalInteressados >= 10 && $prioridadeAtual !== 'urgente') {
            $novaPrioridade = 'urgente';
        } elseif ($totalInteressados >= 5 && in_array($prioridadeAtual, ['baixa', 'media'])) {
            $novaPrioridade = 'alta';
        } elseif ($totalInteressados >= 3 && $prioridadeAtual === 'baixa') {
            $novaPrioridade = 'media';
        }

        if ($novaPrioridade !== $prioridadeAtual) {
            $demanda->update(['prioridade' => $novaPrioridade]);

            Log::info('Prioridade da demanda atualizada automaticamente', [
                'demanda_id' => $demanda->id,
                'prioridade_anterior' => $prioridadeAtual,
                'nova_prioridade' => $novaPrioridade,
                'total_interessados' => $totalInteressados,
            ]);
        }
    }

    /**
     * Gera cache de palavras-chave para uma demanda
     */
    public function gerarCachePalavrasChave(Demanda $demanda): string
    {
        $texto = $demanda->motivo . ' ' . ($demanda->descricao ?? '');
        $palavras = $this->extrairPalavrasChave($this->normalizarTexto($texto));

        $palavrasChave = implode(',', array_slice($palavras, 0, 20));

        $demanda->update(['palavras_chave' => $palavrasChave]);

        return $palavrasChave;
    }

    /**
     * Retorna estatísticas de similaridade para dashboard
     */
    public function getEstatisticasSimilaridade(): array
    {
        return Cache::remember('demandas_similaridade_stats', 3600, function() {
            return [
                'total_demandas_com_interessados' => Demanda::where('total_interessados', '>', 1)->count(),
                'total_interessados_vinculados' => DemandaInteressado::count(),
                'media_interessados_por_demanda' => round(Demanda::avg('total_interessados'), 2),
                'demandas_priorizadas_auto' => Demanda::where('total_interessados', '>=', 3)->count(),
            ];
        });
    }

    /**
     * Classifica o nível de similaridade
     */
    public function classificarSimilaridade(float $score): string
    {
        if ($score >= self::THRESHOLD_ALTA_SIMILARIDADE) {
            return 'alta';
        } elseif ($score >= self::THRESHOLD_MEDIA_SIMILARIDADE) {
            return 'media';
        } elseif ($score >= self::THRESHOLD_BAIXA_SIMILARIDADE) {
            return 'baixa';
        }
        return 'minima';
    }

    /**
     * Retorna cor CSS para o nível de similaridade
     */
    public function getCorSimilaridade(float $score): string
    {
        $nivel = $this->classificarSimilaridade($score);

        return match($nivel) {
            'alta' => 'red',
            'media' => 'orange',
            'baixa' => 'yellow',
            default => 'gray',
        };
    }
}

