<?php

namespace Modules\Funcionarios\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Modules\Funcionarios\App\Models\Funcionario;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;

class FuncionariosFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock de rotas necessárias para o layout admin
        $routes = [
            'dashboard',
            'demandas.index',
            'ordens.index',
            'avisos.index',
            'blog.index',
            'programas.index',
            'localidades.index',
            'pessoas.index',
            'funcionarios.index',
            'funcionarios.create',
            'funcionarios.store',
            'funcionarios.show',
            'funcionarios.edit',
            'funcionarios.update',
            'funcionarios.destroy',
            'funcionarios.reenviar-email',
            'funcionarios.export'
        ];

        foreach ($routes as $routeName) {
            if (!Route::has($routeName)) {
                Route::get('/mock/' . $routeName, function () {
                    return 'mock';
                })->name($routeName);
            }
        }

        // Bypass de Gate para testes
        Gate::before(function () {
            return true;
        });

        // Garantir roles necessárias
        if (DB::table('roles')->where('name', 'admin')->doesntExist()) {
            Role::create(['name' => 'admin']);
        }
        if (DB::table('roles')->where('name', 'campo')->doesntExist()) {
            Role::create(['name' => 'campo']);
        }

        Mail::fake();
    }

    private function createDummyOrdem()
    {
        return DB::table('ordens_servico')->insertGetId([
            'numero' => 'OS-' . uniqid(),
            'tipo_servico' => 'Manutenção',
            'descricao' => 'Teste de Auditoria',
            'status' => 'pendente',
            'prioridade' => 'media',
            'created_at' => now(),
            'updated_at' => now()
        ]);
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

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(78, count($tables));
    }

    #[Test]
    public function admin_can_access_funcionarios_index()
    {
        $user = $this->createAdminUser();
        $response = $this->actingAs($user)->get(route('funcionarios.index'));

        $response->assertStatus(200);
        $response->assertViewIs('funcionarios::index');
    }

    #[Test]
    public function admin_can_store_funcionario_with_auto_code()
    {
        $user = $this->createAdminUser();

        $data = [
            'nome' => 'Funcionario Teste',
            'cpf' => '123.456.789-00',
            'funcao' => 'eletricista',
            'email' => 'func@teste.com',
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->post(route('funcionarios.store'), $data);

        $response->assertRedirect(route('funcionarios.index'));
        $this->assertDatabaseHas('funcionarios', [
            'nome' => 'Funcionario Teste',
            'funcao' => 'eletricista'
        ]);

        $funcionario = Funcionario::where('nome', 'Funcionario Teste')->first();
        $this->assertNotNull($funcionario->codigo);
        $this->assertStringStartsWith('FUNC-', $funcionario->codigo);
    }

    #[Test]
    public function store_fails_without_required_fields()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->post(route('funcionarios.store'), []);

        $response->assertSessionHasErrors(['nome', 'funcao']);
    }

    #[Test]
    public function admin_can_update_funcionario()
    {
        $user = $this->createAdminUser();
        $funcionario = Funcionario::create([
            'nome' => 'Original Name',
            'funcao' => 'tecnico',
            'codigo' => 'FUNC-001'
        ]);

        $data = [
            'nome' => 'Updated Name',
            'funcao' => 'supervisor',
            // Omitir 'ativo' para desativar
        ];

        $response = $this->actingAs($user)->put(route('funcionarios.update', $funcionario->id), $data);

        $response->assertRedirect(route('funcionarios.show', $funcionario->id));
        $this->assertDatabaseHas('funcionarios', [
            'id' => $funcionario->id,
            'nome' => 'Updated Name',
            'funcao' => 'supervisor',
            'ativo' => false
        ]);
    }

    #[Test]
    public function admin_can_soft_delete_funcionario()
    {
        $user = $this->createAdminUser();
        $funcionario = Funcionario::create([
            'nome' => 'To Delete',
            'funcao' => 'outro',
            'codigo' => 'FUNC-DEL'
        ]);

        $response = $this->actingAs($user)->delete(route('funcionarios.destroy', $funcionario->id));

        $response->assertRedirect(route('funcionarios.index'));
        $this->assertSoftDeleted('funcionarios', ['id' => $funcionario->id]);
    }

    #[Test]
    public function admin_can_reenviar_email_and_creates_user_if_missing()
    {
        $admin = $this->createAdminUser();

        // O Observer será disparado e criará o usuário se e-mail estiver configurado e ativo for true
        // Vamos garantir que não existe usuário antes
        User::where('email', 'envio@teste.com')->delete();

        $funcionario = Funcionario::create([
            'nome' => 'Enviado Email',
            'email' => 'envio@teste.com',
            'funcao' => 'motorista',
            'codigo' => 'FUNC-MAIL',
            'ativo' => true
        ]);

        $response = $this->actingAs($admin)->post(route('funcionarios.reenviar-email', $funcionario->id));

        $response->assertRedirect();

        // Verificar se usuário existe (foi criado pelo observer ou pelo controller)
        $this->assertDatabaseHas('users', [
            'email' => 'envio@teste.com',
            'name' => 'Enviado Email'
        ]);

        $user = User::where('email', 'envio@teste.com')->first();
        $this->assertTrue($user->hasRole('campo'));

        // Verificar se senha foi gerada em funcionario_senhas
        $this->assertDatabaseHas('funcionario_senhas', [
            'funcionario_id' => $funcionario->id,
            'user_id' => $user->id,
            'visualizada' => false
        ]);

        // Verificar se e-mail foi "enfileirado" (mocked)
        Mail::assertQueued(\Modules\Funcionarios\App\Mail\FuncionarioCriado::class);
    }

    #[Test]
    public function reenviar_email_fails_without_email_configured()
    {
        $admin = $this->createAdminUser();
        $funcionario = Funcionario::create([
            'nome' => 'Sem Email',
            'funcao' => 'tecnico',
            'codigo' => 'FUNC-SEM'
        ]);

        $response = $this->actingAs($admin)->post(route('funcionarios.reenviar-email', $funcionario->id));

        $response->assertSessionHas('error', 'Este funcionário não possui email cadastrado para reenvio.');
    }

    #[Test]
    public function export_returns_successful_response()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get(route('funcionarios.export'));

        $response->assertStatus(200);
    }

    #[Test]
    public function funcionario_has_status_campo_scopes()
    {
        // Criar ordem fake para Satisfazer FK
        $ordemId = DB::table('ordens_servico')->insertGetId([
            'numero' => 'OS-TEST-001',
            'tipo_servico' => 'Manutenção',
            'descricao' => 'Teste',
            'status' => 'em_execucao',
            'prioridade' => 'media',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $f1 = Funcionario::create([
            'nome' => 'Disp', 'funcao' => 'tecnico', 'codigo' => 'F1',
            'status_campo' => 'disponivel', 'ativo' => true
        ]);
        $f2 = Funcionario::create([
            'nome' => 'Ocup', 'funcao' => 'tecnico', 'codigo' => 'F2',
            'status_campo' => 'em_atendimento', 'ordem_servico_atual_id' => $ordemId, 'ativo' => true
        ]);

        $this->assertEquals(1, Funcionario::disponiveis()->count());
        $this->assertEquals(1, Funcionario::emAtendimento()->count());
        $this->assertEquals(1, Funcionario::ocupados()->count());
    }

    #[Test]
    public function funcionario_calculates_working_time_correctly()
    {
        $funcionario = new Funcionario();
        $funcionario->atendimento_iniciado_em = now()->subMinutes(75);

        $this->assertEquals('1h 15min', $funcionario->tempo_atendimento);
    }

    #[Test]
    public function user_is_activated_deactivated_with_funcionario_observer()
    {
        $email = 'sync@teste.com';

        // Criar usuário antes para o observer não falhar ou duplicar
        $user = User::create([
            'name' => 'Sync User',
            'email' => $email,
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $funcionario = Funcionario::create([
            'nome' => 'Sync Test',
            'email' => $email,
            'funcao' => 'operador',
            'codigo' => 'SYNC-1',
            'ativo' => true
        ]);

        // Desativar funcionário
        $funcionario->update(['ativo' => false]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'active' => false
        ]);

        // Reativar funcionário
        $funcionario->update(['ativo' => true]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'active' => true
        ]);
    }
}
