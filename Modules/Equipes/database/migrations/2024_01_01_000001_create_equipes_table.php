<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique()->nullable();
            $table->enum('tipo', ['eletricistas', 'encanadores', 'operadores', 'motoristas', 'mista']);
            $table->text('descricao')->nullable();
            $table->foreignId('lider_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('equipe_membros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipe_membros');
        Schema::dropIfExists('equipes');
    }
};

