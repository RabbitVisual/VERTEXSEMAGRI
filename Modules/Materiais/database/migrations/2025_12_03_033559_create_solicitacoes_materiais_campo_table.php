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
        Schema::create('solicitacoes_materiais_campo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Funcionário que solicitou
            $table->foreignId('ordem_servico_id')->nullable()->constrained('ordens_servico')->onDelete('set null'); // OS relacionada (opcional)
            $table->foreignId('material_id')->nullable()->constrained('materiais')->onDelete('set null'); // Se material existe no sistema
            $table->string('material_nome'); // Nome do material (pode ser customizado)
            $table->string('material_codigo')->nullable(); // Código se existir
            $table->decimal('quantidade', 10, 2);
            $table->string('unidade_medida', 50);
            $table->text('justificativa');
            $table->enum('status', ['pendente', 'processada', 'cancelada'])->default('pendente');
            $table->foreignId('processado_por')->nullable()->constrained('users')->onDelete('set null'); // Admin que processou
            $table->foreignId('solicitacao_material_id')->nullable()->constrained('solicitacoes_materiais')->onDelete('set null'); // ID da solicitação oficial criada
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('status');
            $table->index('user_id');
            $table->index('ordem_servico_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_materiais_campo');
    }
};
