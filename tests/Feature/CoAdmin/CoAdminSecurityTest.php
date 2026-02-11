<?php

namespace Tests\Feature\CoAdmin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;
use Nwidart\Modules\Facades\Module;

class CoAdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $coAdmin;
    protected $standardUser;

    protected function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\Mail::fake();

        // Setup Roles
        Role::firstOrCreate(['name' => 'co-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Create Co-Admin User with UNIQUE email
        $this->coAdmin = User::factory()->create(['email' => 'coadmin' . rand(1, 99999) . '@example.org']);
        $this->coAdmin->assignRole('co-admin');

        // Create Standard User (no role)
        $this->standardUser = User::factory()->create(['email' => 'user' . rand(1, 99999) . '@example.org']);
    }

    #[Test]
    public function co_admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->coAdmin)
                         ->get(route('co-admin.dashboard'));

        $response->assertStatus(200);
    }

    #[Test]
    public function co_admin_can_access_demandas_index_if_enabled()
    {
        if (!Module::isEnabled('Demandas')) {
            $this->markTestSkipped('Modulo Demandas desabilitado.');
        }

        $response = $this->actingAs($this->coAdmin)
                         ->get(route('co-admin.demandas.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function co_admin_cannot_access_demandas_destroy_route()
    {
        if (!Module::isEnabled('Demandas')) {
            $this->markTestSkipped('Modulo Demandas desabilitado.');
        }

        // Como a URL /{id} existe para GET/PUT, o DELETE deve retornar 405 (Method Not Allowed)
        // provando que a rota deletar foi removida explicitamente.
        $response = $this->actingAs($this->coAdmin)
                         ->delete('/co-admin/demandas/1');

        $response->assertStatus(405);
    }

    #[Test]
    public function co_admin_cannot_access_ordens_destroy_route()
    {
        if (!Module::isEnabled('Ordens')) {
            $this->markTestSkipped('Modulo Ordens desabilitado.');
        }

        $response = $this->actingAs($this->coAdmin)
                         ->delete('/co-admin/ordens/1');

        $response->assertStatus(405);
    }

    #[Test]
    public function standard_user_cannot_access_co_admin_panel()
    {
        $response = $this->actingAs($this->standardUser)
                         ->get(route('co-admin.dashboard'));

        $response->assertStatus(403);
    }

    #[Test]
    public function guest_is_redirected_to_login()
    {
        $response = $this->get(route('co-admin.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
