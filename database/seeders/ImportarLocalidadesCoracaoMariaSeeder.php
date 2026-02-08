<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Localidades\App\Models\Localidade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportarLocalidadesCoracaoMariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Limpando localidades existentes...');

        // Desativar verificação de chaves estrangeiras temporariamente (MySQL)
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } catch (\Exception $e) {
            // Ignorar se não for MySQL
        }

        // Limpar todas as localidades existentes (incluindo soft deleted)
        if (Schema::hasTable('localidades')) {
            // Como localidade_id em demandas não é nullable e tem onDelete('cascade'),
            // vamos excluir as demandas primeiro ou criar uma localidade temporária

            // Verificar se há demandas ou pessoas vinculadas
            $temDemandas = Schema::hasTable('demandas') && DB::table('demandas')->whereNotNull('localidade_id')->exists();
            $temPessoas = Schema::hasTable('pessoas_cad') && DB::table('pessoas_cad')->whereNotNull('localidade_id')->exists();

            if ($temDemandas || $temPessoas) {
                // Criar uma localidade temporária para manter integridade
                $localidadeTemporaria = Localidade::firstOrCreate(
                    ['codigo' => 'TEMP-' . date('YmdHis')],
                    [
                        'nome' => 'Temporária - Será Removida',
                        'tipo' => 'outro',
                        'cidade' => 'Coração de Maria',
                        'estado' => 'BA',
                        'ativo' => false,
                    ]
                );

                // Atualizar referências para a localidade temporária
                if ($temDemandas) {
                    DB::table('demandas')
                        ->whereNotNull('localidade_id')
                        ->update(['localidade_id' => $localidadeTemporaria->id]);
                }
                if ($temPessoas) {
                    DB::table('pessoas_cad')
                        ->whereNotNull('localidade_id')
                        ->update(['localidade_id' => $localidadeTemporaria->id]);
                }

                // Excluir todas as localidades permanentemente (exceto temporária)
                Localidade::where('id', '!=', $localidadeTemporaria->id)->forceDelete();

                // Excluir a temporária também após criar as novas
                $idTemporaria = $localidadeTemporaria->id;
            } else {
                $idTemporaria = null;
                // Verificar se usa soft deletes
                if (method_exists(Localidade::class, 'withTrashed')) {
                    Localidade::withTrashed()->forceDelete();
                } else {
                    Localidade::query()->delete();
                }
            }
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Exception $e) {
            // Ignorar se não for MySQL
        }

        $this->command->info('✅ Localidades antigas removidas.');
        $this->command->info('📦 Importando localidades de Coração de Maria (BA)...');

        // Coordenadas aproximadas de Coração de Maria (BA)
        $coordenadasBase = [
            'latitude' => -12.2333,
            'longitude' => -38.7500
        ];

        // Localidades do Distrito Sede
        $localidadesDistritoSede = [
            ['nome' => 'Flores', 'tipo' => 'comunidade', 'latitude' => -12.2400, 'longitude' => -38.7450],
            ['nome' => 'Santa Tereza', 'tipo' => 'comunidade', 'latitude' => -12.2350, 'longitude' => -38.7480],
            ['nome' => 'Santa Rosa', 'tipo' => 'comunidade', 'latitude' => -12.2300, 'longitude' => -38.7520],
            ['nome' => 'Chamorro', 'tipo' => 'comunidade', 'latitude' => -12.2250, 'longitude' => -38.7550],
            ['nome' => 'Cabeça do Nego', 'tipo' => 'comunidade', 'latitude' => -12.2200, 'longitude' => -38.7580],
            ['nome' => 'Cantagalo', 'tipo' => 'comunidade', 'latitude' => -12.2150, 'longitude' => -38.7600],
            ['nome' => 'Canabrava', 'tipo' => 'comunidade', 'latitude' => -12.2100, 'longitude' => -38.7620],
            ['nome' => 'Canoas', 'tipo' => 'comunidade', 'latitude' => -12.2050, 'longitude' => -38.7650],
            ['nome' => 'Terra Preta', 'tipo' => 'comunidade', 'latitude' => -12.2000, 'longitude' => -38.7680],
            ['nome' => 'Bom Viver', 'tipo' => 'comunidade', 'latitude' => -12.1950, 'longitude' => -38.7700],
            ['nome' => 'Nova-Vida', 'tipo' => 'comunidade', 'latitude' => -12.1900, 'longitude' => -38.7720],
            ['nome' => 'Riachão', 'tipo' => 'comunidade', 'latitude' => -12.1850, 'longitude' => -38.7750],
            ['nome' => 'Purrão', 'tipo' => 'comunidade', 'latitude' => -12.1800, 'longitude' => -38.7780],
            ['nome' => 'Sapé', 'tipo' => 'comunidade', 'latitude' => -12.1750, 'longitude' => -38.7800],
            ['nome' => 'Mucuri', 'tipo' => 'comunidade', 'latitude' => -12.1700, 'longitude' => -38.7820],
            ['nome' => 'Paciência', 'tipo' => 'comunidade', 'latitude' => -12.1650, 'longitude' => -38.7850],
            ['nome' => 'Camboatá', 'tipo' => 'comunidade', 'latitude' => -12.1600, 'longitude' => -38.7880],
            ['nome' => 'Jenipapo', 'tipo' => 'comunidade', 'latitude' => -12.1550, 'longitude' => -38.7900],
        ];

        // Localidades do Distrito de Itacava
        $localidadesItacava = [
            ['nome' => 'Itacava (Sede)', 'tipo' => 'distrito', 'latitude' => -12.1500, 'longitude' => -38.8000],
            ['nome' => 'Mucambo', 'tipo' => 'comunidade', 'latitude' => -12.1450, 'longitude' => -38.8020],
            ['nome' => 'Mucambinho', 'tipo' => 'comunidade', 'latitude' => -12.1400, 'longitude' => -38.8050],
            ['nome' => 'Pedras', 'tipo' => 'comunidade', 'latitude' => -12.1350, 'longitude' => -38.8080],
            ['nome' => 'Pedra Nova', 'tipo' => 'comunidade', 'latitude' => -12.1300, 'longitude' => -38.8100],
            ['nome' => 'Pedra Velha', 'tipo' => 'comunidade', 'latitude' => -12.1250, 'longitude' => -38.8120],
            ['nome' => 'Pedra Verde', 'tipo' => 'comunidade', 'latitude' => -12.1200, 'longitude' => -38.8150],
            ['nome' => 'Canudos', 'tipo' => 'comunidade', 'latitude' => -12.1150, 'longitude' => -38.8180],
            ['nome' => 'Bujiu', 'tipo' => 'comunidade', 'latitude' => -12.1100, 'longitude' => -38.8200],
            ['nome' => 'Tapera', 'tipo' => 'comunidade', 'latitude' => -12.1050, 'longitude' => -38.8220],
            ['nome' => 'Mata da Ladeira', 'tipo' => 'comunidade', 'latitude' => -12.1000, 'longitude' => -38.8250],
            ['nome' => 'Mata Costa', 'tipo' => 'comunidade', 'latitude' => -12.0950, 'longitude' => -38.8280],
            ['nome' => 'Mata Tamanco', 'tipo' => 'comunidade', 'latitude' => -12.0900, 'longitude' => -38.8300],
            ['nome' => 'Matambina', 'tipo' => 'comunidade', 'latitude' => -12.0850, 'longitude' => -38.8320],
            ['nome' => 'Brilhante', 'tipo' => 'comunidade', 'latitude' => -12.0800, 'longitude' => -38.8350],
            ['nome' => 'Mangueira', 'tipo' => 'comunidade', 'latitude' => -12.0750, 'longitude' => -38.8380],
            ['nome' => 'Godório', 'tipo' => 'comunidade', 'latitude' => -12.0700, 'longitude' => -38.8400],
            ['nome' => 'Retiro', 'tipo' => 'povoado', 'latitude' => -12.0650, 'longitude' => -38.8420],
            ['nome' => 'Sítio', 'tipo' => 'povoado', 'latitude' => -12.0600, 'longitude' => -38.8450],
        ];

        // Centro/Sede do Município
        $localidadesCentro = [
            ['nome' => 'Centro', 'tipo' => 'bairro', 'latitude' => -12.2333, 'longitude' => -38.7500],
        ];

        // Localidades da Sede/Centro (Ruas, Avenidas, Praças, etc.)
        $localidadesSede = [
            // Alamedas
            ['nome' => 'Alameda das Espatódias', 'tipo' => 'alameda', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Alameda das Grevílias', 'tipo' => 'alameda', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Alameda das Hortênsias', 'tipo' => 'alameda', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Avenidas
            ['nome' => 'Avenida Hamilton Pereira Daltro', 'tipo' => 'avenida', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Avenida Santo Antônio', 'tipo' => 'avenida', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Avenida Jacira Oliveira Mendes', 'tipo' => 'avenida', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Becos
            ['nome' => 'Beco Macário Pena', 'tipo' => 'beco', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Estradas
            ['nome' => 'Estrada da Sutera', 'tipo' => 'estrada', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Estrada do Cazuqui', 'tipo' => 'estrada', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Estrada do Camboatá', 'tipo' => 'estrada', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Jardins
            ['nome' => 'Jardim das Oliveiras', 'tipo' => 'jardim', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Praças
            ['nome' => 'Praça Araújo Pinho', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça Austricliano Moreira', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça das Palmeiras', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça José de Oliveira', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça José Gonçalves', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça Princesa Isabel', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Praça São Simão', 'tipo' => 'praca', 'latitude' => -12.2333, 'longitude' => -38.7500],

            // Ruas
            ['nome' => 'Rua Anibal Amorim', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Carmem de Jesus Oliveira', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Dorival Caymmi', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Edivaldo Lima Freitas', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Hermano Carvalho', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Joana Angélica', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Manoel Ferreira dos Santos', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Maria do Socorro Viana', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Maurílio José Santana', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Pedro Alves Lopes', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
            ['nome' => 'Rua Pedro Cerqueira Daltro', 'tipo' => 'rua', 'latitude' => -12.2333, 'longitude' => -38.7500],
        ];

        // Fazendas e Sítios
        $localidadesFazendas = [
            ['nome' => 'Primavera', 'tipo' => 'fazenda', 'latitude' => -12.266945, 'longitude' => -38.753214],
            // Cantagalo removida - duplicata da comunidade Cantagalo
            ['nome' => 'Povoação', 'tipo' => 'fazenda', 'latitude' => -12.286502, 'longitude' => -38.720603],
            ['nome' => 'Santana Tereza', 'tipo' => 'fazenda', 'latitude' => -12.279846, 'longitude' => -38.726732],
            ['nome' => 'Girassol Anexas', 'tipo' => 'fazenda', 'latitude' => -12.292811, 'longitude' => -38.758520],
            // Canabrava removida - duplicata da comunidade Canabrava
            ['nome' => 'Aurora', 'tipo' => 'fazenda', 'latitude' => -12.298743, 'longitude' => -38.749812],
            ['nome' => 'Moraes', 'tipo' => 'fazenda', 'latitude' => -12.301977, 'longitude' => -38.761390],
            // Flores removida - duplicata da comunidade Flores
            ['nome' => 'Coqueiro', 'tipo' => 'fazenda', 'latitude' => -12.279018, 'longitude' => -38.717654],
            ['nome' => 'Campo Grande 01', 'tipo' => 'fazenda', 'latitude' => -12.299547, 'longitude' => -38.732405],
            ['nome' => 'Campo Grande 02', 'tipo' => 'fazenda', 'latitude' => -12.300102, 'longitude' => -38.734856],
            ['nome' => 'Canabrava 02', 'tipo' => 'fazenda', 'latitude' => -12.281204, 'longitude' => -38.736001],
            ['nome' => 'Sítio O Cordeiro', 'tipo' => 'sitio', 'latitude' => -12.295703, 'longitude' => -38.752947],
            // Camboatá removida - duplicata da comunidade Camboatá
            // Mangueira removida - duplicata da comunidade Mangueira
            ['nome' => 'São José', 'tipo' => 'fazenda', 'latitude' => -12.274586, 'longitude' => -38.748021],
            // Mata da Ladeira removida - duplicata da comunidade Mata da Ladeira
            ['nome' => 'Sarita', 'tipo' => 'fazenda', 'latitude' => -12.303710, 'longitude' => -38.745391],
            ['nome' => 'Cajazeira', 'tipo' => 'fazenda', 'latitude' => -12.303710, 'longitude' => -38.745391],
            // Aurora removida - já existe acima
            ['nome' => 'Canoa', 'tipo' => 'fazenda', 'latitude' => -12.303710, 'longitude' => -38.745391],
            // Bom Viver removida - será adicionada abaixo sem duplicata
            // Nova Vida removida - será adicionada abaixo sem duplicata
            ['nome' => 'Senhora Santana', 'tipo' => 'fazenda', 'latitude' => -12.305842, 'longitude' => -38.749108],
            ['nome' => 'Paraíso', 'tipo' => 'fazenda', 'latitude' => -12.290272, 'longitude' => -38.739203],
            ['nome' => 'Cordeiro', 'tipo' => 'fazenda', 'latitude' => -12.295315, 'longitude' => -38.752490],
            ['nome' => 'Bugio', 'tipo' => 'fazenda', 'latitude' => -12.308129, 'longitude' => -38.743977],
            ['nome' => 'Água Branca', 'tipo' => 'fazenda', 'latitude' => -12.308129, 'longitude' => -38.743977],
            ['nome' => 'Bom Viver', 'tipo' => 'fazenda', 'latitude' => -12.299146, 'longitude' => -38.735210],
            ['nome' => 'Nova Vida', 'tipo' => 'fazenda', 'latitude' => -12.299146, 'longitude' => -38.735210],
            ['nome' => 'Atalho', 'tipo' => 'fazenda', 'latitude' => -12.291044, 'longitude' => -38.740832],
            ['nome' => 'Lagoa Bonita', 'tipo' => 'fazenda', 'latitude' => -12.282875, 'longitude' => -38.727985],
            ['nome' => 'Estrela Guia', 'tipo' => 'fazenda', 'latitude' => -12.300268, 'longitude' => -38.755682],
            ['nome' => 'Bele Europa', 'tipo' => 'fazenda', 'latitude' => -12.285334, 'longitude' => -38.723410],
            ['nome' => 'Riachão', 'tipo' => 'fazenda', 'latitude' => -12.285334, 'longitude' => -38.723410],
            ['nome' => 'Reunidas Barra', 'tipo' => 'fazenda', 'latitude' => -12.308698, 'longitude' => -38.740046],
            ['nome' => 'Sant\'Ana II', 'tipo' => 'fazenda', 'latitude' => -12.293910, 'longitude' => -38.744224],
            ['nome' => 'Pau Roxo', 'tipo' => 'fazenda', 'latitude' => -12.307483, 'longitude' => -38.742200],
            ['nome' => 'São Francisco', 'tipo' => 'fazenda', 'latitude' => -12.279322, 'longitude' => -38.726789],
            ['nome' => 'São Domingos', 'tipo' => 'fazenda', 'latitude' => -12.275665, 'longitude' => -38.742506],
            ['nome' => 'Bela Vista', 'tipo' => 'fazenda', 'latitude' => -12.297986, 'longitude' => -38.754093],
            ['nome' => 'Lagoa dos Porcos', 'tipo' => 'fazenda', 'latitude' => -12.302258, 'longitude' => -38.731514],
            ['nome' => 'Moita', 'tipo' => 'fazenda', 'latitude' => -12.288903, 'longitude' => -38.732989],
            ['nome' => 'Zabelê', 'tipo' => 'fazenda', 'latitude' => -12.283600, 'longitude' => -38.728710],
            // Tapera removida - duplicata da comunidade Tapera
            ['nome' => 'Bugil', 'tipo' => 'fazenda', 'latitude' => -12.289971, 'longitude' => -38.745312],
            ['nome' => 'Pedras Novas', 'tipo' => 'fazenda', 'latitude' => -12.286204, 'longitude' => -38.732517],
            ['nome' => 'Nova Esperança', 'tipo' => 'fazenda', 'latitude' => -12.298734, 'longitude' => -38.737194],
            // Canudos removida - duplicata da comunidade Canudos
            ['nome' => 'Carneiro', 'tipo' => 'fazenda', 'latitude' => -12.297189, 'longitude' => -38.747302],
            ['nome' => 'Fortuna', 'tipo' => 'fazenda', 'latitude' => -12.294905, 'longitude' => -38.743123],
            ['nome' => 'Mafica', 'tipo' => 'fazenda', 'latitude' => -12.294905, 'longitude' => -38.743123],
            ['nome' => 'Alto do Cruzeiro', 'tipo' => 'fazenda', 'latitude' => -12.273698, 'longitude' => -38.734507],
            ['nome' => 'Madre de Deus', 'tipo' => 'fazenda', 'latitude' => -12.282069, 'longitude' => -38.733910],
            ['nome' => 'Rancho Alegre', 'tipo' => 'fazenda', 'latitude' => -12.284617, 'longitude' => -38.736278],
            // Paciência removida - duplicata da comunidade Paciência
            ['nome' => 'Monte Alegre', 'tipo' => 'fazenda', 'latitude' => -12.287309, 'longitude' => -38.747084],
            // Matambina removida - duplicata da comunidade Matambina
            ['nome' => 'Quissamá', 'tipo' => 'fazenda', 'latitude' => -12.290571, 'longitude' => -38.731844],
            ['nome' => 'Mucurí', 'tipo' => 'fazenda', 'latitude' => -12.291276, 'longitude' => -38.734471],
            ['nome' => 'Quiçamá', 'tipo' => 'fazenda', 'latitude' => -12.291276, 'longitude' => -38.734471],
            // Fortuna removida - já existe acima
            ['nome' => 'Belmonte', 'tipo' => 'fazenda', 'latitude' => -12.298129, 'longitude' => -38.739652],
            ['nome' => 'Nova Vista', 'tipo' => 'fazenda', 'latitude' => -12.293484, 'longitude' => -38.733908],
            ['nome' => 'Santa Tereza', 'tipo' => 'fazenda', 'latitude' => -12.281792, 'longitude' => -38.726199],
            ['nome' => 'Queimadas', 'tipo' => 'fazenda', 'latitude' => -12.303192, 'longitude' => -38.752914],
        ];

        // Combinar todas as localidades
        $todasLocalidades = array_merge(
            $localidadesCentro,
            $localidadesSede,
            $localidadesDistritoSede,
            $localidadesItacava,
            $localidadesFazendas
        );

        $contador = 0;
        $sequencia = 1;

        foreach ($todasLocalidades as $localidadeData) {
            // Gerar código único para cada localidade
            $codigo = 'LOC-' . strtoupper(substr($localidadeData['tipo'], 0, 3)) . '-' . date('Ym') . '-' . str_pad($sequencia, 4, '0', STR_PAD_LEFT);

            // Garantir que o código seja único
            while (Localidade::where('codigo', $codigo)->exists()) {
                $sequencia++;
                $codigo = 'LOC-' . strtoupper(substr($localidadeData['tipo'], 0, 3)) . '-' . date('Ym') . '-' . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
            }

            $localidade = Localidade::create([
                'nome' => $localidadeData['nome'],
                'codigo' => $codigo,
                'tipo' => $localidadeData['tipo'],
                'cidade' => 'Coração de Maria',
                'estado' => 'BA',
                'latitude' => $localidadeData['latitude'],
                'longitude' => $localidadeData['longitude'],
                'ativo' => true,
                'numero_moradores' => 0, // Será atualizado conforme necessário
            ]);

            $contador++;
            $sequencia++;
            $this->command->info("  ✓ {$localidade->nome} ({$localidade->tipo}) - {$localidade->codigo}");
        }

        // Atualizar referências da localidade temporária para a localidade Centro
        if (isset($idTemporaria) && $idTemporaria) {
            $localidadeCentro = Localidade::where('nome', 'Centro')->first();

            if ($localidadeCentro) {
                // Atualizar demandas
                if (Schema::hasTable('demandas')) {
                    $demandasAtualizadas = DB::table('demandas')
                        ->where('localidade_id', $idTemporaria)
                        ->update(['localidade_id' => $localidadeCentro->id]);
                    if ($demandasAtualizadas > 0) {
                        $this->command->info("  📝 {$demandasAtualizadas} demanda(s) atualizada(s) para Centro");
                    }
                }

                // Atualizar pessoas
                if (Schema::hasTable('pessoas_cad')) {
                    $pessoasAtualizadas = DB::table('pessoas_cad')
                        ->where('localidade_id', $idTemporaria)
                        ->update(['localidade_id' => $localidadeCentro->id]);
                    if ($pessoasAtualizadas > 0) {
                        $this->command->info("  📝 {$pessoasAtualizadas} pessoa(s) atualizada(s) para Centro");
                    }
                }

                // Excluir localidade temporária
                $localidadeTemp = Localidade::find($idTemporaria);
                if ($localidadeTemp) {
                    $localidadeTemp->forceDelete();
                    $this->command->info("  🗑️ Localidade temporária removida");
                }
            }
        }

        $this->command->info("\n✅ Importação concluída!");
        $this->command->info("📊 Total de localidades criadas: {$contador}");
        $this->command->info("📍 Município: Coração de Maria - BA");
        $this->command->info("🏛️ Código IBGE: 2908903");
    }
}
