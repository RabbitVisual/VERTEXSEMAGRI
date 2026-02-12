<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Pocos\App\Models\Poco;
use Modules\Pocos\App\Models\LiderComunidade;
use Modules\Pocos\App\Models\UsuarioPoco;
use Modules\Pocos\App\Models\MensalidadePoco;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class ComunidadeRouteTest extends TestCase
{
    use RefreshDatabase;

    protected $liderUser;
    protected $lider;
    protected $poco;
    protected $morador;

    protected function setUp(): void
    {
        parent::setUp();

        // ---------------------------------------------------------------------
        // Setup Roles
        // ---------------------------------------------------------------------
        if (DB::table('roles')->where('name', 'lider-comunidade')->doesntExist()) {
            Role::create(['name' => 'lider-comunidade', 'guard_name' => 'web']);
        }

        // ---------------------------------------------------------------------
        // Setup Data (Poco + Lider)
        // ---------------------------------------------------------------------
        $localidade = Localidade::create([
            'nome' => 'Comunidade Teste',
            'codigo' => 'LOC-TEST-' . uniqid(),
            'ativo' => true
        ]);

        $this->poco = Poco::create([
            'codigo' => 'POC-TEST-' . uniqid(),
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua do Poço Teste',
            'profundidade_metros' => 100.00,
            'status' => 'ativo',
            'nome_mapa' => 'Poço Teste'
        ]);

        $this->liderUser = User::create([
            'name' => 'Lider Teste',
            'email' => 'lider.teste@vertex.com',
            'password' => bcrypt('password')
        ]);
        $this->liderUser->assignRole('lider-comunidade');

        $this->lider = LiderComunidade::create([
            'nome' => 'Lider da Silva',
            'codigo' => 'LID-TEST-' . uniqid(),
            'cpf' => '11122233344',
            'telefone' => '88999999999',
            'localidade_id' => $localidade->id,
            'user_id' => $this->liderUser->id,
            'poco_id' => $this->poco->id,
            'endereco' => 'Rua do Lider',
            'status' => 'ativo'
        ]);

        // ---------------------------------------------------------------------
        // Setup Data (Morador)
        // ---------------------------------------------------------------------
        $this->morador = UsuarioPoco::create([
            'poco_id' => $this->poco->id,
            'nome' => 'Morador Teste',
            'status' => 'ativo',
            'codigo_acesso' => 'TEST1234',
            'numero_casa' => '100',
            'endereco' => 'Rua do Morador',
            'data_cadastro' => now()
        ]);
    }

    // =========================================================================
    // Lider Routes Tests
    // =========================================================================

    #[Test]
    public function lider_routes_are_protected_by_auth_middleware()
    {
        $routes = [
            'lider-comunidade.dashboard',
            'lider-comunidade.usuarios.index',
            'lider-comunidade.mensalidades.index',
            'lider-comunidade.pix.edit',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(302); // Redirect to login
        }
    }

    #[Test]
    public function lider_can_access_dashboard()
    {
        $this->actingAs($this->liderUser);
        $response = $this->get(route('lider-comunidade.dashboard'));
        $response->assertStatus(200);
    }

    #[Test]
    public function lider_can_access_usuarios_management()
    {
        $this->actingAs($this->liderUser);

        // Index
        $response = $this->get(route('lider-comunidade.usuarios.index'));
        $response->assertStatus(200);

        // Create
        $response = $this->get(route('lider-comunidade.usuarios.create'));
        $response->assertStatus(200);

        // Show
        $response = $this->get(route('lider-comunidade.usuarios.show', $this->morador->id));
        $response->assertStatus(200);

        // Edit
        $response = $this->get(route('lider-comunidade.usuarios.edit', $this->morador->id));
        $response->assertStatus(200);
    }

    #[Test]
    public function lider_can_access_financial_management()
    {
        $this->actingAs($this->liderUser);

        // Mensalidades Index
        $response = $this->get(route('lider-comunidade.mensalidades.index'));
        $response->assertStatus(200);

        // Create
        $response = $this->get(route('lider-comunidade.mensalidades.create'));
        $response->assertStatus(200);

        // Create a dummy mensalidade for Show/Edit testing
        $mensalidade = MensalidadePoco::create([
             'poco_id' => $this->poco->id,
             'lider_id' => $this->lider->id,
             'mes' => 12,
             'ano' => 2025,
             'valor_mensalidade' => 50.00,
             'data_vencimento' => '2025-12-15',
             'data_criacao' => now(),
             'status' => 'aberta',
             'codigo' => 'MEN-TEST-' . uniqid()
        ]);

        // Show
        $response = $this->get(route('lider-comunidade.mensalidades.show', $mensalidade->id));
        $response->assertStatus(200);
    }

    #[Test]
    public function lider_can_access_reports_and_pix()
    {
        $this->actingAs($this->liderUser);

        // Reports
        $response = $this->get(route('lider-comunidade.relatorios.index'));
        $response->assertStatus(200);

        // PIX Config
        $response = $this->get(route('lider-comunidade.pix.edit'));
        $response->assertStatus(200);
    }

    // =========================================================================
    // Morador Routes Tests
    // =========================================================================

    #[Test]
    public function morador_public_login_page_is_accessible()
    {
        $response = $this->get(route('morador-poco.index'));
        $response->assertStatus(200);
    }

    #[Test]
    public function morador_authenticated_routes_redirect_if_not_logged_in()
    {
        $routes = [
            'morador-poco.dashboard',
            'morador-poco.historico',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(302); // Redirect to login
            $response->assertRedirect(route('morador-poco.index'));
        }
    }

    #[Test]
    public function morador_can_access_dashboard_when_authenticated()
    {
        // Simulate authentication via session
        $this->withSession(['morador_codigo_acesso' => $this->morador->codigo_acesso]);

        $response = $this->get(route('morador-poco.dashboard'));
        $response->assertStatus(200);
    }

    #[Test]
    public function morador_can_access_historico()
    {
        $this->withSession(['morador_codigo_acesso' => $this->morador->codigo_acesso]);

        $response = $this->get(route('morador-poco.historico'));
        $response->assertStatus(200);
    }
}
