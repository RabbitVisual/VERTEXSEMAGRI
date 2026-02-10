<?php

namespace Modules\Demandas\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Tests\TestCase;

class DemandaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Load factories manually to avoid autoloader issues in modular structure
        require_once base_path('Modules/Localidades/database/factories/LocalidadeFactory.php');
    }

    public function test_can_create_demanda()
    {
        $localidade = Localidade::factory()->create();

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'descricao' => 'Teste de demanda',
            'motivo' => 'Falta de água', // Added required field
            'solicitante_nome' => 'João Silva',
            'data_abertura' => now(),
        ]);

        $this->assertDatabaseHas('demandas', [
            'id' => $demanda->id,
            'codigo' => 'DEM-001',
        ]);
    }

    public function test_belongs_to_localidade()
    {
        $localidade = Localidade::factory()->create();
        $demanda = Demanda::create([
            'codigo' => 'DEM-002',
            'localidade_id' => $localidade->id,
            'tipo' => 'iluminacao',
            'prioridade' => 'media',
            'status' => 'em_andamento',
            'descricao' => 'Teste',
            'motivo' => 'Lâmpada queimada', // Added required field
            'solicitante_nome' => 'Maria',
            'data_abertura' => now(),
        ]);

        $this->assertInstanceOf(Localidade::class, $demanda->localidade);
        $this->assertEquals($localidade->id, $demanda->localidade->id);
    }
}
