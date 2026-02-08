<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('notifications')) { Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // info, success, warning, error, system
            $table->string('title');
            $table->text('message');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('role')->nullable(); // Se for para um role específico
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Dados adicionais
            $table->string('action_url')->nullable(); // URL de ação relacionada
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['role', 'is_read']);
            $table->index('created_at');
        }); }
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
