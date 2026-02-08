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
            if (!Schema::hasColumn('pessoas_cad', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pessoas_cad', function (Blueprint $table) {
            if (Schema::hasColumn('pessoas_cad', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
