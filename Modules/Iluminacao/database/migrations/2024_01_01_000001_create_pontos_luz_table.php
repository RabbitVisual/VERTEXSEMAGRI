<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pontos_luz')) {
            return;
        }
        
        Schema::create('pontos_luz', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->string('endereco');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('tipo_lampada'); // LED, vapor_sodio, fluorescente
            $table->integer('potencia'); // watts
            $table->string('tipo_poste'); // concreto, metalico, madeira
            $table->decimal('altura_poste', 5, 2)->nullable();
            $table->string('tipo_fiacao')->nullable();
            $table->date('data_instalacao')->nullable();
            $table->date('ultima_manutencao')->nullable();
            $table->enum('status', ['funcionando', 'com_defeito', 'desligado'])->default('funcionando');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pontos_luz');
    }
};

