<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('solicitante_nome');
            $table->string('solicitante_telefone')->nullable();
            $table->string('solicitante_email')->nullable();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->enum('tipo', ['agua', 'luz', 'estrada', 'poco']);
            $table->enum('prioridade', ['baixa', 'media', 'alta', 'urgente'])->default('media');
            $table->string('motivo');
            $table->text('descricao')->nullable();
            $table->enum('status', ['aberta', 'em_andamento', 'concluida', 'cancelada'])->default('aberta');
            $table->json('fotos')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('data_abertura')->useCurrent();
            $table->timestamp('data_conclusao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};

