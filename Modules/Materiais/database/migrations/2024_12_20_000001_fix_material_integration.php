<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Remove redundância do campo materiais_utilizados (JSON) da tabela ordens_servico
     * Adiciona funcionario_id nas movimentações para rastreamento completo
     */
    public function up(): void
    {
        // Remover campo redundante materiais_utilizados da tabela ordens_servico
        if (Schema::hasTable('ordens_servico')) {
            Schema::table('ordens_servico', function (Blueprint $table) {
                if (Schema::hasColumn('ordens_servico', 'materiais_utilizados')) {
                    $table->dropColumn('materiais_utilizados');
                }
            });
        }

        // Adicionar funcionario_id na tabela material_movimentacoes para rastreamento
        if (Schema::hasTable('material_movimentacoes')) {
            Schema::table('material_movimentacoes', function (Blueprint $table) {
                if (!Schema::hasColumn('material_movimentacoes', 'funcionario_id')) {
                    $table->foreignId('funcionario_id')->nullable()->after('user_id');
                    if (Schema::hasTable('funcionarios')) {
                        $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('set null');
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
        // Reverter: adicionar campo materiais_utilizados de volta
        if (Schema::hasTable('ordens_servico')) {
            Schema::table('ordens_servico', function (Blueprint $table) {
                if (!Schema::hasColumn('ordens_servico', 'materiais_utilizados')) {
                    $table->json('materiais_utilizados')->nullable()->after('relatorio_execucao');
                }
            });
        }

        // Reverter: remover funcionario_id
        if (Schema::hasTable('material_movimentacoes')) {
            Schema::table('material_movimentacoes', function (Blueprint $table) {
                if (Schema::hasColumn('material_movimentacoes', 'funcionario_id')) {
                    $table->dropForeign(['funcionario_id']);
                    $table->dropColumn('funcionario_id');
                }
            });
        }
    }
};

