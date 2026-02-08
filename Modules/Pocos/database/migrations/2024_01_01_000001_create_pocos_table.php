<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pocos')) {
            return;
        }
        
        Schema::create('pocos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('localidade_id')->constrained('localidades')->onDelete('cascade');
            $table->string('endereco');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('profundidade_metros', 8, 2);
            $table->decimal('vazao_litros_hora', 10, 2)->nullable();
            $table->date('data_perfuracao')->nullable();
            $table->string('diametro')->nullable();
            $table->string('tipo_bomba')->nullable();
            $table->integer('potencia_bomba')->nullable(); // watts ou HP
            $table->foreignId('equipe_responsavel_id')->nullable();
            // Foreign key será adicionada quando a tabela equipes existir
            // $table->foreign('equipe_responsavel_id')->references('id')->on('equipes')->onDelete('set null');
            $table->date('ultima_manutencao')->nullable();
            $table->date('proxima_manutencao')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'manutencao', 'bomba_queimada'])->default('ativo');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pocos');
    }
};

