<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('trechos')) {
            return;
        }
        
        Schema::create('trechos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->enum('tipo', ['vicinal', 'principal', 'secundaria']);
            $table->decimal('extensao_km', 8, 2);
            $table->decimal('largura_metros', 5, 2)->nullable();
            $table->enum('tipo_pavimento', ['asfalto', 'cascalho', 'terra']);
            $table->enum('condicao', ['boa', 'regular', 'ruim', 'pessima'])->default('regular');
            $table->boolean('tem_ponte')->default(false);
            $table->integer('numero_pontes')->default(0);
            $table->date('ultima_manutencao')->nullable();
            $table->date('proxima_manutencao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trechos');
    }
};

