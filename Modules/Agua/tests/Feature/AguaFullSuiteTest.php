<?php

namespace Modules\Agua\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Modules\Agua\App\Models\RedeAgua;
use Modules\Agua\App\Models\PontoDistribuicao;
use Modules\Localidades\App\Models\Localidade;

class AguaFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock mandatory routes referenced by admin layout views
        Route::get('/admin/dashboard', fn() => 'dashboard')->name('admin.dashboard');
        Route::get('/admin/localidades/{id}', fn() => 'localidade')->name('admin.localidades.show');
        Route::get('/admin/demandas', fn() => 'demandas')->name('admin.demandas.index');
        Route::get('/admin/demandas/{id}', fn() => 'demanda')->name('admin.demandas.show');
        Route::get('/admin/ordens', fn() => 'ordens')->name('admin.ordens.index');
        Route::get('/admin/ordens/{id}', fn() => 'ordem')->name('admin.ordens.show');
        Route::get('/localidades/create', fn() => 'create_loc')->name('localidades.create');
    }

    /**
     * Create an admin user with proper role and permissions
     */
    private function createAdminUser(): User
    {
        $role = DB::table('roles')->where('name', 'admin')->first();
        if (!$role) {
            $roleId = DB::table('roles')->insertGetId([
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $roleId = $role->id;
        }

        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin_' . uniqid() . '@vertex.com',
            'password' => bcrypt('secret')
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,
            'model_type' => User::class,
            'model_id' => $user->id
        ]);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return $user;
    }

    // =======================================
    // 1. Gold Standard – Schema Parity
    // =======================================

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertCount(78, $tables, "O banco de dados de teste deve conter exatamente 78 tabelas para paridade com produção. Encontradas: " . count($tables));
    }

    // =======================================
    // 2. Public Controller – Index
    // =======================================

    #[Test]
    public function admin_can_access_agua_index()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);

        RedeAgua::create([
            'codigo' => 'RED-001',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $response = $this->actingAs($user)->get(route('agua.index'));
        $response->assertStatus(200);
        $response->assertSee('RED-001');
    }

    // =======================================
    // 3. Public Controller – Store (auto-code)
    // =======================================

    #[Test]
    public function admin_can_store_new_rede_agua()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);

        // Controller auto-generates 'codigo' via RedeAgua::generateCode('RED', tipo_rede)
        $data = [
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'secundaria',
            'diametro' => '50mm',
            'material' => 'PVC',
            'extensao_metros' => 1500,
            'status' => 'funcionando'
        ];

        $response = $this->actingAs($user)->post(route('agua.store'), $data);
        $response->assertRedirect(route('agua.index'));
        $this->assertDatabaseHas('redes_agua', [
            'tipo_rede' => 'secundaria',
            'material' => 'PVC'
        ]);

        $rede = RedeAgua::first();
        $this->assertNotNull($rede->codigo);
        $this->assertStringStartsWith('RED-SEC-', $rede->codigo, 'Código deve iniciar com RED-SEC- para tipo secundaria');
    }

    // =======================================
    // 4. Validation – Store fails without valid localidade
    // =======================================

    #[Test]
    public function store_fails_without_localidade()
    {
        $user = $this->createAdminUser();

        $data = [
            'localidade_id' => 999, // Non-existent
            'tipo_rede' => 'ramal',
            'status' => 'funcionando'
        ];

        $response = $this->actingAs($user)->post(route('agua.store'), $data);
        $response->assertSessionHasErrors(['localidade_id']);
    }

    // =======================================
    // 5. Public Controller – Update
    // =======================================

    #[Test]
    public function admin_can_update_rede_agua()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);
        $rede = RedeAgua::create([
            'codigo' => 'RED-UPD',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $data = [
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'com_vazamento',
            'material' => 'Ferro'
        ];

        $response = $this->actingAs($user)->put(route('agua.update', $rede->id), $data);
        $response->assertRedirect(route('agua.index'));
        $this->assertEquals('com_vazamento', $rede->fresh()->status);
        $this->assertEquals('Ferro', $rede->fresh()->material);
    }

    // =======================================
    // 6. Public Controller – Destroy (SoftDelete)
    // =======================================

    #[Test]
    public function admin_can_destroy_rede_agua()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);
        $rede = RedeAgua::create([
            'codigo' => 'RED-DEL',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $response = $this->actingAs($user)->delete(route('agua.destroy', $rede->id));
        $response->assertRedirect(route('agua.index'));
        $this->assertSoftDeleted('redes_agua', ['id' => $rede->id]);
    }

    // =======================================
    // 7. Model – Estatísticas Accessor
    // =======================================

    #[Test]
    public function statistics_return_correct_data()
    {
        $localidade = Localidade::create(['nome' => 'Setor 1', 'codigo' => 'S1', 'ativo' => true]);
        $rede = RedeAgua::create([
            'codigo' => 'RED-STATS',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        // Create related demands in same localidade with type 'agua'
        DB::table('demandas')->insert([
            [
                'codigo' => 'D1',
                'localidade_id' => $localidade->id,
                'tipo' => 'agua',
                'status' => 'aberta',
                'created_at' => now(),
                'updated_at' => now(),
                'prioridade' => 'media',
                'solicitante_nome' => 'Solicitante 1',
                'motivo' => 'Teste'
            ],
            [
                'codigo' => 'D2',
                'localidade_id' => $localidade->id,
                'tipo' => 'agua',
                'status' => 'concluida',
                'created_at' => now(),
                'updated_at' => now(),
                'prioridade' => 'baixa',
                'solicitante_nome' => 'Solicitante 2',
                'motivo' => 'Teste 2'
            ],
        ]);

        // Create related distribution point
        PontoDistribuicao::create([
            'codigo' => 'P1',
            'rede_agua_id' => $rede->id,
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua A',
            'tipo' => 'hidrante',
            'status' => 'funcionando'
        ]);

        $stats = $rede->estatisticas;

        $this->assertEquals(2, $stats['total_demandas']);
        $this->assertEquals(1, $stats['demandas_abertas']);
        $this->assertEquals(1, $stats['total_pontos']);
    }

    // =======================================
    // 8. Admin Panel – Index
    // =======================================

    #[Test]
    public function admin_can_access_admin_dashboard_index()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);

        RedeAgua::create([
            'codigo' => 'RED-DASH',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $response = $this->actingAs($user)->get(route('admin.agua.index'));
        $response->assertStatus(200);
        $response->assertSee('Gestão de Água');
        $response->assertSee('RED-DASH');
    }

    // =======================================
    // 9. Admin Panel – Show Detail
    // =======================================

    #[Test]
    public function admin_can_access_admin_dashboard_show()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);
        $rede = RedeAgua::create([
            'codigo' => 'RED-DET',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $response = $this->actingAs($user)->get(route('admin.agua.show', $rede->id));
        $response->assertStatus(200);
        $response->assertSee('RED-DET');
    }

    // =======================================
    // 10. Export – CSV
    // =======================================

    #[Test]
    public function export_csv_returns_correct_response()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'codigo' => 'CEN', 'ativo' => true]);
        RedeAgua::create([
            'codigo' => 'EXP-001',
            'localidade_id' => $localidade->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $response = $this->actingAs($user)->get(route('agua.index', ['format' => 'csv']));
        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('EXP-001', $response->streamedContent());
    }

    // =======================================
    // 11. Model – Code Generation
    // =======================================

    #[Test]
    public function rede_agua_generates_unique_codes()
    {
        $code1 = RedeAgua::generateCode('RED', 'principal');
        $this->assertStringStartsWith('RED-PRI-', $code1);

        $loc = Localidade::create(['nome' => 'Code Test', 'ativo' => true]);
        RedeAgua::create([
            'codigo' => $code1,
            'localidade_id' => $loc->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        $code2 = RedeAgua::generateCode('RED', 'principal');
        $this->assertNotEquals($code1, $code2, 'Códigos devem ser únicos após inserção');
        $this->assertStringStartsWith('RED-PRI-', $code2);
    }

    // =======================================
    // 12. Relationships – RedeAgua ↔ PontoDistribuicao
    // =======================================

    #[Test]
    public function rede_agua_has_pontos_distribuicao_relationship()
    {
        $loc = Localidade::create(['nome' => 'Setor Rel ' . uniqid(), 'ativo' => true]);
        $rede = RedeAgua::create([
            'codigo' => RedeAgua::generateCode('RED', 'principal'),
            'localidade_id' => $loc->id,
            'tipo_rede' => 'principal',
            'status' => 'funcionando'
        ]);

        PontoDistribuicao::create([
            'codigo' => 'PD-1',
            'rede_agua_id' => $rede->id,
            'localidade_id' => $loc->id,
            'endereco' => 'Rua A',
            'tipo' => 'hidrante',
            'status' => 'funcionando'
        ]);

        PontoDistribuicao::create([
            'codigo' => 'PD-2',
            'rede_agua_id' => $rede->id,
            'localidade_id' => $loc->id,
            'endereco' => 'Rua B',
            'tipo' => 'reservatorio',
            'status' => 'funcionando'
        ]);

        $this->assertEquals(2, $rede->pontosDistribuicao()->count());
        $this->assertEquals($loc->nome, $rede->localidade->nome);
    }
}
