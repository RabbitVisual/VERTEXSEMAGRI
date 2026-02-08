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
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->text('conteudo')->nullable();
            $table->enum('tipo', ['info', 'success', 'warning', 'danger', 'promocao', 'novidade', 'anuncio'])->default('info');
            $table->enum('posicao', ['topo', 'meio', 'rodape', 'flutuante'])->default('topo');
            $table->enum('estilo', ['banner', 'announcement', 'cta', 'modal', 'toast'])->default('banner');
            $table->string('cor_primaria')->nullable();
            $table->string('cor_secundaria')->nullable();
            $table->string('imagem')->nullable();
            $table->string('url_acao')->nullable();
            $table->string('texto_botao')->nullable();
            $table->boolean('botao_exibir')->default(true);
            $table->boolean('dismissivel')->default(false);
            $table->boolean('ativo')->default(true);
            $table->boolean('destacar')->default(false);
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_fim')->nullable();
            $table->integer('ordem')->default(0);
            $table->integer('visualizacoes')->default(0);
            $table->integer('cliques')->default(0);
            $table->json('configuracoes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['ativo', 'data_inicio', 'data_fim'], 'avisos_ativos_index');
            $table->index(['tipo', 'ativo'], 'avisos_tipo_ativo_index');
            $table->index(['posicao', 'ativo'], 'avisos_posicao_ativo_index');
            $table->index(['ordem'], 'avisos_ordem_index');
            $table->index(['created_at'], 'avisos_created_at_index');

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};

