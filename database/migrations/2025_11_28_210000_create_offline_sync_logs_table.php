<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela para controle de sincronização offline
     * Garante idempotência (não duplica ações) e auditoria completa
     */
    public function up(): void
    {
        Schema::create('offline_sync_logs', function (Blueprint $table) {
            $table->id();
            
            // UUID único gerado pelo cliente - evita duplicatas
            $table->uuid('client_uuid')->unique();
            
            // Funcionário que realizou a ação
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Tipo da ação: iniciar_ordem, concluir_ordem, adicionar_material, upload_foto, etc.
            $table->string('action_type', 50);
            
            // Modelo/Entidade afetada
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            
            // Dados da ação (JSON)
            $table->json('payload')->nullable();
            
            // Hash do payload para verificação de integridade
            $table->string('payload_hash', 64)->nullable();
            
            // Resultado da sincronização
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'duplicate'])->default('pending');
            $table->text('error_message')->nullable();
            $table->json('result_data')->nullable();
            
            // Timestamps de controle
            $table->timestamp('client_timestamp')->nullable(); // Quando a ação foi feita offline
            $table->timestamp('synced_at')->nullable();        // Quando foi sincronizado
            $table->timestamp('processed_at')->nullable();      // Quando foi processado no servidor
            
            // Informações do dispositivo
            $table->string('device_id', 100)->nullable();
            $table->string('device_info', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            
            $table->timestamps();
            
            // Índices para performance
            $table->index(['user_id', 'action_type']);
            $table->index(['status', 'created_at']);
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offline_sync_logs');
    }
};

