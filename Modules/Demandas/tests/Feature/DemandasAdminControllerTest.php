<?php

namespace Modules\Demandas\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DemandasAdminControllerTest extends TestCase
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

    public function test_admin_can_view_demandas_index()
    {
        $response = $this->actingAs($this->user)->get(route('admin.demandas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::admin.index');
    }

    public function test_admin_can_view_demanda_details()
    {
        $localidade = Localidade::factory()->create();
        $demanda = Demanda::create([
            'codigo' => 'DEM-003',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'descricao' => 'Teste de detalhe',
            'motivo' => 'Teste',
            'solicitante_nome' => 'Admin Teste',
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.demandas.show', $demanda->id));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::admin.show');
        $response->assertSee($demanda->codigo);
    }
}
