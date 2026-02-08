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
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'module_source')) {
                $table->string('module_source')->nullable()->after('role');
            }
            if (!Schema::hasColumn('notifications', 'entity_type')) {
                $table->string('entity_type')->nullable()->after('module_source');
            }
            if (!Schema::hasColumn('notifications', 'entity_id')) {
                $table->unsignedBigInteger('entity_id')->nullable()->after('entity_type');
            }
        });

        // Adicionar índices separadamente
        try {
            Schema::table('notifications', function (Blueprint $table) {
                $table->index(['module_source', 'is_read'], 'notifications_module_source_is_read_index');
            });
        } catch (\Exception $e) {
            // Índice já existe, ignorar
        }

        try {
            Schema::table('notifications', function (Blueprint $table) {
                $table->index(['entity_type', 'entity_id'], 'notifications_entity_type_entity_id_index');
            });
        } catch (\Exception $e) {
            // Índice já existe, ignorar
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            try {
                $table->dropIndex('notifications_module_source_is_read_index');
            } catch (\Exception $e) {}

            try {
                $table->dropIndex('notifications_entity_type_entity_id_index');
            } catch (\Exception $e) {}

            if (Schema::hasColumn('notifications', 'module_source')) {
                $table->dropColumn('module_source');
            }
            if (Schema::hasColumn('notifications', 'entity_type')) {
                $table->dropColumn('entity_type');
            }
            if (Schema::hasColumn('notifications', 'entity_id')) {
                $table->dropColumn('entity_id');
            }
        });
    }
};
