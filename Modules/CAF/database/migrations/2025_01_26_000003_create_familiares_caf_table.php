<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('familiares_caf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_caf_id')->constrained('cadastros_caf')->onDelete('cascade');
            
            $table->string('nome_completo');
            $table->string('cpf', 11)->nullable();
            $table->string('rg')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->enum('sexo', ['M', 'F', 'Outro'])->nullable();
            $table->string('parentesco'); // filho, filha, pai, mae, avo, neto, etc
            $table->string('escolaridade')->nullable();
            $table->boolean('trabalha')->default(false);
            $table->decimal('renda_mensal', 10, 2)->nullable();
            
            $table->timestamps();
            
            $table->index('cadastro_caf_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('familiares_caf');
    }
};

