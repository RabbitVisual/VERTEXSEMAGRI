<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordem_servico_materiais', function (Blueprint $table) {
            if (!Schema::hasColumn('ordem_servico_materiais', 'poste_id')) {
                $table->foreignId('poste_id')->nullable()->constrained('postes')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ordem_servico_materiais', function (Blueprint $table) {
            if (Schema::hasColumn('ordem_servico_materiais', 'poste_id')) {
                $table->dropForeign(['poste_id']);
                $table->dropColumn('poste_id');
            }
        });
    }
};
