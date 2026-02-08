<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('lideres_comunidade')) {
            return;
        }

        Schema::create('lideres_comunidade', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->string('cpf', 11)->unique();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('poco_id')->nullable()->constrained('pocos')->onDelete('set null');
            $table->text('endereco')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('localidade_id');
            $table->index('poco_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lideres_comunidade');
    }
};

