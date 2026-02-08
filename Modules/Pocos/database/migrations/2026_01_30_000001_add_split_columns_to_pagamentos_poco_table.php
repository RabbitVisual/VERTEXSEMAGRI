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
        Schema::table('pagamentos_poco', function (Blueprint $table) {
            $table->decimal('taxa_plataforma', 10, 2)->default(0)->after('valor_pago');
            $table->decimal('valor_liquido', 10, 2)->default(0)->after('taxa_plataforma');
            $table->boolean('split_realizado')->default(false)->after('valor_liquido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagamentos_poco', function (Blueprint $table) {
            $table->dropColumn(['taxa_plataforma', 'valor_liquido', 'split_realizado']);
        });
    }
};
