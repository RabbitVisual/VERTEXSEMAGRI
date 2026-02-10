<?php

namespace Modules\Demandas\Tests\Unit;

use Modules\Demandas\App\Models\Demanda;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PrivacyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Create minimal schema for relationships to work without error
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('demandas');
        parent::tearDown();
    }

    public function test_to_public_array_does_not_expose_sensitive_data()
    {
        $demanda = new Demanda();
        $demanda->id = 1;
        $demanda->codigo = 'DEM-123';
        $demanda->status = 'aberta';
        $demanda->prioridade = 'alta';
        $demanda->tipo = 'agua';
        $demanda->motivo = 'Test Motivo';
        $demanda->descricao = 'Test Descricao';
        $demanda->data_abertura = now();
        $demanda->solicitante_email = 'private@example.com';
        $demanda->solicitante_telefone = '123456789';

        // Simulate data_conclusao and updated_at
        $demanda->data_conclusao = null;
        $demanda->updated_at = now();

        $publicData = $demanda->toPublicArray();

        $this->assertArrayHasKey('codigo', $publicData);
        $this->assertArrayHasKey('status', $publicData);

        // Assert sensitive data is missing
        $this->assertArrayNotHasKey('solicitante_email', $publicData);
        $this->assertArrayNotHasKey('solicitante_telefone', $publicData);
        $this->assertArrayNotHasKey('solicitante_nome', $publicData);
        $this->assertArrayNotHasKey('solicitante_cpf', $publicData);
        $this->assertArrayNotHasKey('user_id', $publicData);
        $this->assertArrayNotHasKey('pessoa_id', $publicData);
    }
}
