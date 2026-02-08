<?php

namespace Modules\Blog\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Blog\App\Models\BlogPost;
use Modules\Blog\App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BlogIntegrationController extends Controller
{
    /**
     * Gerar post automático com estatísticas mensais
     */
    public function generateMonthlyReport($month = null, $year = null)
    {
        $month = $month ?: date('m');
        $year = $year ?: date('Y');
        $monthName = $this->getMonthName($month);
        
        // Verificar se já existe um post para este mês
        $existingPost = BlogPost::where('auto_generated_from', 'monthly_report')
            ->whereYear('published_at', $year)
            ->whereMonth('published_at', $month)
            ->first();

        if ($existingPost) {
            return response()->json([
                'success' => false,
                'message' => 'Já existe um relatório mensal para este período.',
                'post_id' => $existingPost->id
            ]);
        }

        try {
            // Coletar dados de todos os módulos
            $moduleData = $this->collectModuleData($month, $year);
            
            // Gerar conteúdo do post
            $content = $this->generateMonthlyContent($moduleData, $monthName, $year);
            
            // Criar categoria se não existir
            $category = BlogCategory::firstOrCreate(
                ['slug' => 'relatorios-mensais'],
                [
                    'name' => 'Relatórios Mensais',
                    'description' => 'Relatórios mensais automáticos com estatísticas dos serviços municipais',
                    'color' => '#059669',
                    'icon' => 'chart-bar',
                    'is_active' => true
                ]
            );

            // Criar post
            $post = BlogPost::create([
                'title' => "Relatório Mensal - {$monthName} {$year}",
                'slug' => Str::slug("relatorio-mensal-{$monthName}-{$year}"),
                'excerpt' => "Confira as principais atividades e estatísticas da Secretaria Municipal de Agricultura em {$monthName} de {$year}.",
                'content' => $content,
                'category_id' => $category->id,
                'author_id' => 1, // Admin padrão
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => true,
                'allow_comments' => true,
                'meta_title' => "Relatório Mensal {$monthName} {$year} - VERTEXSEMAGRI",
                'meta_description' => "Relatório completo das atividades da Secretaria Municipal de Agricultura em {$monthName} de {$year}. Confira estatísticas de demandas, ordens de serviço, materiais e muito mais.",
                'meta_keywords' => ['relatório', 'mensal', $monthName, $year, 'estatísticas', 'agricultura'],
                'module_data' => $moduleData,
                'auto_generated_from' => 'monthly_report'
            ]);

            // Adicionar tags
            $this->addPostTags($post, ['relatório mensal', $monthName, $year, 'estatísticas']);

            return response()->json([
                'success' => true,
                'message' => 'Relatório mensal gerado com sucesso!',
                'post_id' => $post->id,
                'post_url' => route('blog.show', $post->slug)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar relatório: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gerar post automático sobre conclusão de serviços
     */
    public function generateServiceCompletionPost($serviceType, $count, $localidade = null)
    {
        try {
            $title = $this->generateServiceTitle($serviceType, $count, $localidade);
            $content = $this->generateServiceContent($serviceType, $count, $localidade);
            
            // Criar categoria se não existir
            $category = BlogCategory::firstOrCreate(
                ['slug' => 'servicos-realizados'],
                [
                    'name' => 'Serviços Realizados',
                    'description' => 'Notícias sobre serviços concluídos pela secretaria',
                    'color' => '#10B981',
                    'icon' => 'check-circle',
                    'is_active' => true
                ]
            );

            $post = BlogPost::create([
                'title' => $title,
                'slug' => Str::slug($title . '-' . now()->format('d-m-Y')),
                'excerpt' => $this->generateServiceExcerpt($serviceType, $count, $localidade),
                'content' => $content,
                'category_id' => $category->id,
                'author_id' => 1,
                'status' => 'published',
                'published_at' => now(),
                'is_featured' => false,
                'allow_comments' => true,
                'module_data' => [
                    'service_type' => $serviceType,
                    'count' => $count,
                    'localidade' => $localidade,
                    'date' => now()->format('Y-m-d')
                ],
                'auto_generated_from' => $serviceType
            ]);

            $this->addPostTags($post, [$serviceType, 'serviços concluídos', $localidade]);

            return $post;

        } catch (\Exception $e) {
            \Log::error('Erro ao gerar post de serviço: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Coletar dados de todos os módulos
     */
    private function collectModuleData($month, $year)
    {
        $data = [];

        try {
            // Demandas
            if (class_exists('\Modules\Demandas\App\Models\Demanda')) {
                $demandasModel = '\Modules\Demandas\App\Models\Demanda';
                $data['demandas_abertas'] = $demandasModel::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();
                $data['demandas_concluidas'] = $demandasModel::whereYear('updated_at', $year)
                    ->whereMonth('updated_at', $month)
                    ->where('status', 'concluida')
                    ->count();
            }

            // Ordens de Serviço
            if (class_exists('\Modules\Ordens\App\Models\OrdemServico')) {
                $ordensModel = '\Modules\Ordens\App\Models\OrdemServico';
                $data['ordens_abertas'] = $ordensModel::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();
                $data['ordens_concluidas'] = $ordensModel::whereYear('updated_at', $year)
                    ->whereMonth('updated_at', $month)
                    ->where('status', 'concluida')
                    ->count();
            }

            // Materiais utilizados
            if (class_exists('\Modules\Materiais\App\Models\MaterialMovimentacao')) {
                $movimentacaoModel = '\Modules\Materiais\App\Models\MaterialMovimentacao';
                $data['materiais_utilizados'] = $movimentacaoModel::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->where('tipo', 'saida')
                    ->sum('quantidade');
            }

            // Poços atendidos
            if (class_exists('\Modules\Pocos\App\Models\Poco')) {
                $pocosModel = '\Modules\Pocos\App\Models\Poco';
                $data['pocos_atendidos'] = $pocosModel::whereHas('demandas', function($q) use ($month, $year) {
                    $q->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
                })->count();
            }

            // Pessoas atendidas
            if (class_exists('\Modules\Pessoas\App\Models\Pessoa')) {
                $pessoasModel = '\Modules\Pessoas\App\Models\Pessoa';
                $data['pessoas_atendidas'] = $pessoasModel::whereHas('demandas', function($q) use ($month, $year) {
                    $q->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
                })->count();
            }

            // Localidades atendidas
            if (class_exists('\Modules\Localidades\App\Models\Localidade')) {
                $localidadesModel = '\Modules\Localidades\App\Models\Localidade';
                $data['localidades_atendidas'] = $localidadesModel::whereHas('demandas', function($q) use ($month, $year) {
                    $q->whereYear('created_at', $year)
                      ->whereMonth('created_at', $month);
                })->count();
            }

        } catch (\Exception $e) {
            \Log::error('Erro ao coletar dados dos módulos: ' . $e->getMessage());
        }

        return $data;
    }

    /**
     * Gerar conteúdo do relatório mensal em HTML
     */
    private function generateMonthlyContent($moduleData, $monthName, $year)
    {
        $content = '<h1 style="text-align: center; margin-bottom: 2rem;">Relatório de Atividades - ' . $monthName . ' ' . $year . '</h1>';
        $content .= '<p style="text-align: justify; margin-bottom: 2rem; font-size: 1.1em;">A Secretaria Municipal de Agricultura apresenta o relatório das principais atividades realizadas em ' . $monthName . ' de ' . $year . '.</p>';

        $content .= '<h2 style="margin-top: 3rem; margin-bottom: 1.5rem; color: #059669;"><span style="font-size: 1.2em;">📊</span> Principais Números</h2>';

        if (isset($moduleData['demandas_abertas'])) {
            $content .= '<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #059669;">Demandas da População</h3>';
            $content .= '<ul style="margin-bottom: 1.5rem;">';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . $moduleData['demandas_abertas'] . '</strong> novas demandas registradas</li>';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['demandas_concluidas'] ?? 0) . '</strong> demandas concluídas</li>';
            $content .= '</ul>';
        }

        if (isset($moduleData['ordens_abertas'])) {
            $content .= '<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #059669;">Ordens de Serviço</h3>';
            $content .= '<ul style="margin-bottom: 1.5rem;">';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . $moduleData['ordens_abertas'] . '</strong> ordens de serviço abertas</li>';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['ordens_concluidas'] ?? 0) . '</strong> ordens de serviço concluídas</li>';
            $content .= '</ul>';
        }

        if (isset($moduleData['materiais_utilizados'])) {
            $content .= '<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #059669;">Materiais e Recursos</h3>';
            $content .= '<ul style="margin-bottom: 1.5rem;">';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['materiais_utilizados'] ?? 0) . '</strong> unidades de materiais utilizados</li>';
            $content .= '</ul>';
        }

        if (isset($moduleData['pocos_atendidos'])) {
            $content .= '<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #059669;">Infraestrutura Hídrica</h3>';
            $content .= '<ul style="margin-bottom: 1.5rem;">';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['pocos_atendidos'] ?? 0) . '</strong> poços artesianos atendidos</li>';
            $content .= '</ul>';
        }

        if (isset($moduleData['pessoas_atendidas'])) {
            $content .= '<h3 style="margin-top: 2rem; margin-bottom: 1rem; color: #059669;">Atendimento à População</h3>';
            $content .= '<ul style="margin-bottom: 1.5rem;">';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['pessoas_atendidas'] ?? 0) . '</strong> pessoas atendidas</li>';
            $content .= '<li style="margin-bottom: 0.5rem;"><strong>' . ($moduleData['localidades_atendidas'] ?? 0) . '</strong> localidades beneficiadas</li>';
            $content .= '</ul>';
        }

        $content .= '<h2 style="margin-top: 3rem; margin-bottom: 1.5rem; color: #059669;"><span style="font-size: 1.2em;">🎯</span> Compromisso com a Transparência</h2>';

        $content .= '<p style="text-align: justify; margin-bottom: 1.5rem;">Este relatório faz parte do nosso compromisso com a transparência e prestação de contas à população. Todos os dados são extraídos diretamente do sistema VERTEXSEMAGRI, garantindo precisão e confiabilidade.</p>';

        $content .= '<p style="text-align: justify; margin-bottom: 2rem;">Para mais informações sobre nossos serviços, acesse o Portal de Transparência ou entre em contato conosco.</p>';

        $content .= '<hr style="border: none; border-top: 2px solid #e5e7eb; margin: 3rem 0;">';
        $content .= '<p style="text-align: center; font-style: italic; color: #6b7280; margin-top: 2rem;"><em>Relatório gerado automaticamente pelo sistema VERTEXSEMAGRI em ' . now()->format('d/m/Y \à\s H:i') . '</em></p>';

        // Garantir que textos de dados relacionados estejam em PT-BR
        $content = str_replace('Dados Relacionados - Monthly_report', 'Dados Relacionados - Relatório Mensal', $content);
        $content = str_replace('Dados Relacionados - Monthly Report', 'Dados Relacionados - Relatório Mensal', $content);
        return $content;
    }

    /**
     * Gerar título para post de serviço
     */
    private function generateServiceTitle($serviceType, $count, $localidade = null)
    {
        $serviceNames = [
            'agua' => 'serviços de água',
            'poco' => 'manutenções em poços',
            'iluminacao' => 'serviços de iluminação pública',
            'estrada' => 'manutenções de estradas'
        ];

        $serviceName = $serviceNames[$serviceType] ?? 'serviços';
        $locationText = $localidade ? " em {$localidade}" : " no município";

        return "Concluídos {$count} {$serviceName}{$locationText}";
    }

    /**
     * Gerar conteúdo para post de serviço em HTML
     */
    private function generateServiceContent($serviceType, $count, $localidade = null)
    {
        $serviceNames = [
            'agua' => 'água',
            'poco' => 'poços artesianos',
            'iluminacao' => 'iluminação pública',
            'estrada' => 'estradas rurais'
        ];

        $serviceName = $serviceNames[$serviceType] ?? 'infraestrutura';
        $locationText = $localidade ? "na localidade de {$localidade}" : "em diversas localidades do município";

        $content = '<p style="text-align: justify; margin-bottom: 2rem; font-size: 1.1em;">A Secretaria Municipal de Agricultura informa que foram concluídos <strong>' . $count . ' serviços</strong> relacionados a ' . $serviceName . ' ' . $locationText . '.</p>';

        $content .= '<h2 style="margin-top: 3rem; margin-bottom: 1.5rem; color: #059669;">Serviços Realizados</h2>';

        $content .= '<p style="text-align: justify; margin-bottom: 1.5rem;">Os trabalhos foram executados por nossas equipes técnicas, seguindo os padrões de qualidade e segurança estabelecidos. Todas as atividades foram devidamente registradas no sistema VERTEXSEMAGRI para controle e acompanhamento.</p>';

        $content .= '<h2 style="margin-top: 3rem; margin-bottom: 1.5rem; color: #059669;">Compromisso com a Qualidade</h2>';

        $content .= '<p style="text-align: justify; margin-bottom: 1.5rem;">A Prefeitura Municipal continua investindo na melhoria da infraestrutura e na qualidade dos serviços prestados à população. Nosso objetivo é garantir que todos os cidadãos tenham acesso aos serviços públicos essenciais.</p>';

        $content .= '<p style="text-align: justify; margin-bottom: 2rem;">Para solicitar serviços ou obter mais informações, entre em contato conosco através dos canais oficiais.</p>';

        $content .= '<hr style="border: none; border-top: 2px solid #e5e7eb; margin: 3rem 0;">';
        $content .= '<p style="text-align: center; font-style: italic; color: #6b7280; margin-top: 2rem;"><em>Publicação automática gerada pelo sistema VERTEXSEMAGRI em ' . now()->format('d/m/Y \à\s H:i') . '</em></p>';

        return $content;
    }

    /**
     * Gerar excerpt para post de serviço
     */
    private function generateServiceExcerpt($serviceType, $count, $localidade = null)
    {
        $locationText = $localidade ? " em {$localidade}" : " no município";
        return "Secretaria Municipal de Agricultura conclui {$count} serviços{$locationText}, reforçando o compromisso com a melhoria da infraestrutura municipal.";
    }

    /**
     * Adicionar tags ao post
     */
    private function addPostTags($post, $tagNames)
    {
        $tagIds = [];
        
        foreach ($tagNames as $tagName) {
            if (!empty($tagName)) {
                $tag = \Modules\Blog\App\Models\BlogTag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
        }
        
        $post->tags()->sync($tagIds);
    }

    /**
     * Obter nome do mês
     */
    private function getMonthName($month)
    {
        $months = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
            5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
            9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        return $months[(int)$month] ?? 'Mês';
    }
}
