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
        if (Schema::hasTable('material_movimentacoes')) {
        Schema::table('material_movimentacoes', function (Blueprint $table) {
                if (!Schema::hasColumn('material_movimentacoes', 'status')) {
                    $table->enum('status', ['reservado', 'confirmado', 'cancelado'])->default('confirmado')->after('tipo');
                }
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('material_movimentacoes')) {
        Schema::table('material_movimentacoes', function (Blueprint $table) {
                if (Schema::hasColumn('material_movimentacoes', 'status')) {
                    $table->dropColumn('status');
                }
        });
        }
    }
};
