<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json, text
            $table->string('group')->default('general'); // general, email, security, backup, modules
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false); // Se pode ser acessado publicamente
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};
