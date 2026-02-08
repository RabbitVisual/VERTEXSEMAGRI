<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendas_familiares_caf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadastro_caf_id')->constrained('cadastros_caf')->onDelete('cascade');
            
            // Renda total familiar
            $table->decimal('renda_total_mensal', 10, 2)->default(0);
            $table->decimal('renda_per_capita', 10, 2)->default(0);
            $table->integer('numero_membros')->default(1);
            
            // Fontes de renda
            $table->decimal('renda_agricultura', 10, 2)->default(0);
            $table->decimal('renda_pecuaria', 10, 2)->default(0);
            $table->decimal('renda_extrativismo', 10, 2)->default(0);
            $table->decimal('renda_aposentadoria', 10, 2)->default(0);
            $table->decimal('renda_bolsa_familia', 10, 2)->default(0);
            $table->decimal('renda_outros', 10, 2)->default(0);
            $table->text('renda_outros_descricao')->nullable();
            
            // Benefícios sociais
            $table->boolean('recebe_bolsa_familia')->default(false);
            $table->boolean('recebe_aposentadoria')->default(false);
            $table->boolean('recebe_bpc')->default(false);
            $table->boolean('recebe_outros')->default(false);
            $table->text('beneficios_descricao')->nullable();
            
            $table->timestamps();
            
            $table->index('cadastro_caf_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendas_familiares_caf');
    }
};

