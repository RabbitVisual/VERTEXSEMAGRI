<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_sessions', 'visitor_cpf')) {
                $table->string('visitor_cpf', 11)->nullable()->after('visitor_phone')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('chat_sessions', 'visitor_cpf')) {
                $table->dropColumn('visitor_cpf');
            }
        });
    }
};

