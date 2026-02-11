<?php

namespace Modules\Equipes\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Equipes\App\Models\Equipe;
use Modules\Funcionarios\App\Models\Funcionario;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class EquipesFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock de rotas
        $routes = [
            'dashboard',
            'equipes.index',
            'equipes.create',
            'equipes.store',
            'equipes.show',
            'equipes.edit',
            'equipes.update',
            'equipes.destroy',
            'equipes.export',
            // Rotas dependentes para redirect/links
            'funcionarios.create',
            'funcionarios.show'
        ];

        foreach ($routes as $routeName) {
            if (!Route::has($routeName)) {
                Route::get('/mock/' . $routeName, function () {
                    return 'mock';
                })->name($routeName);
            }
        }

        // Bypass Gate
        Gate::before(function () {
            return true;
        });

        // Setup Roles
        if (DB::table('roles')->where('name', 'admin')->doesntExist()) {
            Role::create(['name' => 'admin']);
        }
    }

    private function createAdminUser()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin_' . uniqid() . '@vertex.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return $user;
    }

    private function createFuncionario($ativo = true)
    {
        // Necessário criar user para lidar com observer de funcionário e evitar erros
        $email = 'func_' . uniqid() . '@teste.com';

        return Funcionario::create([
            'nome' => 'Func ' . uniqid(),
            'funcao' => 'eletricista',
            'email' => $email,
            'ativo' => $ativo,
            'codigo' => 'FUNC-' . uniqid()
        ]);
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(78, count($tables));
    }

    #[Test]
    public function admin_can_access_equipes_index()
    {
        $user = $this->createAdminUser();
        $response = $this->actingAs($user)->get(route('equipes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('equipes::index');
    }

    #[Test]
    public function admin_can_store_equipe_with_funcionarios()
    {
        $user = $this->createAdminUser();
        $f1 = $this->createFuncionario(true);
        $f2 = $this->createFuncionario(true);

        $data = [
            'nome' => 'Equipe Alpha',
            'tipo' => 'eletricistas',
            'ativ' => true, // typo intencional para verificar checkbox
            'ativo' => 1,
            'funcionarios' => [$f1->id, $f2->id],
            'descricao' => 'Equipe de teste'
        ];

        $response = $this->actingAs($user)->post(route('equipes.store'), $data);

        $response->assertRedirect(route('equipes.index'));

        $this->assertDatabaseHas('equipes', [
            'nome' => 'Equipe Alpha',
            'tipo' => 'eletricistas',
            'ativo' => true
        ]);

        $equipe = Equipe::where('nome', 'Equipe Alpha')->first();
        $this->assertNotNull($equipe->codigo);
        $this->assertStringStartsWith('EQP-ELE-', $equipe->codigo); // ELETRICISTAS -> ELE

        // Verificar pivot
        $this->assertEquals(2, $equipe->funcionarios()->count());
        $this->assertTrue($equipe->funcionarios->contains($f1));
        $this->assertTrue($equipe->funcionarios->contains($f2));
    }

    #[Test]
    public function store_fails_without_funcionarios()
    {
        $user = $this->createAdminUser();

        $data = [
            'nome' => 'Equipe Vazia',
            'tipo' => 'mista',
            'ativo' => 1,
            'funcionarios' => [] // Vazio
        ];

        $response = $this->actingAs($user)->post(route('equipes.store'), $data);

        $response->assertSessionHasErrors(['funcionarios']);
    }

    #[Test]
    public function admin_can_update_equipe_and_sync_funcionarios()
    {
        $user = $this->createAdminUser();
        $f1 = $this->createFuncionario();
        $f2 = $this->createFuncionario();
        $f3 = $this->createFuncionario();

        $equipe = Equipe::create([
            'nome' => 'Equipe Beta',
            'tipo' => 'encanadores',
            'ativo' => true,
            'codigo' => 'EQP-OLD-001'
        ]);

        $equipe->funcionarios()->attach([$f1->id, $f2->id]);

        $data = [
            'nome' => 'Equipe Beta Updated',
            'tipo' => 'encanadores',
            'funcionarios' => [$f2->id, $f3->id], // Remove f1, mantem f2, adiciona f3
            // omitindo ativo para desativar
        ];

        $response = $this->actingAs($user)->put(route('equipes.update', $equipe->id), $data);

        $response->assertRedirect(route('equipes.show', $equipe->id));

        $equipe->refresh();
        $this->assertEquals('Equipe Beta Updated', $equipe->nome);
        $this->assertEquals(0, $equipe->ativo); // Deactivated

        $this->assertEquals(2, $equipe->funcionarios()->count());
        $this->assertFalse($equipe->funcionarios->contains($f1));
        $this->assertTrue($equipe->funcionarios->contains($f2));
        $this->assertTrue($equipe->funcionarios->contains($f3));
    }

    #[Test]
    public function admin_can_soft_delete_equipe()
    {
        $user = $this->createAdminUser();
        $equipe = Equipe::create([
            'nome' => 'Equipe Delete',
            'tipo' => 'mista'
        ]);

        $response = $this->actingAs($user)->delete(route('equipes.destroy', $equipe->id));

        $response->assertRedirect(route('equipes.index'));
        $this->assertSoftDeleted('equipes', ['id' => $equipe->id]);
    }

    #[Test]
    public function validate_lider_is_funcionario_of_team()
    {
        $user = $this->createAdminUser();

        // Criar usuário/funcionário que será o líder
        $liderUser = User::create([
            'name' => 'Lider User',
            'email' => 'lider@teste.com',
            'password' => bcrypt('123')
        ]);

        $liderFunc = Funcionario::create([
            'nome' => 'Lider Func',
            'email' => 'lider@teste.com', // Mesmo email conecta os dois
            'funcao' => 'supervisor',
            'ativo' => true,
            'codigo' => 'FUNC-LID'
        ]);

        $fOther = $this->createFuncionario();

        // Tentativa 1: Criar equipe com líder que NÃO está na lista de membros da equipe
        // O controller permite mas emite aviso (warning). O teste verifica o redirecionamento e a msg.

        $data = [
            'nome' => 'Equipe Warning',
            'tipo' => 'mista',
            'lider_id' => $liderUser->id,
            'funcionarios' => [$fOther->id], // Líder não está aqui
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->post(route('equipes.store'), $data);

        // Deve redirecionar para show (com warning) ao invés de index (sucesso padrão)
        // Controller: return redirect()->route('equipes.show', $equipe)->with('warning', ...)

        $response->assertRedirect(); // Difícil validar rota dinâmica exata sem id, mas verifica o redirect
        $response->assertSessionHas('warning');

        $equipe = Equipe::where('nome', 'Equipe Warning')->first();
        $this->assertNotNull($equipe);
        $response->assertRedirect(route('equipes.show', $equipe->id));
    }

    #[Test]
    public function equipe_stats_are_calculated_correctly()
    {
        $equipe = Equipe::create(['nome' => 'Stats Team', 'tipo' => 'mista']);

        $f1 = $this->createFuncionario(true); // Ativo
        $f2 = $this->createFuncionario(false); // Inativo

        $equipe->funcionarios()->attach([$f1->id, $f2->id]);

        $stats = $equipe->estatisticas;

        $this->assertEquals(2, $stats['total_funcionarios']);
        $this->assertEquals(1, $stats['funcionarios_ativos']);
        $this->assertEquals(0, $stats['total_os']);
    }

    #[Test]
    public function scopes_filter_correctly()
    {
        Equipe::create(['nome' => 'Ativa', 'ativo' => true, 'tipo' => 'mista'])->funcionarios()->attach($this->createFuncionario()->id);
        Equipe::create(['nome' => 'Inativa', 'ativo' => false, 'tipo' => 'mista']);
        Equipe::create(['nome' => 'Tipo Elet', 'ativo' => true, 'tipo' => 'eletricistas']);

        $this->assertEquals(2, Equipe::ativas()->count());
        $this->assertEquals(1, Equipe::porTipo('eletricistas')->count());
        $this->assertEquals(1, Equipe::comFuncionarios()->count());
    }

    #[Test]
    public function generate_code_respects_type_prefix()
    {
        $codeEle = Equipe::generateCode('TEST', 'eletricistas');
        $this->assertStringContainsString('TEST-ELE-', $codeEle);

        $codeEnc = Equipe::generateCode('TEST', 'encanadores');
        $this->assertStringContainsString('TEST-ENC-', $codeEnc);

        $codeMis = Equipe::generateCode('TEST', 'mista');
        $this->assertStringContainsString('TEST-MIS-', $codeMis);
    }
}
