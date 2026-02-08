<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demandas', function (Blueprint $table) {
            if (!Schema::hasColumn('demandas', 'pessoa_id')) {
                $table->unsignedBigInteger('pessoa_id')->nullable()->after('localidade_id');
                $table->foreign('pessoa_id')->references('id')->on('pessoas_cad')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('demandas', function (Blueprint $table) {
            $table->dropForeign(['pessoa_id']);
            $table->dropColumn('pessoa_id');
        });
    }
};

