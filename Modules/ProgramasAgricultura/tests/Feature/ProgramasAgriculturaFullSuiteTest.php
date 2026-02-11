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

        Route::get('/admin/dashboard', fn() => 'dashboard')->name('admin.dashboard');
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

    #[Test]
    public function beneficiario_scopes_filter_correctly()
    {
        $programa = Programa::create([
            'codigo' => Programa::generateCode('PRG', 'pronaf'),
            'nome' => 'Scopes Test',
            'tipo' => 'pronaf',
            'status' => 'ativo',
            'publico' => true
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Ativo 1',
            'cpf' => '11111111111',
            'status' => 'inscrito',
            'data_inscricao' => now()
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Ativo 2',
            'cpf' => '22222222222',
            'status' => 'beneficiado',
            'data_inscricao' => now()
        ]);

        Beneficiario::create([
            'programa_id' => $programa->id,
            'nome' => 'Inativo',
            'cpf' => '33333333333',
            'status' => 'cancelado',
            'data_inscricao' => now()
        ]);

        $this->assertEquals(2, Beneficiario::ativos()->count());
        $this->assertEquals(3, Beneficiario::porPrograma($programa->id)->count());
    }
}
