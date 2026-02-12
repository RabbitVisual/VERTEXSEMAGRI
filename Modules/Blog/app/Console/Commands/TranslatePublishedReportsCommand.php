<?php

namespace Modules\Blog\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Blog\App\Models\BlogPost;

class TranslatePublishedReportsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:translate-published-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate English phrases in published monthly reports to PT-BR';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // Busca posts publicados cujo conteúdo contenha textos em inglês específicos
        $posts = BlogPost::where('status', 'published')
            ->where(function ($query) {
                $query->where('content', 'like', '%Dados Relacionados - Monthly_report%')
                      ->orWhere('content', 'like', '%Dados Relacionados - Monthly Report%');
            })->get();

        $updatedCount = 0;
        foreach ($posts as $post) {
            $content = $post->content;
            $original = $content;
            $content = str_replace('Dados Relacionados - Monthly_report', 'Dados Relacionados - Relatório Mensal', $content);
            $content = str_replace('Dados Relacionados - Monthly Report', 'Dados Relacionados - Relatório Mensal', $content);

            if ($content !== $original) {
                $post->content = $content;
                $post->save();
                $updatedCount++;
            }
        }

        if ($updatedCount > 0) {
            $this->info("Atualizados {$updatedCount} publicação/Publicações com PT-BR no conteúdo de Relatórios Mensais.");
        } else {
            $this->info("Nenhuma publicação de Relatório Mensal continha termos em inglês.");
        }

        return 0;
    }
}
