<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitacoes_materiais', function (Blueprint $table) {
            $table->id();
            $table->string('numero_oficio')->unique(); // Número único do ofício (ex: 001/2025-SI/SA)
            $table->integer('numero_sequencial'); // Número sequencial do ano
            $table->integer('ano'); // Ano da solicitação
            $table->string('cidade');
            $table->date('data');

            // Informações do Secretário
            $table->string('secretario_nome');
            $table->string('secretario_cargo');

            // Informações do Servidor Responsável
            $table->string('servidor_nome');
            $table->string('servidor_cargo');
            $table->string('servidor_telefone')->nullable();
            $table->string('servidor_email')->nullable();

            // Materiais solicitados (JSON)
            $table->json('materiais'); // Array com materiais do sistema e customizados

            // Observações
            $table->text('observacoes')->nullable();

            // Controle
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuário que gerou
            $table->string('hash_documento')->unique(); // Hash para garantir integridade
            $table->string('caminho_pdf')->nullable(); // Caminho do PDF gerado (se salvo)

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['ano', 'numero_sequencial']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_materiais');
    }
};

