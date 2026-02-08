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
        Schema::table('pontos_luz', function (Blueprint $table) {
            $table->string('barramento')->nullable()->after('endereco');
            $table->string('trafo')->nullable()->after('barramento');
            $table->integer('quantidade')->default(1)->after('potencia');
            $table->decimal('horas_diarias', 5, 2)->nullable()->after('quantidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pontos_luz', function (Blueprint $table) {
            $table->dropColumn(['barramento', 'trafo', 'quantidade', 'horas_diarias']);
        });
    }
};
