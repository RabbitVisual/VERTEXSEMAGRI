<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imoveis_caf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_caf_id')->constrained('cadastros_caf')->onDelete('cascade');
            
            // Tipo de imóvel
            $table->enum('tipo_posse', ['proprio', 'arrendado', 'cedido', 'ocupacao', 'outro'])->nullable();
            $table->string('tipo_posse_outro')->nullable();
            
            // Localização do imóvel
            $table->string('cep')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            
            // Dimensões
            $table->decimal('area_total_hectares', 10, 2)->nullable();
            $table->decimal('area_agricultavel_hectares', 10, 2)->nullable();
            $table->decimal('area_pastagem_hectares', 10, 2)->nullable();
            $table->decimal('area_reserva_legal_hectares', 10, 2)->nullable();
            
            // Atividades
            $table->boolean('producao_vegetal')->default(false);
            $table->boolean('producao_animal')->default(false);
            $table->boolean('extrativismo')->default(false);
            $table->boolean('aquicultura')->default(false);
            $table->text('atividades_descricao')->nullable();
            
            $table->timestamps();
            
            $table->index('cadastro_caf_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imoveis_caf');
    }
};

