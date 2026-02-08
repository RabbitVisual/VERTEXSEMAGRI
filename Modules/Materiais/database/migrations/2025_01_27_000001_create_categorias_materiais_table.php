<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Ex: Elétrica, Hidráulica, Máquinas
            $table->string('slug')->unique(); // Ex: eletrica, hidraulica, maquinas
            $table->string('icone')->nullable(); // Nome do ícone
            $table->text('descricao')->nullable();
            $table->integer('ordem')->default(0); // Ordem de exibição
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('ativo');
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_materiais');
    }
};

