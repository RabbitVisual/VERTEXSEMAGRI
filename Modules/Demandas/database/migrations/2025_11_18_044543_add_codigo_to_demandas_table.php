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
        if (Schema::hasTable('demandas') && !Schema::hasColumn('demandas', 'codigo')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->string('codigo')->unique()->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('demandas') && Schema::hasColumn('demandas', 'codigo')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->dropColumn('codigo');
            });
        }
    }
};
