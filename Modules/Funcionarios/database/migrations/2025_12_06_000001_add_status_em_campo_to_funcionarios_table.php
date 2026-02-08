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
        Schema::table('funcionarios', function (Blueprint $table) {
            // Status em campo: disponivel, em_atendimento, pausado, offline
            $table->string('status_campo')->default('disponivel')->after('ativo');

            // ID da ordem que está sendo atendida atualmente (null se disponível)
            $table->unsignedBigInteger('ordem_servico_atual_id')->nullable()->after('status_campo');

            // Data/hora de início do atendimento atual
            $table->timestamp('atendimento_iniciado_em')->nullable()->after('ordem_servico_atual_id');

            // Última atualização de status (para monitoramento)
            $table->timestamp('ultima_atualizacao_status')->nullable()->after('atendimento_iniciado_em');

            // Foreign key
            $table->foreign('ordem_servico_atual_id')
                ->references('id')
                ->on('ordens_servico')
                ->onDelete('set null');

            // Índices para performance
            $table->index('status_campo');
            $table->index(['status_campo', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropForeign(['ordem_servico_atual_id']);
            $table->dropIndex(['status_campo']);
            $table->dropIndex(['status_campo', 'ativo']);
            $table->dropColumn([
                'status_campo',
                'ordem_servico_atual_id',
                'atendimento_iniciado_em',
                'ultima_atualizacao_status',
            ]);
        });
    }
};

