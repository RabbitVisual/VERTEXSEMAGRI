<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('tipo', [
                'seguro_safra',
                'pronaf',
                'distribuicao_sementes',
                'distribuicao_insumos',
                'assistencia_tecnica',
                'credito_rural',
                'feira_agricola',
                'capacitacao',
                'outro'
            ]);
            $table->enum('status', ['ativo', 'inativo', 'suspenso'])->default('ativo');
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->integer('vagas_disponiveis')->nullable();
            $table->integer('vagas_preenchidas')->default(0);
            $table->text('requisitos')->nullable();
            $table->text('documentos_necessarios')->nullable();
            $table->text('beneficios')->nullable();
            $table->string('orgao_responsavel')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('publico')->default(true); // Se aparece no portal público
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('tipo');
            $table->index('status');
            $table->index('publico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};

