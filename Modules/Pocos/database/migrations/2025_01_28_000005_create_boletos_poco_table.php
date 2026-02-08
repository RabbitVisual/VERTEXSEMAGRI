<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('boletos_poco')) {
            return;
        }

        Schema::create('boletos_poco', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barras')->unique();
            $table->string('numero_boleto')->unique();
            $table->foreignId('mensalidade_id')->constrained('mensalidades_poco')->onDelete('cascade');
            $table->foreignId('usuario_poco_id')->constrained('usuarios_poco')->onDelete('cascade');
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->date('data_vencimento');
            $table->date('data_emissao');
            $table->enum('status', ['aberto', 'pago', 'vencido', 'cancelado'])->default('aberto');
            $table->string('caminho_pdf')->nullable(); // Caminho do PDF gerado
            $table->integer('numero_parcela')->default(1);
            $table->text('instrucoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('mensalidade_id');
            $table->index('usuario_poco_id');
            $table->index('poco_id');
            $table->index('numero_boleto');
            $table->index('codigo_barras');
            $table->index('status');
            $table->index('data_vencimento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boletos_poco');
    }
};

