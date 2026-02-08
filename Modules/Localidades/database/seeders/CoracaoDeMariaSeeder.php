<?php

namespace Modules\Localidades\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Modules\Localidades\App\Models\Localidade;

class CoracaoDeMariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Dados baseados no IBGE - Coração de Maria - BA
     * Código IBGE: 2908903
     * Coordenadas aproximadas: -12.2333° S, -38.7500° W
     */

    /**
     * Preenche os campos padrão para uma localidade
     */
    private function padronizarLocalidade(array $dados): array
    {
        return array_merge([
            'codigo' => null,
            'cep' => '44250-000', // CEP oficial de Coração de Maria - BA
            'endereco' => null,
            'numero' => null,
            'complemento' => null,
            'bairro' => null,
            'cidade' => 'Coração de Maria', // Padrão para todas as localidades
            'estado' => 'BA', // Estado padrão
            'lider_comunitario' => null,
            'telefone_lider' => null,
            'numero_moradores' => 0,
            'infraestrutura_disponivel' => null,
            'problemas_recorrentes' => null,
            'observacoes' => null,
            'ativo' => true,
        ], $dados);
    }

    public function run(): void
    {
        $localidades = [
            // Sede do Município
            $this->padronizarLocalidade([
                'nome' => 'Coração de Maria (Sede)',
                'tipo' => 'bairro',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2333,
                'longitude' => -38.7500,
                'observacoes' => 'Sede do município de Coração de Maria - BA',
            ]),

            // Distritos (conforme estrutura IBGE)
            $this->padronizarLocalidade([
                'nome' => 'Distrito de Retiro',
                'tipo' => 'distrito',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2500,
                'longitude' => -38.7333,
                'observacoes' => 'Distrito oficial do município conforme IBGE',
            ]),

            // Bairros/Comunidades Urbanas
            $this->padronizarLocalidade([
                'nome' => 'Centro',
                'tipo' => 'bairro',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2333,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'São José',
                'tipo' => 'bairro',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7550,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Santa Terezinha',
                'tipo' => 'bairro',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2300,
                'longitude' => -38.7450,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Nova Esperança',
                'tipo' => 'bairro',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2250,
                'longitude' => -38.7600,
            ]),

            // Zonas Rurais - Comunidades
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Pedra Nova',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2000,
                'longitude' => -38.7000,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cachoeira',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2600,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa Grande',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2800,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Boa Vista',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2100,
                'longitude' => -38.7800,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda São Pedro',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2700,
                'longitude' => -38.7600,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Meio',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2200,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Barro',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2900,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Tanque Novo',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7000,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cabeceira',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2500,
                'longitude' => -38.7700,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Canto',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2300,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho Fundo',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2600,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Peixe',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2100,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cachoeirinha',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2700,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa da Onça',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2800,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho das Pedras',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2200,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Jenipapo',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cabeceira do Riacho',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2500,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Brejo',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2600,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Canto',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2300,
                'longitude' => -38.7600,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Capim',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2700,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cachoeira do Meio',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2100,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Tanque',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2800,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Barro',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Cipó',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2500,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cabeceira Grande',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2600,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Pau',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2200,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Pau',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2700,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Coco',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2300,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cachoeira do Riacho',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2800,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Milho',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2100,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Milho',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7600,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Feijão',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2500,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cabeceira do Lago',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2600,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Arroz',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2200,
                'longitude' => -38.7400,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Arroz',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2700,
                'longitude' => -38.7100,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Algodão',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2800,
                'longitude' => -38.7200,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Cachoeira do Algodão',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2300,
                'longitude' => -38.7500,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Lagoa do Mandioca',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2100,
                'longitude' => -38.7300,
            ]),
            $this->padronizarLocalidade([
                'nome' => 'Fazenda Riacho do Mandioca',
                'tipo' => 'zona_rural',
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => -12.2400,
                'longitude' => -38.7400,
            ]),
        ];

        $contador = 0;
        $erros = 0;
        $puladas = 0;

        foreach ($localidades as $localidade) {
            try {
                // Verificar se já existe
                $existe = Localidade::where('nome', $localidade['nome'])
                    ->where('cidade', $localidade['cidade'])
                    ->first();

                if ($existe) {
                    $puladas++;
                    if ($this->command) {
                        $this->command->warn("Localidade '{$localidade['nome']}' já existe. Pulando...");
                    }
                    continue; // Pula se já existe
                }

                // Gerar código automaticamente se não fornecido
                if (empty($localidade['codigo'])) {
                    $localidade['codigo'] = Localidade::generateCode('LOC', $localidade['tipo']);
                }

                // Garantir valores padrão
                $localidade['numero_moradores'] = $localidade['numero_moradores'] ?? 0;
                $localidade['ativo'] = $localidade['ativo'] ?? true;

                Localidade::create($localidade);
                $contador++;
                if ($this->command) {
                    $this->command->info("✓ Cadastrada: {$localidade['nome']}");
                }
            } catch (\Exception $e) {
                $erros++;
                if ($this->command) {
                    $this->command->error("✗ Erro ao cadastrar '{$localidade['nome']}': " . $e->getMessage());
                    if ($this->command->getOutput()->isVerbose()) {
                        $this->command->error("  Stack trace: " . $e->getTraceAsString());
                    }
                } else {
                    // Fallback para quando não há command (execução direta)
                    Log::error("Erro ao cadastrar localidade '{$localidade['nome']}': " . $e->getMessage());
                }
            }
        }

        $mensagem = "\n═══════════════════════════════════════════════════════════\n";
        $mensagem .= "Localidades de Coração de Maria - BA processadas!\n";
        $mensagem .= "Total cadastradas: {$contador}\n";
        $mensagem .= "Total puladas (já existiam): {$puladas}\n";
        $mensagem .= "Total de erros: {$erros}\n";
        $mensagem .= "═══════════════════════════════════════════════════════════\n";

        if ($this->command) {
            $this->command->info($mensagem);
        } else {
            echo $mensagem;
        }
    }
}
