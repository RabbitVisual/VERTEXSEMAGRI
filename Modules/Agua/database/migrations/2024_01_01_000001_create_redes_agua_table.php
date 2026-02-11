<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('redes_agua')) {
            return;
        }

        Schema::create('redes_agua', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->enum('tipo_rede', ['principal', 'secundaria', 'ramal']);
            $table->string('diametro')->nullable(); // em polegadas ou mm
            $table->string('material')->nullable(); // PVC, ferro, polietileno
            $table->decimal('extensao_metros', 10, 2)->nullable();
            $table->date('data_instalacao')->nullable();
            $table->enum('status', ['funcionando', 'com_vazamento', 'interrompida'])->default('funcionando');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        if (!Schema::hasTable('pontos_distribuicao')) {
            Schema::create('pontos_distribuicao', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('rede_agua_id')->constrained('redes_agua')->onDelete('cascade');
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->string('endereco');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('numero_conexoes')->default(0);
            $table->enum('tipo', ['hidrante', 'caixa_dagua', 'reservatorio']);
            $table->decimal('capacidade_litros')->nullable();
            $table->enum('status', ['funcionando', 'com_defeito', 'manutencao'])->default('funcionando');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pontos_distribuicao');
        Schema::dropIfExists('redes_agua');
    }
};
