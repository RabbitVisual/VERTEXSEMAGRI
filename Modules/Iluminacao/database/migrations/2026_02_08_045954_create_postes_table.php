<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('postes')) {
            return;
        }
        Schema::create('postes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->index();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->enum('tipo_poste', ['circular', 'duplo_t', 'madeira', 'ornamental', 'outro'])->default('circular');
            $table->enum('condicao', ['bom', 'regular', 'ruim', 'critico'])->default('bom');
            $table->enum('tipo_lampada', ['led', 'sodio', 'mercurio', 'vapor_metalico', 'mista', 'outra'])->nullable();
            $table->integer('potencia')->nullable(); // Watts
            $table->string('trafo')->nullable(); // ID do transformador ou 'Sim'
            $table->boolean('barramento')->default(false);
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postes');
    }
};
