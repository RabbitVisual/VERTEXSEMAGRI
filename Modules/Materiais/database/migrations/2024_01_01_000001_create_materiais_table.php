<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('materiais')) {
            return;
        }

        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique()->nullable();
            $table->enum('categoria', [
                'lampadas',
                'reatores',
                'fios',
                'canos',
                'conexoes',
                'combustivel',
                'pecas_pocos',
                'outros'
            ]);
            $table->string('unidade_medida')->default('unidade'); // unidade, metro, litro, kg
            $table->decimal('quantidade_estoque', 10, 2)->default(0);
            $table->decimal('quantidade_minima', 10, 2)->default(0);
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->string('fornecedor')->nullable();
            $table->string('localizacao_estoque')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        if (!Schema::hasTable('material_movimentacoes')) {
            Schema::create('material_movimentacoes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('material_id')->constrained('materiais')->onDelete('cascade');
                $table->enum('tipo', ['entrada', 'saida']);
                $table->decimal('quantidade', 10, 2);
                $table->decimal('valor_unitario', 10, 2)->nullable();
                $table->string('motivo');
                $table->foreignId('ordem_servico_id')->nullable();
                if (Schema::hasTable('ordens_servico')) {
                    $table->foreign('ordem_servico_id')->references('id')->on('ordens_servico')->onDelete('set null');
                }
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->text('observacoes')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ordem_servico_materiais') && Schema::hasTable('ordens_servico')) {
            Schema::create('ordem_servico_materiais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ordem_servico_id')->constrained('ordens_servico')->onDelete('cascade');
                $table->foreignId('material_id')->constrained('materiais')->onDelete('cascade');
                $table->decimal('quantidade', 10, 2);
                $table->decimal('valor_unitario', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ordem_servico_materiais');
        Schema::dropIfExists('material_movimentacoes');
        Schema::dropIfExists('materiais');
    }
};

