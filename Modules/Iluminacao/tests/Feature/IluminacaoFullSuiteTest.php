<?php

namespace Modules\Iluminacao\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Modules\Iluminacao\App\Models\PontoLuz;
use Modules\Iluminacao\App\Models\Poste;
use Modules\Iluminacao\App\Models\PontoLuzHistorico;
use Modules\Localidades\App\Models\Localidade;
use Modules\Demandas\App\Models\Demanda;

class IluminacaoFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock mandatory routes for admin layout that are not part of this module
        Route::get('/admin/dashboard', fn() => 'dashboard')->name('admin.dashboard');
        Route::get('/admin/localidades/{id}', fn() => 'localidade')->name('admin.localidades.show');
        Route::get('/admin/demandas', fn() => 'demandas')->name('admin.demandas.index');
        Route::get('/admin/demandas/{id}', fn() => 'demanda')->name('admin.demandas.show');
        Route::get('/admin/ordens', fn() => 'ordens')->name('admin.ordens.index');
        Route::get('/admin/ordens/{id}', fn() => 'ordem')->name('admin.ordens.show');
        Route::get('/localidades/create', fn() => 'create')->name('localidades.create');
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

        // Grant all abilities via Gate
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
    // 2. Admin Panel – Postes CRUD
    // =======================================

    #[Test]
    public function admin_can_create_and_view_poste()
    {
        $user = $this->createAdminUser();

        $data = [
            'codigo' => 'POSTE-TEST-' . uniqid(),
            'latitude' => -15.12345678,
            'longitude' => -47.12345678,
            'tipo_lampada' => 'LED',
            'potencia' => 150,
            'logradouro' => 'Rua das Flores',
            'bairro' => 'Centro',
            'trafo' => 'TRAFO-A',
            'barramento' => 1
        ];

        $response = $this->actingAs($user)->post(route('admin.iluminacao.postes.store'), $data);
        $response->assertRedirect(route('admin.iluminacao.postes.index'));
        $this->assertDatabaseHas('postes', ['codigo' => $data['codigo']]);

        $poste = Poste::where('codigo', $data['codigo'])->first();
        $this->assertNotNull($poste);

        $response = $this->actingAs($user)->get(route('admin.iluminacao.postes.show', $poste->id));
        $response->assertStatus(200);
        $response->assertSee($data['codigo']);
    }

    // =======================================
    // 3. Public Controller – Pontos de Luz CRUD
    // =======================================

    #[Test]
    public function admin_can_create_ponto_luz_via_public_controller()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Setor Norte ' . uniqid(),
            'codigo' => 'SN' . rand(100, 999),
            'ativo' => true
        ]);

        // The store method auto-generates 'codigo' via PontoLuz::generateCode
        $data = [
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua Principal, 100',
            'status' => 'funcionando',
            'tipo_lampada' => 'Vapor de Sódio',
            'potencia' => 250,
            'tipo_poste' => 'concreto'
        ];

        $response = $this->actingAs($user)->post(route('iluminacao.store'), $data);
        $response->assertRedirect(route('iluminacao.index'));
        $this->assertDatabaseHas('pontos_luz', ['endereco' => 'Rua Principal, 100']);

        $ponto = PontoLuz::where('endereco', 'Rua Principal, 100')->first();
        $this->assertNotNull($ponto);
        $this->assertNotEmpty($ponto->codigo, 'O código deve ser gerado automaticamente');
    }

    #[Test]
    public function admin_can_update_ponto_luz()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Localidade Update ' . uniqid(),
            'codigo' => 'LU' . rand(100, 999),
            'ativo' => true
        ]);

        $ponto = PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua Teste',
            'status' => 'funcionando',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        $response = $this->actingAs($user)->put(route('iluminacao.update', $ponto->id), [
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua Teste',
            'status' => 'com_defeito',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto',
            'observacoes' => 'Lampada queimada'
        ]);

        $response->assertRedirect(route('iluminacao.index'));
        $this->assertEquals('com_defeito', $ponto->fresh()->status);
    }

    #[Test]
    public function admin_can_soft_delete_ponto_luz()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Localidade Delete ' . uniqid(),
            'codigo' => 'LD' . rand(100, 999),
            'ativo' => true
        ]);

        $ponto = PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua a Deletar',
            'status' => 'desligado',
            'tipo_lampada' => 'LED',
            'potencia' => 50,
            'tipo_poste' => 'madeira'
        ]);

        $this->actingAs($user)->delete(route('iluminacao.destroy', $ponto->id));
        $this->assertSoftDeleted('pontos_luz', ['id' => $ponto->id]);
    }

    // =======================================
    // 4. Observer – Demanda → Histórico
    // =======================================

    #[Test]
    public function completing_demanda_with_ponto_luz_creates_history_record()
    {
        $user = User::create([
            'name' => 'Suporte',
            'email' => 'sup_' . uniqid() . '@ilum.com',
            'password' => bcrypt('secret')
        ]);

        $localidade = Localidade::create([
            'nome' => 'Setor Sul ' . uniqid(),
            'ativo' => true
        ]);

        $ponto = PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $localidade->id,
            'endereco' => 'Rua B',
            'status' => 'com_defeito',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        // Demanda uses GeneratesCode trait which auto-generates 'codigo' on boot
        // but we need to provide it since the trait only has a static helper
        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'luz'),
            'solicitante_nome' => 'Cidadão Teste',
            'motivo' => 'Lâmpada Queimada',
            'tipo' => 'luz',
            'status' => 'aberta',
            'localidade_id' => $localidade->id,
            'ponto_luz_id' => $ponto->id,
            'descricao' => 'Troca de lâmpada LED',
            'user_id' => $user->id
        ]);

        // Trigger the observer by changing status to 'concluida'
        $demanda->update(['status' => 'concluida']);

        $this->assertDatabaseHas('pontos_luz_historico', [
            'ponto_luz_id' => $ponto->id,
            'demanda_id' => $demanda->id,
            'tipo_evento' => 'manutencao'
        ]);

        $historico = PontoLuzHistorico::where('ponto_luz_id', $ponto->id)->first();
        $this->assertNotNull($historico);
        $this->assertStringContainsString('Serviço concluído via Demanda', $historico->descricao);
    }

    // =======================================
    // 5. Relationships – PontoLuz ↔ Localidade
    // =======================================

    #[Test]
    public function pontos_luz_integration_with_localidades()
    {
        $loc1 = Localidade::create(['nome' => 'Zona 1 ' . uniqid(), 'ativo' => true]);
        $loc2 = Localidade::create(['nome' => 'Zona 2 ' . uniqid(), 'ativo' => true]);

        PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $loc1->id,
            'endereco' => 'Rua 1',
            'status' => 'funcionando',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $loc2->id,
            'endereco' => 'Rua 2',
            'status' => 'funcionando',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        $this->assertEquals(1, PontoLuz::where('localidade_id', $loc1->id)->count());
        $this->assertEquals(1, PontoLuz::where('localidade_id', $loc2->id)->count());

        $ponto = PontoLuz::where('localidade_id', $loc1->id)->first();
        $this->assertEquals($loc1->nome, $ponto->localidade->nome);
    }

    // =======================================
    // 6. Admin Export – Neoenergia CSV
    // =======================================

    #[Test]
    public function admin_can_export_iluminacao_audit_csv()
    {
        $user = $this->createAdminUser();
        $loc = Localidade::create(['nome' => 'Local Export ' . uniqid(), 'ativo' => true]);

        PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'VS'),
            'localidade_id' => $loc->id,
            'endereco' => 'Rua Export',
            'status' => 'funcionando',
            'tipo_lampada' => 'Vapor de Sódio',
            'potencia' => 150,
            'tipo_poste' => 'metalico'
        ]);

        // Admin Export (Neoenergia audit format via IluminacaoAdminController)
        $response = $this->actingAs($user)->get(route('admin.iluminacao.export'));
        $response->assertStatus(200);
        $this->assertStringContainsString('RELATÓRIO DE AUDITORIA', $response->streamedContent());
    }

    // =======================================
    // 7. Public Export – Standard CSV
    // =======================================

    #[Test]
    public function admin_can_export_pontos_luz_csv()
    {
        $user = $this->createAdminUser();
        $loc = Localidade::create(['nome' => 'Export Loc ' . uniqid(), 'ativo' => true]);

        PontoLuz::create([
            'codigo' => PontoLuz::generateCode('PL', 'LED'),
            'localidade_id' => $loc->id,
            'endereco' => 'Rua CSV Export',
            'status' => 'funcionando',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        // Public controller export via ?format=csv
        $response = $this->actingAs($user)->get(route('iluminacao.index', ['format' => 'csv']));
        $response->assertStatus(200);
        $this->assertStringContainsString('Rua CSV Export', $response->streamedContent());
    }

    // =======================================
    // 8. Admin Panel – Index Access
    // =======================================

    #[Test]
    public function admin_can_access_iluminacao_admin_index()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get(route('admin.iluminacao.index'));
        $response->assertStatus(200);
    }

    // =======================================
    // 9. Model – Code Generation
    // =======================================

    #[Test]
    public function ponto_luz_generates_unique_codes()
    {
        $code1 = PontoLuz::generateCode('PL', 'LED');
        $code2 = PontoLuz::generateCode('PL', 'LED');

        // Before any records, both should generate the same base (first one)
        $this->assertStringStartsWith('PL-LED-', $code1);
        $this->assertStringStartsWith('PL-LED-', $code2);

        // Create one, then generate again
        $loc = Localidade::create(['nome' => 'Code Test', 'ativo' => true]);
        PontoLuz::create([
            'codigo' => $code1,
            'localidade_id' => $loc->id,
            'endereco' => 'Rua Code',
            'status' => 'funcionando',
            'tipo_lampada' => 'LED',
            'potencia' => 100,
            'tipo_poste' => 'concreto'
        ]);

        $code3 = PontoLuz::generateCode('PL', 'LED');
        $this->assertNotEquals($code1, $code3, 'Códigos devem ser únicos após inserção');
    }
}
