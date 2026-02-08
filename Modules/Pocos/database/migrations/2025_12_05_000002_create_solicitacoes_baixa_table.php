<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('solicitacoes_baixa_poco')) {
            return;
        }

        Schema::create('solicitacoes_baixa_poco', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boleto_poco_id')->constrained('boletos_poco')->onDelete('cascade');
            $table->foreignId('usuario_poco_id')->constrained('usuarios_poco')->onDelete('cascade');
            $table->foreignId('mensalidade_id')->constrained('mensalidades_poco')->onDelete('cascade');
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->date('data_pagamento');
            $table->decimal('valor_pago', 10, 2);
            $table->string('forma_pagamento')->nullable(); // dinheiro, pix, transferencia, outro
            $table->text('comprovante')->nullable(); // URL ou base64 da imagem do comprovante
            $table->text('observacoes')->nullable();
            $table->enum('status', ['pendente', 'aprovada', 'rejeitada'])->default('pendente');
            $table->text('motivo_rejeicao')->nullable();
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('aprovado_em')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('usuario_poco_id');
            $table->index('boleto_poco_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacoes_baixa_poco');
    }
};

