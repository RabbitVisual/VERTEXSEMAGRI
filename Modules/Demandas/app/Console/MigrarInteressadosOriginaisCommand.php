<?php

namespace Modules\Demandas\App\Console;

use Illuminate\Console\Command;
use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Models\DemandaInteressado;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrarInteressadosOriginaisCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'demandas:migrar-interessados
                            {--force : Forçar migração mesmo se já existirem interessados}
                            {--gerar-keywords : Gerar cache de palavras-chave para todas as demandas}';

    /**
     * The console command description.
     */
    protected $description = 'Migra os solicitantes originais das demandas existentes para a tabela de interessados';

    protected SimilaridadeDemandaService $similaridadeService;

    public function __construct(SimilaridadeDemandaService $similaridadeService)
    {
        parent::__construct();
        $this->similaridadeService = $similaridadeService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Iniciando migração de interessados originais...');

        $force = $this->option('force');
        $gerarKeywords = $this->option('gerar-keywords');

        // Buscar todas as demandas
        $demandas = Demanda::withTrashed()->get();

        $this->info("Total de demandas encontradas: {$demandas->count()}");

        $migrados = 0;
        $ignorados = 0;
        $erros = 0;
        $keywordsGeradas = 0;

        $bar = $this->output->createProgressBar($demandas->count());
        $bar->start();

        foreach ($demandas as $demanda) {
            try {
                DB::beginTransaction();

                // Verificar se já existe interessado original
                $existeOriginal = DemandaInteressado::where('demanda_id', $demanda->id)
                    ->where('metodo_vinculo', 'solicitante_original')
                    ->exists();

                if ($existeOriginal && !$force) {
                    $ignorados++;
                    DB::commit();
                    $bar->advance();
                    continue;
                }

                // Criar interessado original se não existe
                if (!$existeOriginal) {
                    DemandaInteressado::create([
                        'demanda_id' => $demanda->id,
                        'pessoa_id' => $demanda->pessoa_id,
                        'nome' => $demanda->solicitante_nome,
                        'apelido' => $demanda->solicitante_apelido,
                        'telefone' => $demanda->solicitante_telefone,
                        'email' => $demanda->solicitante_email,
                        'user_id' => $demanda->user_id,
                        'notificar' => true,
                        'confirmado' => true,
                        'metodo_vinculo' => 'solicitante_original',
                        'data_vinculo' => $demanda->data_abertura ?? $demanda->created_at,
                    ]);

                    $migrados++;
                }

                // Recalcular total de interessados
                $totalInteressados = DemandaInteressado::where('demanda_id', $demanda->id)->count();
                $demanda->total_interessados = max(1, $totalInteressados);

                // Gerar cache de palavras-chave se solicitado
                if ($gerarKeywords) {
                    $texto = $demanda->motivo . ' ' . ($demanda->descricao ?? '');
                    $palavras = $this->extrairPalavrasChave($texto);
                    $demanda->palavras_chave = implode(',', array_slice($palavras, 0, 20));
                    $keywordsGeradas++;
                }

                $demanda->save();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                $erros++;
                Log::error('Erro ao migrar interessado para demanda ' . $demanda->id, [
                    'error' => $e->getMessage(),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Migração concluída!");
        $this->table(
            ['Métrica', 'Quantidade'],
            [
                ['Total de demandas', $demandas->count()],
                ['Interessados migrados', $migrados],
                ['Ignorados (já existiam)', $ignorados],
                ['Erros', $erros],
                ['Keywords geradas', $keywordsGeradas],
            ]
        );

        if ($erros > 0) {
            $this->warn("Houve {$erros} erro(s). Verifique os logs para mais detalhes.");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Extrai palavras-chave de um texto (versão simplificada)
     */
    private function extrairPalavrasChave(string $texto): array
    {
        $stopwords = [
            'a', 'o', 'e', 'de', 'da', 'do', 'em', 'um', 'uma', 'para', 'com', 'não',
            'que', 'os', 'as', 'dos', 'das', 'por', 'mais', 'como', 'mas', 'foi',
            'ao', 'ele', 'ela', 'entre', 'era', 'depois', 'sem', 'mesmo', 'aos',
        ];

        // Normalizar
        $texto = mb_strtolower($texto, 'UTF-8');
        $texto = preg_replace('/[^a-záàãâéêíóôõúç0-9\s]/u', ' ', $texto);
        $texto = preg_replace('/\s+/', ' ', $texto);

        $palavras = explode(' ', trim($texto));

        // Filtrar stopwords e palavras curtas
        $palavras = array_filter($palavras, function($palavra) use ($stopwords) {
            return strlen($palavra) > 2 && !in_array($palavra, $stopwords);
        });

        return array_values(array_unique($palavras));
    }
}

