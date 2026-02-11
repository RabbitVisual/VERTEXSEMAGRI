<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programa_id')->constrained('programas')->onDelete('cascade');
            $table->foreignId('pessoa_id')->nullable()->constrained('pessoas_cad')->onDelete('set null');
            $table->string('nome')->nullable(); // Se não tiver pessoa_id
            $table->string('cpf', 11)->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('localidade_id')->nullable()->constrained('localidades')->onDelete('set null');
            $table->enum('status', ['inscrito', 'aprovado', 'beneficiado', 'cancelado', 'inativo'])->default('inscrito');
            $table->date('data_inscricao')->default(Illuminate\Support\Facades\DB::raw('(CURDATE())'));
            $table->date('data_aprovacao')->nullable();
            $table->date('data_beneficio')->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id_inscricao')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index('programa_id');
            $table->index('pessoa_id');
            $table->index('cpf');
            $table->index('status');
            $table->index('localidade_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiarios');
    }
};
