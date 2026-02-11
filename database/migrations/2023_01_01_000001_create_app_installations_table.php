<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_installations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('version_id')->nullable();
            $table->string('device_id', 100);
            $table->string('device_model', 100)->nullable();
            $table->string('device_manufacturer', 50)->nullable();
            $table->string('android_version', 20)->nullable();
            $table->string('app_version', 20)->nullable();
            $table->integer('app_build')->nullable();
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'device_id'], 'app_installations_user_id_device_id_unique');
            $table->index('version_id', 'app_installations_version_id_foreign');
            $table->index('device_id', 'app_installations_device_id_index');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('version_id')->references('id')->on('app_versions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_installations');
    }
};
