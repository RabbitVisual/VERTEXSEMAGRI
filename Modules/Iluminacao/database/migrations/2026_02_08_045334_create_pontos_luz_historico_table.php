<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('pontos_luz_historico')) {
            Schema::create('pontos_luz_historico', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ponto_luz_id')->constrained('pontos_luz')->onDelete('cascade');
                
                // Flexible foreign keys (nullable because history might be manual or linked to deleted records)
                $table->unsignedBigInteger('demanda_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('material_id')->nullable();
                
                // Add constraints if tables exist
                if (Schema::hasTable('demandas')) {
                    $table->foreign('demanda_id')->references('id')->on('demandas')->nullOnDelete();
                }
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                }
                if (Schema::hasTable('materiais')) {
                    $table->foreign('material_id')->references('id')->on('materiais')->nullOnDelete();
                }
                
                $table->decimal('quantidade_material', 10, 2)->nullable();
                
                $table->string('tipo_evento'); // instalacao, manutencao, auditoria
                $table->text('descricao')->nullable();
                $table->dateTime('data_evento')->useCurrent();
                $table->text('observacoes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pontos_luz_historico');
    }
};
