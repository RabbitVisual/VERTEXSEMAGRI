<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('familias')) {
            return;
        }
        
        Schema::create('familias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->string('nome_responsavel');
            $table->string('cpf_responsavel', 14)->nullable();
            $table->string('telefone')->nullable();
            $table->integer('numero_membros')->default(1);
            $table->decimal('renda_familiar', 10, 2)->nullable();
            $table->text('beneficios_sociais')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('familias');
    }
};

