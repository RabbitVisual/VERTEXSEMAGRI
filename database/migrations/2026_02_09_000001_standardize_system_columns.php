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
        // Add ncm_id to materiais if it doesn't exist
        if (Schema::hasTable('materiais') && !Schema::hasColumn('materiais', 'ncm_id')) {
            Schema::table('materiais', function (Blueprint $table) {
                $table->foreignId('ncm_id')->nullable()->after('codigo')->constrained('ncms')->onDelete('set null');
            });
        }

        // Add related_demand_id to blog_posts if it doesn't exist
        if (Schema::hasTable('blog_posts') && !Schema::hasColumn('blog_posts', 'related_demand_id')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->unsignedBigInteger('related_demand_id')->nullable()->after('author_id');
                // We don't use constrained() here to avoid dependency issues between modules if migrations run in tricky order
                // But we add the index for performance
                $table->index('related_demand_id');
            });
        }

        // Ensure image_consent exists in demandas (it should, but good to be safe)
        if (Schema::hasTable('demandas') && !Schema::hasColumn('demandas', 'image_consent')) {
            Schema::table('demandas', function (Blueprint $table) {
                $table->boolean('image_consent')->default(true)->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('materiais')) {
            Schema::table('materiais', function (Blueprint $table) {
                $table->dropForeign(['ncm_id']);
                $table->dropColumn('ncm_id');
            });
        }

        if (Schema::hasTable('blog_posts')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropIndex(['related_demand_id']);
                $table->dropColumn('related_demand_id');
            });
        }

        // We usually don't drop image_consent here if it was added by another migration,
        // but this migration is for "Standardization" so it's okay.
    }
};
