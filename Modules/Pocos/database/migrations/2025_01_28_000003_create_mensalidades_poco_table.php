<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mensalidades_poco')) {
            return;
        }

        Schema::create('mensalidades_poco', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('poco_id')->constrained('pocos')->onDelete('cascade');
            $table->foreignId('lider_id')->constrained('lideres_comunidade')->onDelete('cascade');
            $table->integer('mes');
            $table->integer('ano');
            $table->decimal('valor_mensalidade', 10, 2);
            $table->date('data_vencimento');
            $table->date('data_criacao');
            $table->text('observacoes')->nullable();
            $table->enum('status', ['aberta', 'fechada', 'cancelada'])->default('aberta');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['poco_id', 'mes', 'ano']); // Uma mensalidade por mês/ano por poço
            $table->index('poco_id');
            $table->index('lider_id');
            $table->index(['mes', 'ano']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensalidades_poco');
    }
};

