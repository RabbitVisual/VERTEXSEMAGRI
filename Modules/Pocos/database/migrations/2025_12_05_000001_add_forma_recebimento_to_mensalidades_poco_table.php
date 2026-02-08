<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mensalidades_poco')) {
            Schema::table('mensalidades_poco', function (Blueprint $table) {
                if (!Schema::hasColumn('mensalidades_poco', 'forma_recebimento')) {
                    $table->enum('forma_recebimento', ['maos', 'pix'])->default('maos')->after('status');
                }
                if (!Schema::hasColumn('mensalidades_poco', 'chave_pix')) {
                    $table->string('chave_pix')->nullable()->after('forma_recebimento');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mensalidades_poco')) {
            Schema::table('mensalidades_poco', function (Blueprint $table) {
                if (Schema::hasColumn('mensalidades_poco', 'chave_pix')) {
                    $table->dropColumn('chave_pix');
                }
                if (Schema::hasColumn('mensalidades_poco', 'forma_recebimento')) {
                    $table->dropColumn('forma_recebimento');
                }
            });
        }
    }
};

