<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('demanda_id')->nullable()->constrained('demandas')->onDelete('set null');
            $table->foreignId('equipe_id')->nullable()->constrained('equipes')->onDelete('set null');
            $table->string('tipo_servico');
            $table->text('descricao');
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('status', ['pendente', 'em_execucao', 'concluida', 'cancelada'])->default('pendente');
            $table->timestamp('data_abertura')->useCurrent();
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->integer('tempo_execucao')->nullable(); // em minutos
            $table->json('fotos_antes')->nullable();
            $table->json('fotos_depois')->nullable();
            $table->text('relatorio_execucao')->nullable();
            // Campo materiais_utilizados removido - usar tabela ordem_servico_materiais
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id_abertura')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id_execucao')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_servico');
    }
};

