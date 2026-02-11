<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscricoes_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas_cad')->onDelete('set null');
            $table->string('nome')->nullable(); // Se não tiver pessoa_id
            $table->string('cpf', 11)->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            $table->enum('status', ['inscrito', 'confirmado', 'presente', 'ausente', 'cancelado'])->default('inscrito');
            $table->date('data_inscricao')->default(Illuminate\Support\Facades\DB::raw('(CURDATE())'));
            $table->date('data_confirmacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('evento_id');
            $table->index('pessoa_id');
            $table->index('cpf');
            $table->index('status');
            $table->unique(['evento_id', 'cpf']); // Uma pessoa só pode se inscrever uma vez por evento
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscricoes_eventos');
    }
};
