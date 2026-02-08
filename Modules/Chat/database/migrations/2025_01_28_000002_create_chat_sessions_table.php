<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->enum('type', ['public', 'internal'])->default('public');
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email')->nullable();
            $table->string('visitor_phone')->nullable();
            $table->string('visitor_ip')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null')->comment('Atendente atribuído');
            $table->enum('status', ['waiting', 'active', 'closed', 'transferred'])->default('waiting');
            $table->integer('unread_count_user')->default(0);
            $table->integer('unread_count_visitor')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('assigned_to');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};

