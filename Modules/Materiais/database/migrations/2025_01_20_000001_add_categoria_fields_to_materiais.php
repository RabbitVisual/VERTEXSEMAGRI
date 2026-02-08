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
            $table->json('campos_especificos')->nullable()->after('localizacao_estoque');

            // Adicionar campo para rastrear último alerta de estoque baixo
            $table->timestamp('ultimo_alerta_estoque')->nullable()->after('campos_especificos');
        });

        // Atualizar enum de categorias para incluir novas categorias
        // Como não podemos alterar enum diretamente, vamos usar DB::statement
        if (Schema::hasColumn('materiais', 'categoria')) {
            // Primeiro, vamos criar uma migration que altera o enum
            // Mas como isso é complexo, vamos fazer via alteração da coluna
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

    public function down(): void
    {
        Schema::table('materiais', function (Blueprint $table) {
            $table->dropColumn(['campos_especificos', 'ultimo_alerta_estoque']);
        });

        // Reverter enum para versão anterior
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
};

