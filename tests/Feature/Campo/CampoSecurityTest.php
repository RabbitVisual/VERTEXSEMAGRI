<?php

namespace Tests\Feature\Campo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Mail;

class CampoSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $campoUser;
    protected $standardUser;
    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        // Setup Roles
        Role::firstOrCreate(['name' => 'campo', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Create Campo User
        $this->campoUser = User::factory()->create(['email' => 'campo' . rand(1, 9999) . '@example.org']);
        $this->campoUser->assignRole('campo');

        // Garantir que a equipe exista antes de vincular o membro (Foreign Key)
        \Illuminate\Support\Facades\DB::table('equipes')->insertOrIgnore([
            'id' => 1,
            'nome' => 'Equipe Teste',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Vincular o usuário a uma equipe para satisfazer o EnsureUserIsFuncionario middleware
        \Illuminate\Support\Facades\DB::table('equipe_membros')->insertOrIgnore([
            'equipe_id' => 1,
            'user_id' => $this->campoUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Admin User
        $this->adminUser = User::factory()->create(['email' => 'admin' . rand(1, 9999) . '@example.org']);
        $this->adminUser->assignRole('admin');

        // Create Standard User (no role)
        $this->standardUser = User::factory()->create(['email' => 'user' . rand(1, 9999) . '@example.org']);
    }

    #[Test]
    public function campo_user_can_access_dashboard()
    {
        $response = $this->actingAs($this->campoUser)
                         ->get(route('campo.dashboard'));

        $response->assertStatus(200);
    }

    #[Test]
    public function campo_user_can_access_profile()
    {
        $response = $this->actingAs($this->campoUser)
                         ->get(route('campo.profile.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function campo_user_can_access_ordens_index_if_enabled()
    {
        if (!Module::isEnabled('Ordens')) {
            $this->markTestSkipped('Modulo Ordens desabilitado.');
        }

        $response = $this->actingAs($this->campoUser)
                         ->get(route('campo.ordens.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function campo_user_cannot_access_ordens_destroy_route_as_it_is_missing()
    {
        if (!Module::isEnabled('Ordens')) {
            $this->markTestSkipped('Modulo Ordens desabilitado.');
        }

        // Tentar acessar uma rota que não foi definida deve resultar em 404
        // Diferente do co-admin onde /{id} existe para PUT/GET, aqui testaremos o DELETE explicito
        $response = $this->actingAs($this->campoUser)
                         ->delete('/campo/ordens/1');

        // Como não há rota DELETE definida em campo.php para ordens/{id}, deve ser 404 ou 405 se a URL casar com outra rota
        // Em campo.php temos Route::get('/{id}', ...). O Laravel pode retornar 405 se a URL bater.
        $this->assertTrue(in_array($response->getStatusCode(), [404, 405]));
    }

    #[Test]
    public function admin_cannot_access_campo_panel_without_role()
    {
        // Embora admin tenha muitos poderes, o middleware 'role:campo' é restritivo
        $response = $this->actingAs($this->adminUser)
                         ->get(route('campo.dashboard'));

        $response->assertStatus(403);
    }

    #[Test]
    public function standard_user_cannot_access_campo_panel()
    {
        $response = $this->actingAs($this->standardUser)
                         ->get(route('campo.dashboard'));

        $response->assertStatus(403);
    }

    #[Test]
    public function guest_is_redirected_to_login()
    {
        $response = $this->get(route('campo.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
