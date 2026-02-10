<?php

namespace Modules\Ordens\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OrdensAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        require_once base_path('Modules/Localidades/database/factories/LocalidadeFactory.php');

        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
    }

    public function test_admin_can_view_ordens_index()
    {
        $response = $this->actingAs($this->user)->get(route('admin.ordens.index'));

        $response->assertStatus(200);
        $response->assertViewIs('ordens::admin.index');
    }

    public function test_admin_can_view_ordem_details()
    {
        $localidade = Localidade::factory()->create();
        $demanda = Demanda::create([
            'codigo' => 'DEM-004',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'descricao' => 'Teste de ordem',
            'motivo' => 'Teste',
            'solicitante_nome' => 'Admin Teste',
            'data_abertura' => now(),
        ]);

        $ordem = OrdemServico::create([
            'codigo' => 'OS-003',
            'demanda_id' => $demanda->id,
            'status' => 'pendente',
            'prioridade' => 'alta',
            'descricao' => 'Serviço de teste',
            'tipo_servico' => 'manutencao',
            'data_inicio' => now(),
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.ordens.show', $ordem->id));

        $response->assertStatus(200);
        $response->assertViewIs('ordens::admin.show');
        $response->assertSee($ordem->codigo);
    }
}
