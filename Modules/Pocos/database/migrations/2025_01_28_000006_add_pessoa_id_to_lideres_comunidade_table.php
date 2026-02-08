<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lideres_comunidade', function (Blueprint $table) {
            if (!Schema::hasColumn('lideres_comunidade', 'pessoa_id')) {
                $table->unsignedBigInteger('pessoa_id')->nullable()->after('user_id');
                $table->foreign('pessoa_id')->references('id')->on('pessoas_cad')->onDelete('set null');
                $table->index('pessoa_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lideres_comunidade', function (Blueprint $table) {
            if (Schema::hasColumn('lideres_comunidade', 'pessoa_id')) {
                $table->dropForeign(['pessoa_id']);
                $table->dropIndex(['pessoa_id']);
                $table->dropColumn('pessoa_id');
            }
        });
    }
};

