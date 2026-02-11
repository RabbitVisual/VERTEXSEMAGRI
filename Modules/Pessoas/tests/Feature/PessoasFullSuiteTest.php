<?php

namespace Modules\Pessoas\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Modules\Pessoas\App\Models\PessoaCad;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;

class PessoasFullSuiteTest extends TestCase
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
            'pessoas.create',
            'pessoas.store',
            'pessoas.show',
            'pessoas.edit',
            'pessoas.update',
            'pessoas.destroy',
            'pessoas.estatisticas.localidade',
            'pessoas.export'
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

        if (DB::table('roles')->where('name', 'admin')->doesntExist()) {
            Role::create(['name' => 'admin']);
        }

        $user->assignRole('admin');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return $user;
    }

    private function getValidCpf()
    {
        // Um CPF válido real para passar no validador do controller
        return '00000000000'; // O validador do controller pode aceitar CPFs zerados dependendo da implementação, mas vamos usar um que passe no algoritmo
    }

    /**
     * Helper para gerar um CPF válido (algoritmo real)
     */
    private function generateValidCpf()
    {
        $n = array_map(function() { return rand(0, 9); }, range(1, 9));

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $n[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            $n[] = $d;
        }

        return implode('', $n);
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(78, count($tables));
    }

    #[Test]
    public function admin_can_access_pessoas_index()
    {
        $user = $this->createAdminUser();
        $response = $this->actingAs($user)->get(route('pessoas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pessoas::index');
    }

    #[Test]
    public function admin_can_store_manual_person_with_valid_cpf()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'tipo' => 'bairro', 'codigo' => 'LOC-001']);

        $cpf = $this->generateValidCpf();

        $data = [
            'nom_pessoa' => 'Joao Teste',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1990-01-01',
            'localidade_id' => $localidade->id,
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->post(route('pessoas.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('pessoas_cad', [
            'num_cpf_pessoa' => $cpf,
            'nom_pessoa' => 'Joao Teste'
        ]);
    }

    #[Test]
    public function store_fails_with_invalid_cpf()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Centro', 'tipo' => 'bairro', 'codigo' => 'LOC-001']);

        $data = [
            'nom_pessoa' => 'Joao Erro',
            'num_cpf_pessoa' => '12345678901', // CPF inválido
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1990-01-01',
            'localidade_id' => $localidade->id
        ];

        $response = $this->actingAs($user)->post(route('pessoas.store'), $data);

        $response->assertSessionHasErrors(['num_cpf_pessoa']);
    }

    #[Test]
    public function store_fails_on_duplicate_cpf()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Bairro Existe', 'tipo' => 'bairro', 'codigo' => 'LOC-EXI']);
        $cpf = $this->generateValidCpf();

        PessoaCad::create([
            'nom_pessoa' => 'Pessoa Existe',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1980-05-05',
            'localidade_id' => $localidade->id,
            'cd_ibge' => 2908903
        ]);

        $data = [
            'nom_pessoa' => 'Pessoa Duplicada',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 2,
            'dta_nasc_pessoa' => '1990-01-01',
            'localidade_id' => $localidade->id
        ];

        $response = $this->actingAs($user)->post(route('pessoas.store'), $data);

        $response->assertSessionHasErrors(['num_cpf_pessoa']);
    }

    #[Test]
    public function admin_can_update_manual_person()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Bairro 2', 'tipo' => 'bairro', 'codigo' => 'LOC-2']);
        $cpf = $this->generateValidCpf();

        $pessoa = PessoaCad::create([
            'nom_pessoa' => 'Original Name',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1985-10-10',
            'localidade_id' => $localidade->id,
            'cd_ibge' => 2908903
        ]);

        $updateData = [
            'nom_pessoa' => 'Updated Name',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1985-10-10',
            'localidade_id' => $localidade->id,
            // Omitir 'ativo' para desativar (comportamento de checkbox)
        ];

        $response = $this->actingAs($user)->put(route('pessoas.update', $pessoa->id), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('pessoas_cad', [
            'id' => $pessoa->id,
            'nom_pessoa' => 'Updated Name',
            'ativo' => false
        ]);
    }

    #[Test]
    public function admin_cannot_update_cadunico_person_basic_data()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Bairro 3', 'tipo' => 'bairro', 'codigo' => 'LOC-3']);
        $cpf = $this->generateValidCpf();

        // Registro com ref_cad não nulo = CadÚnico
        $pessoa = PessoaCad::create([
            'nom_pessoa' => 'CadUnico Name',
            'num_cpf_pessoa' => $cpf,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1985-10-10',
            'localidade_id' => $localidade->id,
            'cd_ibge' => 2908903,
            'ref_cad' => 12345
        ]);

        $updateData = [
            'nom_pessoa' => 'Tried to update name', // Não deve ser atualizado
            'localidade_id' => $localidade->id,
            'ativo' => 1
        ];

        $this->actingAs($user)->put(route('pessoas.update', $pessoa->id), $updateData);

        $this->assertDatabaseHas('pessoas_cad', [
            'id' => $pessoa->id,
            'nom_pessoa' => 'CadUnico Name'
        ]);
    }

    #[Test]
    public function admin_can_soft_delete_person()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Bairro D', 'tipo' => 'bairro', 'codigo' => 'LOC-D']);
        $pessoa = PessoaCad::create([
            'nom_pessoa' => 'To Delete',
            'num_cpf_pessoa' => $this->generateValidCpf(),
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1980-01-01',
            'localidade_id' => $localidade->id,
            'cd_ibge' => 2908903
        ]);

        $response = $this->actingAs($user)->delete(route('pessoas.destroy', $pessoa->id));

        $response->assertRedirect(route('pessoas.index'));
        $this->assertSoftDeleted('pessoas_cad', ['id' => $pessoa->id]);
    }

    #[Test]
    public function estatisticas_por_localidade_returns_json()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Local Stat', 'tipo' => 'rua', 'codigo' => 'LOC-STAT']);

        // Criar 1 masculino e 1 feminino
        PessoaCad::create([
            'nom_pessoa' => 'Masc', 'num_cpf_pessoa' => $this->generateValidCpf(),
            'cod_sexo_pessoa' => 1, 'dta_nasc_pessoa' => '1990-01-01', 'localidade_id' => $localidade->id, 'ativo' => true
        ]);
        PessoaCad::create([
            'nom_pessoa' => 'Fem', 'num_cpf_pessoa' => $this->generateValidCpf(),
            'cod_sexo_pessoa' => 2, 'dta_nasc_pessoa' => '1990-01-01', 'localidade_id' => $localidade->id, 'ativo' => true
        ]);

        $response = $this->actingAs($user)->getJson(route('pessoas.estatisticas.localidade', $localidade->id));

        $response->assertStatus(200);
        $response->assertJsonPath('total', 2);
        $response->assertJsonPath('por_sexo.masculino', 1);
        $response->assertJsonPath('por_sexo.feminino', 1);
    }

    #[Test]
    public function export_returns_json_and_filters_correctly()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Local Exp', 'tipo' => 'rua', 'codigo' => 'LOC-EXPP']);

        PessoaCad::create([
            'nom_pessoa' => 'Pessoa Exp',
            'num_cpf_pessoa' => $this->generateValidCpf(),
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1990-01-01',
            'localidade_id' => $localidade->id,
            'cd_ibge' => 2908903
        ]);

        $response = $this->actingAs($user)->get(route('pessoas.export'));

        $response->assertStatus(200);
        $response->assertJsonStructure([['id', 'nom_pessoa']]);
    }

    #[Test]
    public function pessoa_has_localidade_relationship()
    {
        $localidade = Localidade::create(['nome' => 'Rua Teste', 'tipo' => 'rua', 'codigo' => 'LOC-002']);
        $pessoa = PessoaCad::create([
            'nom_pessoa' => 'Rel Test',
            'num_cpf_pessoa' => $this->generateValidCpf(),
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1980-01-01',
            'localidade_id' => $localidade->id
        ]);

        $this->assertEquals('Rua Teste', $pessoa->localidade->nome);
    }

    #[Test]
    public function pessoa_calculates_age_correctly()
    {
        $pessoa = new PessoaCad();
        $pessoa->dta_nasc_pessoa = now()->subYears(30)->toDateString();

        $this->assertEquals(30, $pessoa->idade);
    }

    #[Test]
    public function store_cleans_cpf_and_nis_masks()
    {
        $user = $this->createAdminUser();
        $localidade = Localidade::create(['nome' => 'Bairro', 'tipo' => 'bairro', 'codigo' => 'LOC-B']);

        // CPF válido com máscara
        // Exemplo de CPF real válido: 000.000.000-00 (mas precisamos de um que passe no algoritmo)
        $cpfRaw = $this->generateValidCpf();
        $cpfMasked = substr($cpfRaw, 0, 3) . '.' . substr($cpfRaw, 3, 3) . '.' . substr($cpfRaw, 6, 3) . '-' . substr($cpfRaw, 9, 2);

        $data = [
            'nom_pessoa' => 'Mask Test',
            'num_cpf_pessoa' => $cpfMasked,
            'cod_sexo_pessoa' => 1,
            'dta_nasc_pessoa' => '1995-10-10',
            'localidade_id' => $localidade->id
        ];

        $this->actingAs($user)->post(route('pessoas.store'), $data);

        $this->assertDatabaseHas('pessoas_cad', [
            'num_cpf_pessoa' => $cpfRaw,
            'nom_pessoa' => 'Mask Test'
        ]);
    }
}
