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
        if (Schema::hasTable('demandas') && !Schema::hasColumn('demandas', 'poco_id')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->foreignId('poco_id')->nullable()->after('localidade_id')->constrained('pocos')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('demandas') && Schema::hasColumn('demandas', 'poco_id')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->dropForeign(['poco_id']);
                $table->dropColumn('poco_id');
            });
        }
    }
};
