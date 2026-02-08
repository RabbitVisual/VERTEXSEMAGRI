<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Verifica se um índice existe na tabela
     */
    private function indexExists(string $tableName, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();

        $result = DB::select(
            "SELECT COUNT(*) as count
             FROM information_schema.statistics
             WHERE table_schema = ?
             AND table_name = ?
             AND index_name = ?",
            [$databaseName, $tableName, $indexName]
        );

        return $result[0]->count > 0;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar se a tabela já existe
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->string('title');
                $table->text('message');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('role')->nullable();
                $table->string('module_source')->nullable();
                $table->string('entity_type')->nullable();
                $table->unsignedBigInteger('entity_id')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('read_at')->nullable();
                $table->text('action_url')->nullable();
                $table->longText('data')->nullable();
                $table->timestamps();

                // Índices
                $table->index(['user_id', 'is_read'], 'notifications_user_id_is_read_index');
                $table->index(['module_source', 'is_read'], 'notifications_module_source_is_read_index');
                $table->index(['entity_type', 'entity_id'], 'notifications_entity_type_entity_id_index');
                $table->index(['created_at'], 'notifications_created_at_index');
                $table->index(['type'], 'notifications_type_index');

                // Foreign key
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        } else {
            // Se a tabela já existe, apenas adicionar colunas que faltam
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
                if (!Schema::hasColumn('notifications', 'action_url')) {
                    $table->text('action_url')->nullable()->after('read_at');
                }
                if (!Schema::hasColumn('notifications', 'data')) {
                    $table->longText('data')->nullable()->after('action_url');
                }
            });

            // Adicionar índices se não existirem (verificação real no banco)
            if (!$this->indexExists('notifications', 'notifications_module_source_is_read_index')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->index(['module_source', 'is_read'], 'notifications_module_source_is_read_index');
                });
            }

            if (!$this->indexExists('notifications', 'notifications_entity_type_entity_id_index')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->index(['entity_type', 'entity_id'], 'notifications_entity_type_entity_id_index');
                });
            }

            if (!$this->indexExists('notifications', 'notifications_created_at_index')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->index(['created_at'], 'notifications_created_at_index');
                });
            }

            if (!$this->indexExists('notifications', 'notifications_type_index')) {
                Schema::table('notifications', function (Blueprint $table) {
                    $table->index(['type'], 'notifications_type_index');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Não remover a tabela notifications pois pode ser usada pelo Laravel
        Schema::table('notifications', function (Blueprint $table) {
            try {
                $table->dropIndex('notifications_module_source_is_read_index');
            } catch (\Exception $e) {}

            try {
                $table->dropIndex('notifications_entity_type_entity_id_index');
            } catch (\Exception $e) {}

            try {
                $table->dropIndex('notifications_created_at_index');
            } catch (\Exception $e) {}

            try {
                $table->dropIndex('notifications_type_index');
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

