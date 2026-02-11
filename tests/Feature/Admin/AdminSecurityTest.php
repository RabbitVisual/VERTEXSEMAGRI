<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Modules\Funcionarios\App\Models\Funcionario;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $standardAdmin;
    protected $targetFuncionario;
    protected $adminFuncionario;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        $this->artisan('module:enable', ['module' => 'Funcionarios']);

        // Setup Roles
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'campo', 'guard_name' => 'web']);

        // 1. Create Super Admin
        $this->superAdmin = User::factory()->create(['email' => 'super@example.org']);
        $this->superAdmin->assignRole('super-admin');
        $this->superAdmin->assignRole('admin');

        // 2. Create Standard Admin
        $this->standardAdmin = User::factory()->create(['email' => 'admin@example.org']);
        $this->standardAdmin->assignRole('admin');

        // 3. Create Target Funcionario (Observer will create the User)
        $targetEmail = 'joao@campo.org';
        $this->targetFuncionario = Funcionario::create([
            'codigo' => 'FUNC-TEST-01',
            'nome' => 'João Campo',
            'email' => $targetEmail,
            'ativo' => true
        ]);

        // Target User created by observer
        $targetUser = User::where('email', $targetEmail)->first();
        if (!$targetUser) {
             $targetUser = User::factory()->create(['email' => $targetEmail]);
        }
        $targetUser->assignRole('campo');

        // 4. Create another Admin via Funcionario
        $anotherAdminEmail = 'another-admin@example.org';
        $this->adminFuncionario = Funcionario::create([
            'codigo' => 'FUNC-ADM-01',
            'nome' => 'Outro Admin',
            'email' => $anotherAdminEmail,
            'ativo' => true
        ]);

        $anotherAdminUser = User::where('email', $anotherAdminEmail)->first();
        if (!$anotherAdminUser) {
             $anotherAdminUser = User::factory()->create(['email' => $anotherAdminEmail]);
        }
        $anotherAdminUser->assignRole('admin');
    }

    #[Test]
    public function standard_admin_cannot_impersonate_others()
    {
        $response = $this->actingAs($this->standardAdmin)
                         ->get(route('admin.funcionarios.login-as', $this->targetFuncionario->id));

        $response->assertStatus(403);
        $this->assertEquals(auth()->id(), $this->standardAdmin->id);
    }

    #[Test]
    public function super_admin_can_impersonate_campo_user()
    {
        $response = $this->actingAs($this->superAdmin)
                         ->get(route('admin.funcionarios.login-as', $this->targetFuncionario->id));

        $response->assertRedirect(route('campo.ordens.index'));
        $this->assertEquals(auth()->id(), $this->targetFuncionario->user()->id);
        $this->assertEquals(session('impersonator_id'), $this->superAdmin->id);
    }

    #[Test]
    public function super_admin_cannot_impersonate_another_admin_escalation_prevention()
    {
        $response = $this->actingAs($this->superAdmin)
                         ->get(route('admin.funcionarios.login-as', $this->adminFuncionario->id));

        $response->assertStatus(403);
        // Should NOT change user
        $this->assertEquals(auth()->id(), $this->superAdmin->id);
    }

    #[Test]
    public function impersonated_user_can_stop_impersonation()
    {
        // Start impersonation
        $this->actingAs($this->superAdmin)
             ->get(route('admin.funcionarios.login-as', $this->targetFuncionario->id));

        // Stop impersonation
        $response = $this->get(route('admin.stop-impersonation'));

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals(auth()->id(), $this->superAdmin->id);
        $this->assertFalse(session()->has('impersonator_id'));
    }

    #[Test]
    public function unauthorized_user_cannot_stop_impersonation_without_impersonator_id()
    {
        $response = $this->actingAs($this->standardAdmin)
                         ->get(route('admin.stop-impersonation'));

        $response->assertRedirect(route('login'));
        $this->assertNull(auth()->user());
    }
}
