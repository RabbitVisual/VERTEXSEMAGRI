<?php

namespace Modules\Localidades\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;

class LocalidadesFullSuiteTest extends TestCase
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
            'localidades.create',
            'localidades.store',
            'localidades.show',
            'localidades.edit',
            'localidades.update',
            'localidades.destroy',
            'localidades.dados'
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
    }

    private function createAdminUser()
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin_' . uniqid() . '@vertex.com',
            'password' => bcrypt('password'),
        ]);

        // Criar role admin se não existir
        if (DB::table('roles')->where('name', 'admin')->doesntExist()) {
            Role::create(['name' => 'admin']);
        }

        $user->assignRole('admin');

        // Limpar cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return $user;
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $tableCount = count($tables);

        $this->assertEquals(78, $tableCount, "O banco de dados de teste deve ter exatamente 78 tabelas (paridade com produção). Encontradas: $tableCount");
    }

    #[Test]
    public function admin_can_access_localidades_index()
    {
        $user = $this->createAdminUser();
        $response = $this->actingAs($user)->get(route('localidades.index'));

        $response->assertStatus(200);
        $response->assertViewIs('localidades::index');
    }

    #[Test]
    public function admin_can_store_new_localidade_with_auto_code()
    {
        $user = $this->createAdminUser();

        $data = [
            'nome' => 'Bairro Centro',
            'tipo' => 'bairro',
            'cep' => '88000-000',
            'cidade' => 'Sombrio',
            'estado' => 'SC',
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->post(route('localidades.store'), $data);

        $response->assertRedirect(route('localidades.index'));
        $this->assertDatabaseHas('localidades', [
            'nome' => 'Bairro Centro',
            'tipo' => 'bairro'
        ]);

        $localidade = Localidade::where('nome', 'Bairro Centro')->first();
        $this->assertNotNull($localidade->codigo);
        $this->assertStringStartsWith('LOC-BAI-', $localidade->codigo);
    }

    #[Test]
    public function store_fails_without_required_fields()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->post(route('localidades.store'), []);

        $response->assertSessionHasErrors(['nome', 'tipo']);
    }

    #[Test]
    public function admin_can_update_localidade()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Antigo Nome',
            'tipo' => 'rua',
            'codigo' => 'LOC-OLD-001',
            'ativo' => true
        ]);

        $updateData = [
            'nome' => 'Novo Nome',
            'tipo' => 'avenida',
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->put(route('localidades.update', $localidade->id), $updateData);

        $response->assertRedirect(route('localidades.index'));
        $this->assertDatabaseHas('localidades', [
            'id' => $localidade->id,
            'nome' => 'Novo Nome',
            'tipo' => 'avenida'
        ]);
    }

    #[Test]
    public function admin_can_soft_delete_localidade()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Localidade para Deletar',
            'tipo' => 'outro',
            'codigo' => 'LOC-DEL-001',
            'ativo' => true
        ]);

        $response = $this->actingAs($user)->delete(route('localidades.destroy', $localidade->id));

        $response->assertRedirect(route('localidades.index'));
        $this->assertSoftDeleted('localidades', ['id' => $localidade->id]);
    }

    #[Test]
    public function get_dados_api_returns_json_structure()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create([
            'nome' => 'Localidade API',
            'tipo' => 'distrito',
            'codigo' => 'LOC-API-001',
            'latitude' => -29.1234,
            'longitude' => -49.5678,
            'ativo' => true
        ]);

        $response = $this->actingAs($user)->getJson(route('localidades.dados', $localidade->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id', 'nome', 'latitude', 'longitude', 'endereco', 'cep'
        ]);
        $response->assertJsonPath('nome', 'Localidade API');
    }

    #[Test]
    public function localidade_has_demandas_relationship()
    {
        $localidade = Localidade::create([
            'nome' => 'Local Relacionamento',
            'tipo' => 'rua',
            'codigo' => 'LOC-REL-001'
        ]);

        // Criar uma demanda vinculada (não precisa de todos os campos se testarmos apenas a query)
        DB::table('demandas')->insert([
            'localidade_id' => $localidade->id,
            'codigo' => 'DEM-001',
            'tipo' => 'agua',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'motivo' => 'Teste',
            'descricao' => 'Teste de relacionamento de localidade',
            'prioridade' => 'media',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $localidade->demandas);
        $this->assertCount(1, $localidade->demandas);
    }

    #[Test]
    public function admin_can_export_localidades_csv()
    {
        $user = $this->createAdminUser();

        Localidade::create([
            'nome' => 'Local Export',
            'tipo' => 'estrada',
            'codigo' => 'LOC-EXP-001'
        ]);

        $response = $this->actingAs($user)->get(route('localidades.index', ['format' => 'csv']));

        $response->assertStatus(200);

        // Verificar se é CSV (pode ser streamed ou normal dependendo do trait)
        $content = $response->getContent();
        if (empty($content) && method_exists($response, 'streamedContent')) {
            $content = $response->streamedContent();
        }

        $this->assertStringContainsString('Local Export', $content);
    }

    #[Test]
    public function localidade_generates_unique_codes()
    {
        $code1 = Localidade::generateCode('LOC', 'rua');
        Localidade::create([
            'nome' => 'Rua 1',
            'tipo' => 'rua',
            'codigo' => $code1
        ]);

        $code2 = Localidade::generateCode('LOC', 'rua');
        $this->assertNotEquals($code1, $code2);
        $this->assertStringContainsString('-0002', $code2);

        $codeOtherType = Localidade::generateCode('LOC', 'bairro');
        $this->assertStringContainsString('-BAI-', $codeOtherType);
    }

    #[Test]
    public function localidade_has_pessoas_relationship()
    {
        $localidade = Localidade::create([
            'nome' => 'Local Pessoas',
            'tipo' => 'rua',
            'codigo' => 'LOC-PES-001'
        ]);

        // Mock de uma pessoa vinculada à localidade
        DB::table('pessoas_cad')->insert([
            'localidade_id' => $localidade->id,
            'nom_pessoa' => 'Joao da Silva',
            'num_cpf_pessoa' => '12345678901',
            'ativo' => true
        ]);

        $this->assertCount(1, $localidade->pessoas);
        $this->assertEquals('Joao da Silva', $localidade->pessoas->first()->nom_pessoa);
    }
}
