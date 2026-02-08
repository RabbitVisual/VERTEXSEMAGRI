<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pagamentos_poco')) {
            return;
        }

        Schema::create('pagamentos_poco', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('mensalidade_id')->constrained('mensalidades_poco')->onDelete('cascade');
            $table->foreignId('usuario_poco_id')->constrained('usuarios_poco')->onDelete('cascade');
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->foreignId('lider_id')->nullable()->constrained('lideres_comunidade')->onDelete('set null');
            $table->date('data_pagamento');
            $table->decimal('valor_pago', 10, 2);
            $table->enum('forma_pagamento', ['dinheiro', 'pix', 'transferencia', 'outro'])->default('dinheiro');
            $table->string('comprovante')->nullable(); // Caminho do arquivo de comprovante
            $table->text('observacoes')->nullable();
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('confirmado');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['mensalidade_id', 'usuario_poco_id']); // Um pagamento por mensalidade por usuário
            $table->index('mensalidade_id');
            $table->index('usuario_poco_id');
            $table->index('poco_id');
            $table->index('data_pagamento');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos_poco');
    }
};

