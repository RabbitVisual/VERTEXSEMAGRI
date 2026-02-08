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
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->foreignId('funcionario_id')->nullable()->after('equipe_id')->constrained('funcionarios')->onDelete('set null');
            $table->foreignId('user_id_atribuido')->nullable()->after('funcionario_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordens_servico', function (Blueprint $table) {
            $table->dropForeign(['funcionario_id']);
            $table->dropForeign(['user_id_atribuido']);
            $table->dropColumn(['funcionario_id', 'user_id_atribuido']);
        });
    }
};
