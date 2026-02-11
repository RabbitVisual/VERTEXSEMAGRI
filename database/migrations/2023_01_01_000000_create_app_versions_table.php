<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version', 20)->unique();
            $table->integer('build_number')->unique();
            $table->string('apk_path', 255);
            $table->bigInteger('apk_size')->nullable();
            $table->text('changelog')->nullable();
            $table->boolean('is_active')->default(false);
            $table->string('min_android_version', 10)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_versions');
    }
};
