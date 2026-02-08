<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Expandir enum de categorias com novas categorias profissionais
        if (Schema::hasColumn('materiais', 'categoria')) {
            DB::statement("ALTER TABLE materiais MODIFY COLUMN categoria ENUM(
                'lampadas',
                'reatores',
                'fios',
                'canos',
                'conexoes',
                'combustivel',
                'pecas_pocos',
                'rele_fotoeletronico',
                'bomba_poco_artesiano',
                'roupa_eletricista',
                'epi',
                'ferramentas',
                'fios_eletricos',
                'disjuntores',
                'tomadas_interruptores',
                'cabos_eletricos',
                'tubos_pvc',
                'conexoes_hidraulicas',
                'valvulas',
                'registros',
                'pecas_maquinas',
                'filtros_oleo',
                'filtros_combustivel',
                'pneus',
                'baterias',
                'oleo_motor',
                'oleo_hidraulico',
                'graxa',
                'pecas_trator',
                'pecas_retroescavadeira',
                'pecas_cacamba',
                'equipamentos_seguranca',
                'sinalizacao',
                'outros'
            ) NOT NULL");
        }
    }

    public function down(): void
    {
        // Reverter para versão anterior
        if (Schema::hasColumn('materiais', 'categoria')) {
            DB::statement("ALTER TABLE materiais MODIFY COLUMN categoria ENUM(
                'lampadas',
                'reatores',
                'fios',
                'canos',
                'conexoes',
                'combustivel',
                'pecas_pocos',
                'rele_fotoeletronico',
                'bomba_poco_artesiano',
                'roupa_eletricista',
                'epi',
                'ferramentas',
                'outros'
            ) NOT NULL");
        }
    }
};

