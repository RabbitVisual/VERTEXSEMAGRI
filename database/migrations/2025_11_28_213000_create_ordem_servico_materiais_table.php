<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela para vincular materiais às ordens de serviço
     * Permite controle de estoque e custos por OS
     */
    public function up(): void
    {
        if (!Schema::hasTable('ordem_servico_materiais')) {
            Schema::create('ordem_servico_materiais', function (Blueprint $table) {
                $table->id();

                // Ordem de Serviço
                $table->foreignId('ordem_servico_id')
                      ->constrained('ordens_servico')
                      ->onDelete('cascade');

                // Material
                $table->foreignId('material_id')
                      ->constrained('materiais')
                      ->onDelete('cascade');

                // Quantidade utilizada
                $table->decimal('quantidade', 10, 2)->default(0);

                // Valor unitário no momento do uso (histórico)
                $table->decimal('valor_unitario', 10, 2)->default(0);

                $table->timestamps();

                // Índices
                $table->index(['ordem_servico_id', 'material_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ordem_servico_materiais');
    }
};
