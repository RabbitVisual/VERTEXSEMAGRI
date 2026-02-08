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
        Schema::table('pessoas_cad', function (Blueprint $table) {
            if (!Schema::hasColumn('pessoas_cad', 'localidade_id')) {
                $table->foreignId('localidade_id')
                    ->nullable()
                    ->after('ref_pbf')
                    ->constrained('localidades')
                    ->onDelete('set null');

                $table->index('localidade_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pessoas_cad', function (Blueprint $table) {
            if (Schema::hasColumn('pessoas_cad', 'localidade_id')) {
                $table->dropForeign(['localidade_id']);
                $table->dropIndex(['localidade_id']);
                $table->dropColumn('localidade_id');
            }
        });
    }
};
