<?php

namespace Modules\Materiais\App\Console;

use Illuminate\Console\Command;
use Modules\Materiais\App\Services\NCMService;

class SyncMateriaisCommand extends Command
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
    protected $description = 'Sync NCM codes for materials.';

    /**
     * Execute the console command.
     */
    public function handle(NCMService $service)
    {
        $this->info('Starting NCM sync...');
        $service->sync();
        $this->info('NCM sync completed successfully.');
    }
}
