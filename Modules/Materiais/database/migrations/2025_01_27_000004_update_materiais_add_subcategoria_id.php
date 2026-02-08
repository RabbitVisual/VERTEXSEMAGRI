<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materiais', function (Blueprint $table) {
            // Manter categoria por compatibilidade, mas adicionar subcategoria_id
            $table->foreignId('subcategoria_id')->nullable()->after('categoria')->constrained('subcategorias_materiais')->onDelete('set null');
            $table->index('subcategoria_id');
        });
    }

    public function down(): void
    {
        Schema::table('materiais', function (Blueprint $table) {
            $table->dropForeign(['subcategoria_id']);
            $table->dropColumn('subcategoria_id');
        });
    }
};

