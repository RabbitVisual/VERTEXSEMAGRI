<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Altera as colunas title e description para TEXT para suportar HTML completo do Quill Editor
     */
    public function up(): void
    {
        Schema::table('carousel_slides', function (Blueprint $table) {
            $table->text('title')->change();
            $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carousel_slides', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->change(); // description já era text, mas mantemos para consistência
        });
    }
};
