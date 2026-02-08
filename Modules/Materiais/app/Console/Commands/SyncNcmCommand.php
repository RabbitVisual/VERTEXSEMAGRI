<?php

namespace Modules\Materiais\App\Console\Commands;

use Illuminate\Console\Command;

class SyncNcmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ncm:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza a tabela de NCMs com a fonte oficial.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando sincronização de NCMs...');
        // Lógica de sincronização aqui
        $this->info('Sincronização concluída (Simulação).');
    }
}
