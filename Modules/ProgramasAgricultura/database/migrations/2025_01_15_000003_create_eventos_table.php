<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', [
                'capacitacao',
                'palestra',
                'feira',
                'dia_campo',
                'visita_tecnica',
                'reuniao',
                'outro'
            ]);
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fim')->nullable();
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            $table->string('endereco')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('vagas_totais')->nullable();
            $table->integer('vagas_preenchidas')->default(0);
            $table->enum('status', ['agendado', 'em_andamento', 'concluido', 'cancelado'])->default('agendado');
            $table->text('publico_alvo')->nullable();
            $table->text('conteudo_programatico')->nullable();
            $table->string('instrutor_palestrante')->nullable();
            $table->text('materiais_necessarios')->nullable();
            $table->boolean('publico')->default(true);
            $table->boolean('inscricao_aberta')->default(true);
            $table->date('data_limite_inscricao')->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id_criador')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('tipo');
            $table->index('status');
            $table->index('data_inicio');
            $table->index('publico');
            $table->index('inscricao_aberta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

