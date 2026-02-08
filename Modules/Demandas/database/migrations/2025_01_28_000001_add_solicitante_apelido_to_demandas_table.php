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
        if (Schema::hasTable('demandas') && !Schema::hasColumn('demandas', 'solicitante_apelido')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->string('solicitante_apelido', 100)->nullable()->after('solicitante_nome');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('demandas') && Schema::hasColumn('demandas', 'solicitante_apelido')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->dropColumn('solicitante_apelido');
            });
        }
    }
};

