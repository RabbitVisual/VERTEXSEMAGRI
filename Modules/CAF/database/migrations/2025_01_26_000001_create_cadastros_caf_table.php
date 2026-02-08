<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadastros_caf', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo')->unique()->nullable(); // Protocolo público
            $table->string('codigo')->unique(); // Código interno
            
            // Relacionamento com PessoaCad (base municipal)
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas_cad')->onDelete('set null');
            
            // Relacionamento com Funcionario (cadastrador)
            $table->foreignId('funcionario_id')->nullable()->constrained('funcionarios')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Dados pessoais do agricultor
            $table->string('nome_completo');
            $table->string('cpf', 11)->unique();
            $table->string('rg')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('sexo', ['M', 'F', 'Outro'])->nullable();
            $table->string('estado_civil')->nullable(); // solteiro, casado, divorciado, viuvo, uniao_estavel
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            
            // Endereço
            $table->string('cep')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            
            // Relacionamento com Localidade
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            
            // Status do cadastro
            $table->enum('status', ['rascunho', 'em_andamento', 'completo', 'aprovado', 'rejeitado', 'enviado_caf'])->default('rascunho');
            $table->text('observacoes')->nullable();
            
            // Data de envio para sistema oficial CAF
            $table->timestamp('enviado_caf_at')->nullable();
            $table->string('protocolo_caf_oficial')->nullable(); // Protocolo retornado pelo sistema oficial
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('cpf');
            $table->index('status');
            $table->index('funcionario_id');
            $table->index('localidade_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadastros_caf');
    }
};

