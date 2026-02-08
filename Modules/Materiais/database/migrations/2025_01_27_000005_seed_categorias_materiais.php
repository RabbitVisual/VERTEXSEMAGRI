<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Inserir categorias principais
        $categorias = [
            ['nome' => 'Elétrica', 'slug' => 'eletrica', 'icone' => 'bolt', 'ordem' => 1, 'descricao' => 'Materiais elétricos e componentes'],
            ['nome' => 'Hidráulica', 'slug' => 'hidraulica', 'icone' => 'droplet', 'ordem' => 2, 'descricao' => 'Materiais hidráulicos e conexões'],
            ['nome' => 'Máquinas e Equipamentos', 'slug' => 'maquinas-equipamentos', 'icone' => 'cog', 'ordem' => 3, 'descricao' => 'Peças e componentes para máquinas'],
            ['nome' => 'Lubrificantes', 'slug' => 'lubrificantes', 'icone' => 'beaker', 'ordem' => 4, 'descricao' => 'Óleos, graxas e combustíveis'],
            ['nome' => 'Segurança e EPI', 'slug' => 'seguranca-epi', 'icone' => 'shield-check', 'ordem' => 5, 'descricao' => 'Equipamentos de proteção individual'],
            ['nome' => 'Ferramentas', 'slug' => 'ferramentas', 'icone' => 'wrench-screwdriver', 'ordem' => 6, 'descricao' => 'Ferramentas diversas'],
            ['nome' => 'Outros', 'slug' => 'outros', 'icone' => 'cube', 'ordem' => 7, 'descricao' => 'Outros materiais'],
        ];

        foreach ($categorias as $categoria) {
            $categoriaId = DB::table('categorias_materiais')->insertGetId([
                'nome' => $categoria['nome'],
                'slug' => $categoria['slug'],
                'icone' => $categoria['icone'],
                'descricao' => $categoria['descricao'],
                'ordem' => $categoria['ordem'],
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Inserir subcategorias para cada categoria
            $subcategorias = $this->getSubcategorias($categoria['slug']);

            foreach ($subcategorias as $subcat) {
                $subcategoriaId = DB::table('subcategorias_materiais')->insertGetId([
                    'categoria_id' => $categoriaId,
                    'nome' => $subcat['nome'],
                    'slug' => $subcat['slug'],
                    'descricao' => $subcat['descricao'] ?? null,
                    'ordem' => $subcat['ordem'] ?? 0,
                    'ativo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Inserir campos específicos para cada subcategoria
                $campos = $this->getCampos($subcat['slug']);

                foreach ($campos as $campo) {
                    DB::table('campos_categoria_material')->insert([
                        'subcategoria_id' => $subcategoriaId,
                        'nome' => $campo['nome'],
                        'slug' => $campo['slug'],
                        'tipo' => $campo['tipo'],
                        'opcoes' => isset($campo['opcoes']) ? json_encode($campo['opcoes']) : null,
                        'placeholder' => $campo['placeholder'] ?? null,
                        'descricao' => $campo['descricao'] ?? null,
                        'obrigatorio' => $campo['obrigatorio'] ?? false,
                        'ordem' => $campo['ordem'] ?? 0,
                        'ativo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function getSubcategorias(string $categoriaSlug): array
    {
        $subcategorias = [
            'eletrica' => [
                ['nome' => 'Lâmpadas', 'slug' => 'lampadas', 'ordem' => 1],
                ['nome' => 'Reatores', 'slug' => 'reatores', 'ordem' => 2],
                ['nome' => 'Fios Elétricos', 'slug' => 'fios-eletricos', 'ordem' => 3],
                ['nome' => 'Cabos Elétricos', 'slug' => 'cabos-eletricos', 'ordem' => 4],
                ['nome' => 'Disjuntores', 'slug' => 'disjuntores', 'ordem' => 5],
                ['nome' => 'Tomadas e Interruptores', 'slug' => 'tomadas-interruptores', 'ordem' => 6],
                ['nome' => 'Relé Fotoeletrônico', 'slug' => 'rele-fotoeletronico', 'ordem' => 7],
            ],
            'hidraulica' => [
                ['nome' => 'Canos', 'slug' => 'canos', 'ordem' => 1],
                ['nome' => 'Tubos PVC', 'slug' => 'tubos-pvc', 'ordem' => 2],
                ['nome' => 'Conexões', 'slug' => 'conexoes', 'ordem' => 3],
                ['nome' => 'Conexões Hidráulicas', 'slug' => 'conexoes-hidraulicas', 'ordem' => 4],
                ['nome' => 'Válvulas', 'slug' => 'valvulas', 'ordem' => 5],
                ['nome' => 'Registros', 'slug' => 'registros', 'ordem' => 6],
                ['nome' => 'Bomba Poço Artesiano', 'slug' => 'bomba-poco-artesiano', 'ordem' => 7],
                ['nome' => 'Peças para Poços', 'slug' => 'pecas-pocos', 'ordem' => 8],
            ],
            'maquinas-equipamentos' => [
                ['nome' => 'Peças para Trator', 'slug' => 'pecas-trator', 'ordem' => 1],
                ['nome' => 'Peças para Retroescavadeira', 'slug' => 'pecas-retroescavadeira', 'ordem' => 2],
                ['nome' => 'Peças para Caçamba', 'slug' => 'pecas-cacamba', 'ordem' => 3],
                ['nome' => 'Peças para Máquinas', 'slug' => 'pecas-maquinas', 'ordem' => 4],
                ['nome' => 'Filtros de Óleo', 'slug' => 'filtros-oleo', 'ordem' => 5],
                ['nome' => 'Filtros de Combustível', 'slug' => 'filtros-combustivel', 'ordem' => 6],
                ['nome' => 'Pneus', 'slug' => 'pneus', 'ordem' => 7],
                ['nome' => 'Baterias', 'slug' => 'baterias', 'ordem' => 8],
            ],
            'lubrificantes' => [
                ['nome' => 'Óleo de Motor', 'slug' => 'oleo-motor', 'ordem' => 1],
                ['nome' => 'Óleo Hidráulico', 'slug' => 'oleo-hidraulico', 'ordem' => 2],
                ['nome' => 'Graxa', 'slug' => 'graxa', 'ordem' => 3],
                ['nome' => 'Combustível', 'slug' => 'combustivel', 'ordem' => 4],
            ],
            'seguranca-epi' => [
                ['nome' => 'EPI', 'slug' => 'epi', 'ordem' => 1],
                ['nome' => 'Roupa Eletricista', 'slug' => 'roupa-eletricista', 'ordem' => 2],
                ['nome' => 'Equipamentos de Segurança', 'slug' => 'equipamentos-seguranca', 'ordem' => 3],
                ['nome' => 'Sinalização', 'slug' => 'sinalizacao', 'ordem' => 4],
            ],
            'ferramentas' => [
                ['nome' => 'Ferramentas', 'slug' => 'ferramentas', 'ordem' => 1],
            ],
            'outros' => [
                ['nome' => 'Fios (Genérico)', 'slug' => 'fios-generico', 'ordem' => 1],
                ['nome' => 'Outros', 'slug' => 'outros', 'ordem' => 2],
            ],
        ];

        return $subcategorias[$categoriaSlug] ?? [];
    }

    private function getCampos(string $subcategoriaSlug): array
    {
        $campos = [
            'lampadas' => [
                ['nome' => 'Potência (W)', 'slug' => 'potencia_w', 'tipo' => 'number', 'placeholder' => 'Ex: 20, 40, 60', 'descricao' => 'Potência da lâmpada em watts', 'obrigatorio' => false, 'ordem' => 1],
                ['nome' => 'Tipo', 'slug' => 'tipo', 'tipo' => 'select', 'opcoes' => ['LED', 'Fluorescente', 'Incandescente', 'Halógena', 'Vapor de Sódio', 'Vapor de Mercúrio'], 'descricao' => 'Tipo de tecnologia', 'obrigatorio' => false, 'ordem' => 2],
                ['nome' => 'Tensão (V)', 'slug' => 'tensao_v', 'tipo' => 'text', 'placeholder' => 'Ex: 127V ou 220V', 'descricao' => 'Tensão de operação', 'obrigatorio' => false, 'ordem' => 3],
                ['nome' => 'Cor da Luz', 'slug' => 'cor_luz', 'tipo' => 'select', 'opcoes' => ['Branca Quente', 'Branca Fria', 'Amarela', 'Colorida'], 'descricao' => 'Temperatura de cor', 'obrigatorio' => false, 'ordem' => 4],
                ['nome' => 'Marca', 'slug' => 'marca', 'tipo' => 'text', 'placeholder' => 'Ex: Philips, Osram', 'descricao' => 'Marca da lâmpada', 'obrigatorio' => false, 'ordem' => 5],
            ],
            'reatores' => [
                ['nome' => 'Potência (W)', 'slug' => 'potencia_w', 'tipo' => 'number', 'placeholder' => 'Ex: 20, 40, 60', 'descricao' => 'Potência do reator em watts', 'obrigatorio' => false, 'ordem' => 1],
                ['nome' => 'Tipo', 'slug' => 'tipo', 'tipo' => 'select', 'opcoes' => ['Eletrônico', 'Magnético'], 'descricao' => 'Tipo de reator', 'obrigatorio' => false, 'ordem' => 2],
                ['nome' => 'Tensão (V)', 'slug' => 'tensao_v', 'tipo' => 'text', 'placeholder' => 'Ex: 127V ou 220V', 'descricao' => 'Tensão de operação', 'obrigatorio' => false, 'ordem' => 3],
            ],
            'bomba-poco-artesiano' => [
                ['nome' => 'Potência (HP)', 'slug' => 'potencia_hp', 'tipo' => 'number', 'placeholder' => 'Ex: 1, 2, 5', 'descricao' => 'Potência da bomba em HP', 'obrigatorio' => false, 'ordem' => 1],
                ['nome' => 'Vazão (L/h)', 'slug' => 'vazao_lh', 'tipo' => 'number', 'placeholder' => 'Ex: 1000, 2000', 'descricao' => 'Vazão em litros por hora', 'obrigatorio' => false, 'ordem' => 2],
                ['nome' => 'Profundidade Máxima (m)', 'slug' => 'profundidade_max', 'tipo' => 'number', 'placeholder' => 'Ex: 50, 100', 'descricao' => 'Profundidade máxima de instalação', 'obrigatorio' => false, 'ordem' => 3],
                ['nome' => 'Marca', 'slug' => 'marca', 'tipo' => 'text', 'placeholder' => 'Ex: Schneider, WEG', 'descricao' => 'Marca da bomba', 'obrigatorio' => false, 'ordem' => 4],
            ],
            'pneus' => [
                ['nome' => 'Aro', 'slug' => 'aro', 'tipo' => 'text', 'placeholder' => 'Ex: 13, 14, 15', 'descricao' => 'Tamanho do aro', 'obrigatorio' => false, 'ordem' => 1],
                ['nome' => 'Largura', 'slug' => 'largura', 'tipo' => 'text', 'placeholder' => 'Ex: 175, 185, 195', 'descricao' => 'Largura do pneu', 'obrigatorio' => false, 'ordem' => 2],
                ['nome' => 'Perfil', 'slug' => 'perfil', 'tipo' => 'text', 'placeholder' => 'Ex: 70, 75, 80', 'descricao' => 'Perfil do pneu', 'obrigatorio' => false, 'ordem' => 3],
                ['nome' => 'Marca', 'slug' => 'marca', 'tipo' => 'text', 'placeholder' => 'Ex: Michelin, Pirelli', 'descricao' => 'Marca do pneu', 'obrigatorio' => false, 'ordem' => 4],
            ],
            'baterias' => [
                ['nome' => 'Voltagem (V)', 'slug' => 'voltagem_v', 'tipo' => 'number', 'placeholder' => 'Ex: 12, 24', 'descricao' => 'Voltagem da bateria', 'obrigatorio' => false, 'ordem' => 1],
                ['nome' => 'Capacidade (Ah)', 'slug' => 'capacidade_ah', 'tipo' => 'number', 'placeholder' => 'Ex: 50, 100, 200', 'descricao' => 'Capacidade em Ampere-hora', 'obrigatorio' => false, 'ordem' => 2],
                ['nome' => 'Tipo', 'slug' => 'tipo', 'tipo' => 'select', 'opcoes' => ['Chumbo-Ácido', 'Selada', 'Gel', 'Lítio'], 'descricao' => 'Tipo de bateria', 'obrigatorio' => false, 'ordem' => 3],
                ['nome' => 'Marca', 'slug' => 'marca', 'tipo' => 'text', 'placeholder' => 'Ex: Moura, Heliar', 'descricao' => 'Marca da bateria', 'obrigatorio' => false, 'ordem' => 4],
            ],
        ];

        return $campos[$subcategoriaSlug] ?? [];
    }

    public function down(): void
    {
        DB::table('campos_categoria_material')->truncate();
        DB::table('subcategorias_materiais')->truncate();
        DB::table('categorias_materiais')->truncate();
    }
};

