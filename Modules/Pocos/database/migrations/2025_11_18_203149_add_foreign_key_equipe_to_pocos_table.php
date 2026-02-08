<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar se a tabela equipes existe antes de adicionar foreign key
        if (Schema::hasTable('equipes') && Schema::hasTable('pocos')) {
            Schema::table('pocos', function (Blueprint $table) {
                // Verificar se a coluna existe e não tem foreign key ainda
                if (Schema::hasColumn('pocos', 'equipe_responsavel_id')) {
                    // Tentar adicionar a foreign key (pode falhar se já existir, mas isso é ok)
                    try {
                        $table->foreign('equipe_responsavel_id')
                            ->references('id')
                            ->on('equipes')
                            ->onDelete('set null');
                    } catch (\Exception $e) {
                        // Foreign key já existe, ignorar
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pocos', function (Blueprint $table) {
            if (Schema::hasTable('equipes')) {
                $table->dropForeign(['equipe_responsavel_id']);
            }
        });
    }
};
