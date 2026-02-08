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
        Schema::table('demandas', function (Blueprint $table) {
            if (!Schema::hasColumn('demandas', 'ponto_luz_id')) {
                $table->foreignId('ponto_luz_id')->nullable()->after('localidade_id')->constrained('pontos_luz')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandas', function (Blueprint $table) {
            if (Schema::hasColumn('demandas', 'ponto_luz_id')) {
                $table->dropForeign(['ponto_luz_id']);
                $table->dropColumn('ponto_luz_id');
            }
        });
    }
};
