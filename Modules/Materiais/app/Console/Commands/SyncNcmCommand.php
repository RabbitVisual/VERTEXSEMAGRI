<?php

namespace Modules\Materiais\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Modules\Materiais\App\Models\Ncm;
use Exception;

class SyncNcmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'materials:sync-ncm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza a tabela de NCMs com a fonte oficial do Governo Federal.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = 'https://portalunico.siscomex.gov.br/classif/api/publico/nomenclatura/download/json';

        $this->info('Iniciando sincronização de NCMs...');
        $this->info("Conectando ao Portal Único Siscomex...");

        try {
            $response = Http::timeout(300)->get($url);

            if ($response->failed()) {
                $this->error('Falha ao baixar dados do NCM. Status: ' . $response->status());
                return 1;
            }

            $data = $response->json();

            if (!isset($data['Nomenclaturas'])) {
                $this->error('Formato de JSON inválido: Chave "Nomenclaturas" não encontrada.');
                return 1;
            }

            $nomenclaturas = $data['Nomenclaturas'];
            $total = count($nomenclaturas);

            $this->info("Total de NCMs encontrados: $total");

            $bar = $this->output->createProgressBar($total);
            $bar->start();

            // Processar em chunks para evitar sobrecarga de memória e banco
            $chunks = array_chunk($nomenclaturas, 500);

            DB::beginTransaction();
            try {
                foreach ($chunks as $chunk) {
                    foreach ($chunk as $item) {
                        Ncm::updateOrCreate(
                            ['code' => $item['Codigo']],
                            [
                                'description' => $item['Descricao'],
                                'category' => $item['Descricao'] // Na API oficial as vezes não tem categoria separada, usamos a descrição como base ou processamos
                            ]
                        );
                        $bar->advance();
                    }
                }
                DB::commit();
                $bar->finish();
                $this->newLine();
                $this->info('Sincronização concluída com sucesso!');

            } catch (Exception $e) {
                DB::rollBack();
                $this->newLine();
                $this->error('Erro durante a sincronização: ' . $e->getMessage());
                return 1;
            }

        } catch (Exception $e) {
            $this->error('Erro de conexão: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
