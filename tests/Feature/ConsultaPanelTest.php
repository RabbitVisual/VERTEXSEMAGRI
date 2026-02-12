<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ConsultaPanelTest extends TestCase
{
    use RefreshDatabase;

    protected $consultaUser;
    protected $adminUser;
    protected $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles if they don't exist
        if (!Role::where('name', 'consulta')->exists()) {
            Role::create(['name' => 'consulta']);
        }
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        // Create a user with 'consulta' role
        $this->consultaUser = User::factory()->create();
        $this->consultaUser->assignRole('consulta');

        // Create a regular user without role
        $this->regularUser = User::factory()->create();
    }

    public function test_consulta_panel_routes_are_protected()
    {
        $response = $this->get(route('consulta.dashboard'));
        $response->assertRedirect(route('login'));

        $this->actingAs($this->regularUser);
        $response = $this->get(route('consulta.dashboard'));
        $response->assertStatus(403);
    }

    public function test_consulta_user_can_access_dashboard()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('consulta.dashboard.index');
    }

    public function test_consulta_user_can_access_demandas_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.demandas.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_ordens_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.ordens.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_localidades_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.localidades.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_pessoas_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.pessoas.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_equipes_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.equipes.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_estradas_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.estradas.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_funcionarios_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.funcionarios.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_iluminacao_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.iluminacao.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_materiais_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.materiais.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_pocos_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.pocos.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_agua_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.agua.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_notificacoes_index()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.notificacoes.index'));
        $response->assertStatus(200);
    }

    public function test_consulta_user_can_access_profile()
    {
        $this->actingAs($this->consultaUser);
        $response = $this->get(route('consulta.profile'));
        $response->assertStatus(200);
    }
}
