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
        Schema::table('ordem_servico_materiais', function (Blueprint $table) {
            if (!Schema::hasColumn('ordem_servico_materiais', 'status_reserva')) {
                $table->enum('status_reserva', ['reservado', 'confirmado', 'cancelado'])->default('reservado')->after('valor_unitario');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordem_servico_materiais', function (Blueprint $table) {
            if (Schema::hasColumn('ordem_servico_materiais', 'status_reserva')) {
                $table->dropColumn('status_reserva');
            }
        });
    }
};
