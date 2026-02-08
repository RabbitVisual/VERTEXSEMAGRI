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
        if (Schema::hasTable('pagamentos_pix_poco')) {
            return;
        }

        Schema::create('pagamentos_pix_poco', function (Blueprint $table) {
            $table->id();
            $table->string('txid')->unique(); // Transaction ID do PIX
            $table->string('codigo')->unique(); // Código interno
            $table->foreignId('mensalidade_id')->constrained('mensalidades_poco')->onDelete('cascade');
            $table->foreignId('usuario_poco_id')->nullable()->constrained('usuarios_poco')->onDelete('set null');
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->foreignId('lider_id')->constrained('lideres_comunidade')->onDelete('cascade');
            
            // Dados do PIX
            $table->string('chave_pix_destino'); // Chave PIX do líder
            $table->decimal('valor', 10, 2);
            $table->string('descricao')->nullable();
            $table->string('solicitacao_pagador')->nullable(); // Texto exibido ao pagador
            
            // QR Code
            $table->text('qr_code_base64')->nullable(); // QR Code em base64
            $table->text('qr_code_string')->nullable(); // String do QR Code (EMV)
            $table->string('location_id')->nullable(); // ID da location do PIX
            
            // Status do pagamento
            $table->enum('status', ['pendente', 'pago', 'expirado', 'cancelado'])->default('pendente');
            $table->timestamp('data_expiracao')->nullable();
            $table->timestamp('data_pagamento')->nullable();
            
            // Dados do pagamento recebido (webhook)
            $table->string('e2eid')->nullable(); // End-to-end ID do pagamento
            $table->string('end_to_end_id')->nullable(); // End-to-end ID alternativo
            $table->string('chave_pix_origem')->nullable(); // Chave PIX de quem pagou
            $table->string('nome_pagador')->nullable();
            $table->string('cpf_pagador')->nullable();
            $table->text('info_pagador')->nullable(); // JSON com informações adicionais
            
            // Webhook
            $table->timestamp('webhook_recebido_em')->nullable();
            $table->text('webhook_dados')->nullable(); // JSON completo do webhook
            
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('txid');
            $table->index('mensalidade_id');
            $table->index('usuario_poco_id');
            $table->index('poco_id');
            $table->index('lider_id');
            $table->index('status');
            $table->index('data_pagamento');
            $table->index('e2eid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos_pix_poco');
    }
};

