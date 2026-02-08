<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategorias_materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_materiais')->onDelete('cascade');
            $table->string('nome'); // Ex: Lâmpadas, Reatores, Fios
            $table->string('slug')->unique(); // Ex: lampadas, reatores, fios
            $table->text('descricao')->nullable();
            $table->integer('ordem')->default(0); // Ordem de exibição dentro da categoria
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('categoria_id');
            $table->index('slug');
            $table->index('ativo');
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategorias_materiais');
    }
};

