<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('usuarios_poco')) {
            return;
        }

        Schema::create('usuarios_poco', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas_cad')->onDelete('set null');
            $table->string('nome');
            $table->string('cpf', 11)->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->text('endereco');
            $table->string('numero_casa')->nullable();
            $table->string('codigo_acesso')->unique(); // Código para o morador acessar sua área
            $table->enum('status', ['ativo', 'inativo', 'suspenso'])->default('ativo');
            $table->date('data_cadastro');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('poco_id');
            $table->index('pessoa_id');
            $table->index('codigo_acesso');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios_poco');
    }
};

