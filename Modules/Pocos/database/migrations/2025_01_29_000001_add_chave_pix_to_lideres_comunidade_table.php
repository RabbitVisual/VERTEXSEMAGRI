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
        Schema::table('lideres_comunidade', function (Blueprint $table) {
            if (!Schema::hasColumn('lideres_comunidade', 'chave_pix')) {
                $table->string('chave_pix')->nullable()->after('email');
            }
            if (!Schema::hasColumn('lideres_comunidade', 'tipo_chave_pix')) {
                $table->enum('tipo_chave_pix', ['cpf', 'cnpj', 'email', 'telefone', 'aleatoria'])->nullable()->after('chave_pix');
            }
            if (!Schema::hasColumn('lideres_comunidade', 'pix_ativo')) {
                $table->boolean('pix_ativo')->default(false)->after('tipo_chave_pix');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lideres_comunidade', function (Blueprint $table) {
            if (Schema::hasColumn('lideres_comunidade', 'pix_ativo')) {
                $table->dropColumn('pix_ativo');
            }
            if (Schema::hasColumn('lideres_comunidade', 'tipo_chave_pix')) {
                $table->dropColumn('tipo_chave_pix');
            }
            if (Schema::hasColumn('lideres_comunidade', 'chave_pix')) {
                $table->dropColumn('chave_pix');
            }
        });
    }
};

