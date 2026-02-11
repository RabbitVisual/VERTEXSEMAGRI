<?php

namespace Modules\ProgramasAgricultura\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Modules\ProgramasAgricultura\App\Models\Programa;
use Modules\ProgramasAgricultura\App\Models\Beneficiario;
use Modules\ProgramasAgricultura\App\Models\Evento;
use Modules\ProgramasAgricultura\App\Models\InscricaoEvento;
use Modules\Localidades\App\Models\Localidade;

class ProgramasAgriculturaFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Registrar rota de dashboard para evitar erros de redirecionamento
        Route::get('/admin/dashboard', fn() => 'dashboard')->name('admin.dashboard');

        // Criar roles básicas para os testes de permissão
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'co-admin', 'guard_name' => 'web']);
    }

    // =======================================
    // 1. Gold Standard – Schema Parity
    // =======================================

    #[Test]
    public function database_has_79_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES'); // Or use schema for sqlite
        // If MySQL
        $tableNames = array_map(fn($t) => (string)array_values((array)$t)[0], $tables);
        file_put_contents(base_path('tables_test.txt'), implode("\n", $tableNames));

        $this->assertCount(79, $tables, "O banco de dados de teste deve conter exatamente 79 tabelas. Encontradas: " . count($tables));
    }

    // =======================================
    // 2. Model – Programa CRUD Direto
    // =======================================

    #[Test]
    public function can_create_and_read_programa()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'seguro_safra'),
            'nome' => 'Seguro Safra 2026',
            'descricao' => 'Programa de seguro para agricultores familiares',
            'tipo' => 'seguro_safra',
            'status' => 'ativo',
            'data_inicio' => now()->subDays(30),
            'data_fim' => now()->addDays(180),
            'vagas_disponiveis' => 100,
            'vagas_preenchidas' => 0,
            'orgao_responsavel' => 'SEMAGRI',
            'publico' => true
        ]);

        $this->assertNotNull($programa->id);
        $this->assertStringStartsWith('PRG-SEG-', $programa->codigo);
        $this->assertDatabaseHas('programas', ['nome' => 'Seguro Safra 2026']);
    }

    #[Test]
    public function can_update_programa()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'pronaf'),
            'nome' => 'PRONAF Original',
            'tipo' => 'pronaf',
            'status' => 'ativo',
            'publico' => true
        ]);

        $programa->update(['nome' => 'PRONAF Atualizado', 'status' => 'suspenso']);

        $this->assertEquals('PRONAF Atualizado', $programa->fresh()->nome);
        $this->assertEquals('suspenso', $programa->fresh()->status);
    }

    #[Test]
    public function can_soft_delete_programa()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'capacitacao'),
            'nome' => 'Capacitação Rural',
            'tipo' => 'capacitacao',
            'status' => 'ativo',
            'publico' => true
        ]);

        $programa->delete();
        $this->assertSoftDeleted('programas', ['id' => $programa->id]);
    }

    // =======================================
    // 3. Model – Accessors
    // =======================================

    #[Test]
    public function programa_accessors_work_correctly()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'seguro_safra'),
            'nome' => 'Seguro Safra',
            'tipo' => 'seguro_safra',
            'status' => 'ativo',
            'vagas_disponiveis' => 100,
            'vagas_preenchidas' => 30,
            'data_inicio' => now()->subDays(10),
            'data_fim' => now()->addDays(60),
            'publico' => true
        ]);

        $this->assertEquals('Seguro Safra', $programa->tipo_texto);
        $this->assertEquals('Ativo', $programa->status_texto);
        $this->assertEquals(70, $programa->vagas_restantes);
        $this->assertTrue($programa->tem_vagas);
        $this->assertTrue($programa->esta_ativo);
    }

    #[Test]
    public function programa_detects_full_capacity()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'feira_agricola'),
            'nome' => 'Feira Lotada',
            'tipo' => 'feira_agricola',
            'status' => 'ativo',
            'vagas_disponiveis' => 10,
            'vagas_preenchidas' => 10,
            'publico' => true
        ]);

        $this->assertEquals(0, $programa->vagas_restantes);
        $this->assertFalse($programa->tem_vagas);
    }

    #[Test]
    public function programa_without_vagas_limit_has_unlimited()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'assistencia_tecnica'),
            'nome' => 'Assistência Técnica Ilimitada',
            'tipo' => 'assistencia_tecnica',
            'status' => 'ativo',
            'publico' => true
        ]);

        $this->assertNull($programa->vagas_restantes);
        $this->assertTrue($programa->tem_vagas);
    }

    // =======================================
    // 4. Model – Scopes
    // =======================================

    #[Test]
    public function programa_scopes_filter_correctly()
    {
        Programa::create([
            'codigo' => Programa::generateCode('PRG', 'pronaf'),
            'nome' => 'Ativo Público',
            'tipo' => 'pronaf',
            'status' => 'ativo',
            'publico' => true,
            'data_inicio' => now()->subDays(10),
            'data_fim' => now()->addDays(60),
            'vagas_disponiveis' => 50,
            'vagas_preenchidas' => 10
        ]);

        Programa::create([
            'codigo' => Programa::generateCode('PRG', 'capacitacao'),
            'nome' => 'Inativo',
            'tipo' => 'capacitacao',
            'status' => 'inativo',
            'publico' => false
        ]);

        Programa::create([
            'codigo' => Programa::generateCode('PRG', 'credito_rural'),
            'nome' => 'Sem Vagas',
            'tipo' => 'credito_rural',
            'status' => 'ativo',
            'publico' => true,
            'vagas_disponiveis' => 5,
            'vagas_preenchidas' => 5
        ]);

        $this->assertEquals(2, Programa::ativos()->count());
        $this->assertEquals(2, Programa::publicos()->count());
        $this->assertEquals(1, Programa::porTipo('pronaf')->count());
        $this->assertEquals(1, Programa::comVagas()->ativos()->publicos()->count());
        // disponiveis() filters by ativo+publico+date, but NOT by comVagas
        $this->assertEquals(2, Programa::disponiveis()->count());
        // comVagas + disponiveis narrows it down
        $this->assertEquals(1, Programa::disponiveis()->comVagas()->count());
    }

    // =======================================
    // 5. Model – Beneficiário CRUD
    // =======================================

    #[Test]
    public function can_create_beneficiario_linked_to_programa()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'seguro_safra'),
            'nome' => 'Seguro Safra',
            'tipo' => 'seguro_safra',
            'status' => 'ativo',
            'vagas_disponiveis' => 50,
            'vagas_preenchidas' => 0,
            'publico' => true
        ]);

        $user = User::create([
            'name' => 'Operador',
            'email' => 'op_' . uniqid() . '@vertex.com',
            'password' => bcrypt('secret')
        ]);

        $beneficiario = Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'João da Silva',
            'cpf' => '12345678901',
            'telefone' => '(63) 99999-9999',
            'status' => 'inscrito',
            'data_inscricao' => now(),
            'user_id_inscricao' => $user->id
        ]);

        $this->assertDatabaseHas('beneficiarios', ['nome' => 'João da Silva']);
        $this->assertEquals('inscrito', $beneficiario->status);
        $this->assertEquals('Inscrito', $beneficiario->status_texto);
        $this->assertEquals('123.456.789-01', $beneficiario->cpf_formatado);
    }

    // =======================================
    // 6. Relationships – Programa ↔ Beneficiário
    // =======================================

    #[Test]
    public function programa_has_beneficiarios_relationship()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'pronaf'),
            'nome' => 'PRONAF Relationship',
            'tipo' => 'pronaf',
            'status' => 'ativo',
            'publico' => true
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Maria',
            'cpf' => '11111111111',
            'status' => 'inscrito',
            'data_inscricao' => now()
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Pedro',
            'cpf' => '22222222222',
            'status' => 'aprovado',
            'data_inscricao' => now()
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Carlos',
            'cpf' => '33333333333',
            'status' => 'cancelado',
            'data_inscricao' => now()
        ]);

        $this->assertEquals(3, $programa->beneficiarios()->count());
        $this->assertEquals(2, $programa->beneficiariosAtivos()->count()); // inscrito + aprovado
    }

    // =======================================
    // 7. Model – Code Generation
    // =======================================

    #[Test]
    public function programa_generates_unique_codes()
    {
        $code1 = Programa::generateCode('PRG', 'seguro_safra');
        $this->assertStringStartsWith('PRG-SEG-', $code1);

        Programa::create([
            'codigo' => $code1,
            'nome' => 'Prog 1',
            'tipo' => 'seguro_safra',
            'status' => 'ativo',
            'publico' => true
        ]);

        $code2 = Programa::generateCode('PRG', 'seguro_safra');
        $this->assertNotEquals($code1, $code2, 'Códigos devem ser únicos após inserção');
    }

    // =======================================
    // 8. Beneficiário Scopes
    // =======================================

    // =======================================
    // 9. Feature – Admin Programas
    // =======================================

    #[Test]
    public function admin_can_access_programas_index()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_test@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.programas-agricultura.programas.index'));
        $response->assertStatus(200);
        $response->assertSee('Gestão de Programas');
    }

    #[Test]
    public function admin_can_store_programa()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_store@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $data = [
            'codigo' => 'PRG-TEST-STORE',
            'nome' => 'Novo Programa Teste',
            'descricao' => 'Descrição do programa teste',
            'tipo' => 'seguro_safra',
            'status' => 'ativo',
            'data_inicio' => now()->format('Y-m-d'),
            'data_fim' => now()->addDays(30)->format('Y-m-d'),
            'vagas_disponiveis' => 100,
            'orgao_responsavel' => 'SEMAGRI',
            'publico' => 1
        ];

        $response = $this->actingAs($admin)->post(route('admin.programas-agricultura.programas.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.programas-agricultura.programas.index'));
        $this->assertDatabaseHas('programas', ['nome' => 'Novo Programa Teste']);
    }

    #[Test]
    public function admin_can_view_programa_details()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_show@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $programa = Programa::create([
            'codigo' => 'PRG-TEST-001',
            'nome' => 'Programa Detalhe',
            'tipo' => 'pronaf',
            'status' => 'ativo',
            'publico' => true
        ]);

        $response = $this->actingAs($admin)->get(route('admin.programas-agricultura.programas.show', $programa->id));
        $response->assertStatus(200);
        $response->assertSee('Programa Detalhe');
    }

    // =======================================
    // 10. Feature – Admin Eventos
    // =======================================

    #[Test]
    public function admin_can_access_eventos_index()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_eventos@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.programas-agricultura.eventos.index'));
        $response->assertStatus(200);
        $response->assertSee('Agenda de Eventos');
    }

    #[Test]
    public function admin_can_store_evento()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_ev_store@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $localidade = Localidade::create(['nome' => 'Sede', 'tipo' => 'sede', 'codigo' => 'LOC-001', 'ativo' => true]);

        $data = [
            'titulo' => 'Treinamento Tratores',
            'tipo' => 'palestra',
            'status' => 'agendado',
            'data_inicio' => now()->addDays(5)->format('Y-m-d'),
            'hora_inicio' => '14:00',
            'localidade_id' => $localidade->id,
            'vagas_totais' => 30,
            'descricao' => 'Treinamento para operação de novos tratores.'
        ];

        $response = $this->actingAs($admin)->post(route('admin.programas-agricultura.eventos.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.programas-agricultura.eventos.index'));
        $this->assertDatabaseHas('eventos', ['titulo' => 'Treinamento Tratores']);
    }

    // =======================================
    // 11. Feature – Admin Beneficiários & Inscrições
    // =======================================

    #[Test]
    public function admin_can_update_beneficiario_status()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_ben@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $programa = Programa::create(['codigo' => 'PRG-001', 'nome' => 'Prog 1', 'tipo' => 'pronaf', 'status' => 'ativo', 'publico' => true]);
        $beneficiario = Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Maria Teste',
            'cpf' => '00000000000',
            'status' => 'inscrito'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.programas-agricultura.beneficiarios.update-status', $beneficiario->id), [
            'status' => 'aprovado',
            'observacoes' => 'Documentação OK'
        ]);

        $response->assertRedirect();
        $this->assertEquals('aprovado', $beneficiario->fresh()->status);
    }

    #[Test]
    public function admin_can_update_inscricao_status()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_ins@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $evento = Evento::create([
            'codigo' => 'EVT-001',
            'titulo' => 'Evento 1',
            'tipo' => 'palestra',
            'status' => 'agendado',
            'data_inicio' => now()->addDays(2),
            'hora_inicio' => '10:00'
        ]);

        $inscricao = InscricaoEvento::create([
            'evento_id' => $evento->id,
            'nome' => 'Inscrito 1',
            'cpf' => '11111111111',
            'status' => 'inscrito'
        ]);

        $response = $this->actingAs($admin)->post(route('admin.programas-agricultura.inscricoes.update-status', $inscricao->id), [
            'status' => 'confirmado'
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertEquals('confirmado', $inscricao->fresh()->status);
    }

    // =======================================
    // 12. Feature – Admin Permissões
    // =======================================

    #[Test]
    public function admin_can_access_permissoes_index()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin_perm@vertex.com', 'password' => bcrypt('password')]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.programas-agricultura.permissao.index'));
        $response->assertStatus(200);
        $response->assertSee('Matriz de Permissões');
    }

    // =======================================
    // 13. Feature – Co-Admin Routes
    // =======================================

    #[Test]
    public function co_admin_can_access_dashboard()
    {
        $coAdmin = User::create(['name' => 'Co-Admin', 'email' => 'coadmin@vertex.com', 'password' => bcrypt('password')]);
        $coAdmin->assignRole('co-admin');

        $response = $this->actingAs($coAdmin)->get(route('co-admin.dashboard'));
        $response->assertStatus(200);
    }

    #[Test]
    public function co_admin_can_access_programas_list()
    {
        $coAdmin = User::create(['name' => 'Co-Admin', 'email' => 'coadmin_prg@vertex.com', 'password' => bcrypt('password')]);
        $coAdmin->assignRole('co-admin');

        $response = $this->actingAs($coAdmin)->get(route('co-admin.programas.index'));
        $response->assertStatus(200);
        $response->assertSee('Meus Programas');
    }
}
