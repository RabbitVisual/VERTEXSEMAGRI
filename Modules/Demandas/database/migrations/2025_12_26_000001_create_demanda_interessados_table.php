<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela para armazenar múltiplos interessados/afetados por uma demanda
     * Permite vincular várias pessoas à mesma demanda sem criar duplicatas
     */
    public function up(): void
    {
        Schema::create('demanda_interessados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demanda_id')->constrained('demandas')->onDelete('cascade');
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas_cad')->onDelete('set null');

            // Dados do interessado (caso não tenha pessoa_id vinculada)
            $table->string('nome');
            $table->string('apelido')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('cpf', 14)->nullable();

            // Informações adicionais do interessado
            $table->text('descricao_adicional')->nullable(); // Descrição adicional que o interessado forneceu
            $table->json('fotos')->nullable(); // Fotos adicionais do interessado

            // Metadados
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Quem registrou
            $table->string('ip_address', 45)->nullable(); // IP de quem registrou (para auditoria)
            $table->boolean('notificar')->default(true); // Se deve notificar sobre atualizações
            $table->boolean('confirmado')->default(false); // Se confirmou por email/telefone
            $table->timestamp('data_vinculo')->useCurrent();

            // Pontuação de similaridade quando foi vinculado automaticamente
            $table->decimal('score_similaridade', 5, 2)->nullable();
            $table->string('metodo_vinculo')->default('manual'); // manual, automatico, sugestao_aceita

            $table->timestamps();

            // Índices para performance
            $table->index(['demanda_id', 'pessoa_id']);
            $table->index(['demanda_id', 'email']);
            $table->index(['demanda_id', 'telefone']);
            $table->index('cpf');

            // Evitar duplicatas: mesma pessoa não pode ser vinculada duas vezes à mesma demanda
            $table->unique(['demanda_id', 'pessoa_id'], 'unique_demanda_pessoa');
            $table->unique(['demanda_id', 'cpf'], 'unique_demanda_cpf');
        });

        // Adicionar coluna na tabela demandas para contagem de interessados (desnormalização para performance)
        Schema::table('demandas', function (Blueprint $table) {
            $table->unsignedInteger('total_interessados')->default(1)->after('observacoes');
            $table->decimal('score_similaridade_max', 5, 2)->nullable()->after('total_interessados');
            $table->text('palavras_chave')->nullable()->after('score_similaridade_max'); // Cache de palavras-chave extraídas
        });
    }

    public function down(): void
    {
        Schema::table('demandas', function (Blueprint $table) {
            $table->dropColumn(['total_interessados', 'score_similaridade_max', 'palavras_chave']);
        });

        Schema::dropIfExists('demanda_interessados');
    }
};

