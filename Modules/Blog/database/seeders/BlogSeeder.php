<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Blog\App\Models\BlogTag;
use Modules\Blog\App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar categorias
        $categories = [
            [
                'name' => 'Notícias Gerais',
                'slug' => 'noticias-gerais',
                'description' => 'Notícias e informações gerais da secretaria',
                'color' => '#3B82F6',
                'icon' => 'newspaper',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Serviços Realizados',
                'slug' => 'servicos-realizados',
                'description' => 'Informações sobre serviços concluídos pela secretaria',
                'color' => '#10B981',
                'icon' => 'check-circle',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Relatórios Mensais',
                'slug' => 'relatorios-mensais',
                'description' => 'Relatórios mensais automáticos com estatísticas dos serviços',
                'color' => '#059669',
                'icon' => 'chart-bar',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Agricultura Familiar',
                'slug' => 'agricultura-familiar',
                'description' => 'Notícias e programas relacionados à agricultura familiar',
                'color' => '#F59E0B',
                'icon' => 'leaf',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Infraestrutura',
                'slug' => 'infraestrutura',
                'description' => 'Melhorias em infraestrutura rural e urbana',
                'color' => '#8B5CF6',
                'icon' => 'cog',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Criar tags
        $tags = [
            'agricultura', 'infraestrutura', 'água', 'poços', 'iluminação', 'estradas',
            'comunidade', 'desenvolvimento', 'sustentabilidade', 'tecnologia',
            'inovação', 'meio ambiente', 'qualidade de vida', 'transparência',
            'prestação de contas', 'participação popular', 'cidadania'
        ];

        foreach ($tags as $tagName) {
            BlogTag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                [
                    'name' => $tagName,
                    'slug' => Str::slug($tagName),
                    'color' => '#6B7280'
                ]
            );
        }

        // Criar post de exemplo se não existir
        $user = User::first();
        if ($user) {
            $category = BlogCategory::where('slug', 'noticias-gerais')->first();
            
            $existingPost = BlogPost::where('slug', 'bem-vindos-ao-blog-vertexsemagri')->first();
            
            if (!$existingPost && $category) {
                $post = BlogPost::create([
                    'title' => 'Bem-vindos ao Blog VERTEXSEMAGRI',
                    'slug' => 'bem-vindos-ao-blog-vertexsemagri',
                    'excerpt' => 'Apresentamos o novo blog oficial da Secretaria Municipal de Agricultura, um espaço dedicado à transparência e comunicação com a população.',
                    'content' => $this->getWelcomePostContent(),
                    'category_id' => $category->id,
                    'author_id' => $user->id,
                    'status' => 'published',
                    'published_at' => now(),
                    'is_featured' => true,
                    'allow_comments' => true,
                    'meta_title' => 'Bem-vindos ao Blog VERTEXSEMAGRI - Transparência e Comunicação',
                    'meta_description' => 'Conheça o novo blog oficial da Secretaria Municipal de Agricultura de Coração de Maria - BA. Um espaço dedicado à transparência e comunicação com a população.',
                    'meta_keywords' => ['blog', 'vertexsemagri', 'transparência', 'agricultura', 'coração de maria']
                ]);

                // Adicionar tags ao post
                $postTags = BlogTag::whereIn('slug', ['agricultura', 'transparencia', 'comunidade', 'tecnologia'])->get();
                $post->tags()->attach($postTags->pluck('id'));
            }
        }
    }

    private function getWelcomePostContent()
    {
        return "# Bem-vindos ao Blog VERTEXSEMAGRI!

É com grande satisfação que apresentamos o **novo blog oficial** da Secretaria Municipal de Agricultura de Coração de Maria - BA. Este espaço foi criado com o objetivo de fortalecer a comunicação entre a administração pública e nossa comunidade.

## Nosso Objetivo

Este blog representa nosso compromisso com a **transparência** e a **prestação de contas**. Aqui você encontrará:

- **Notícias atualizadas** sobre os serviços realizados
- **Relatórios mensais** com estatísticas detalhadas
- **Informações sobre programas** de agricultura familiar
- **Acompanhamento de projetos** de infraestrutura rural
- **Dados em tempo real** extraídos do sistema VERTEXSEMAGRI

## Tecnologia a Serviço da Transparência

Nosso blog é integrado ao sistema VERTEXSEMAGRI, o que significa que:

- **Dados precisos**: Todas as informações são extraídas diretamente do sistema
- **Atualizações automáticas**: Relatórios são gerados automaticamente
- **Transparência total**: Acesso completo às atividades da secretaria
- **Facilidade de acesso**: Interface moderna e responsiva

## Integração com Outros Módulos

O blog está conectado com todos os módulos do sistema:

- **Demandas**: Acompanhe as solicitações da população
- **Ordens de Serviço**: Veja os serviços em execução
- **Materiais**: Controle de recursos utilizados
- **Poços**: Manutenção da infraestrutura hídrica
- **Iluminação**: Melhorias na iluminação pública
- **Estradas**: Conservação das vias rurais

## Participação da Comunidade

Acreditamos que a participação popular é fundamental para uma gestão eficiente. Por isso:

- **Comentários liberados**: Participe das discussões
- **Sugestões bem-vindas**: Sua opinião é importante
- **Transparência ativa**: Dados sempre atualizados
- **Canais abertos**: Múltiplas formas de contato

## Acessibilidade

O blog foi desenvolvido pensando em todos os cidadãos:

- **Design responsivo**: Funciona em celulares, tablets e computadores
- **Modo escuro**: Conforto visual em qualquer horário
- **Navegação intuitiva**: Fácil de usar para todas as idades
- **Carregamento rápido**: Otimizado para conexões lentas

## Compromisso com a Qualidade

Este é apenas o início de uma nova era na comunicação pública em Coração de Maria. Estamos comprometidos em:

1. **Manter informações sempre atualizadas**
2. **Responder às dúvidas da comunidade**
3. **Melhorar continuamente nossos serviços**
4. **Garantir transparência total em nossas ações**

## Fique Conectado

Além do blog, você pode nos acompanhar através de:

- **Portal de Transparência**: Dados detalhados sobre infraestrutura
- **Sistema VERTEXSEMAGRI**: Consultas e solicitações online
- **Atendimento presencial**: Secretaria Municipal de Agricultura
- **Telefone**: (75) 3248-2489

---

**Obrigado por nos acompanhar!** 

Juntos, construiremos uma Coração de Maria cada vez melhor. 

*Equipe VERTEXSEMAGRI*  
*Secretaria Municipal de Agricultura*";
    }
}
