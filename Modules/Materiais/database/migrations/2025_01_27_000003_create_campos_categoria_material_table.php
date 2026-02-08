<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campos_categoria_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategoria_id')->nullable()->constrained('subcategorias_materiais')->onDelete('cascade');
            $table->string('nome'); // Ex: Potência, Tensão, Cor da Luz
            $table->string('slug'); // Ex: potencia, tensao, cor_luz
            $table->enum('tipo', ['text', 'number', 'select', 'textarea', 'date', 'boolean'])->default('text');
            $table->text('opcoes')->nullable(); // JSON para select: ["LED", "Fluorescente", "Incandescente"]
            $table->string('placeholder')->nullable(); // Ex: "Ex: 20, 40, 60"
            $table->text('descricao')->nullable(); // Ex: "Potência da lâmpada em watts"
            $table->boolean('obrigatorio')->default(false);
            $table->integer('ordem')->default(0); // Ordem de exibição
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('subcategoria_id');
            $table->index('slug');
            $table->index('ativo');
            $table->index('ordem');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campos_categoria_material');
    }
};

