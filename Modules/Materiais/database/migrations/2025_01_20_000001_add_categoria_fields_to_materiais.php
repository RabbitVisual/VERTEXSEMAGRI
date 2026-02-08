<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materiais', function (Blueprint $table) {
            // Adicionar campo JSON para campos específicos por categoria
            if (!Schema::hasColumn('materiais', 'campos_especificos')) {
                $table->json('campos_especificos')->nullable()->after('localizacao_estoque');
            }

            // Adicionar campo para rastrear último alerta de estoque baixo
            if (!Schema::hasColumn('materiais', 'ultimo_alerta_estoque')) {
                $table->timestamp('ultimo_alerta_estoque')->nullable()->after('campos_especificos');
            }
        });

        // Atualizar enum de categorias para incluir novas categorias
        if (Schema::hasColumn('materiais', 'categoria') && DB::getDriverName() !== 'sqlite') {
            // MySQL-specific syntax
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
        // Skip ENUM modification for SQLite
    }

    public function down(): void
    {
        Schema::table('materiais', function (Blueprint $table) {
            $table->dropColumn(['campos_especificos', 'ultimo_alerta_estoque']);
        });

        if (DB::getDriverName() !== 'sqlite') {
            // Reverter enum para versão anterior (MySQL only)
            DB::statement("ALTER TABLE materiais MODIFY COLUMN categoria ENUM(
                'lampadas',
                'reatores',
                'fios',
                'canos',
                'conexoes',
                'combustivel',
                'pecas_pocos',
                'outros'
            ) NOT NULL");
        }
    }
};
