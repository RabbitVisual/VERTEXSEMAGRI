<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('funcionarios')) {
            Schema::create('funcionarios', function (Blueprint $table) {
                $table->id();
                $table->string('codigo')->unique()->nullable();
                $table->string('nome');
                $table->string('cpf', 14)->unique()->nullable();
                $table->string('telefone', 20)->nullable();
                $table->string('email')->nullable();
                $table->enum('funcao', ['eletricista', 'encanador', 'operador', 'motorista', 'supervisor', 'tecnico', 'outro'])->default('outro');
                $table->date('data_admissao')->nullable();
                $table->date('data_demissao')->nullable();
                $table->boolean('ativo')->default(true);
                $table->text('observacoes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Tabela pivot para relacionamento muitos-para-muitos entre Equipes e Funcionarios
        if (!Schema::hasTable('equipe_funcionarios')) {
            Schema::create('equipe_funcionarios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');
                $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
                $table->timestamps();

                $table->unique(['equipe_id', 'funcionario_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('equipe_funcionarios');
        Schema::dropIfExists('funcionarios');
    }
};

