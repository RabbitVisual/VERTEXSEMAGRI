<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ordem_servico_materiais')) {
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
    }
};
