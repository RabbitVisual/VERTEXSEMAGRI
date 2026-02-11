<?php

namespace Modules\Estradas\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Estradas\App\Models\Trecho;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;
use Spatie\Permission\Models\Role; // Import Role
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;

class EstradasFullSuiteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Bypass Gate
        Gate::before(function () {
            return true;
        });

        $this->artisan('module:enable', ['module' => 'Estradas']);
    }

    private function createAdmin()
    {
        $admin = User::factory()->create();
        Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole('admin');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        return $admin;
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertGreaterThanOrEqual(78, count($tables));
    }

    #[Test]
    public function admin_can_create_trecho_with_generated_code()
    {
        $admin = $this->createAdmin();
        $localidade = Localidade::create(['nome' => 'Localidade ' . uniqid(), 'codigo' => 'LOC-' . uniqid(), 'ativo' => true]);

        $data = [
            'nome' => 'Estrada Principal',
            'localidade_id' => $localidade->id,
            'tipo' => 'principal',
            'extensao_km' => 10.5,
            'largura_metros' => 8.0,
            'tipo_pavimento' => 'asfalto',
            'condicao' => 'boa',
            'tem_ponte' => true,
            'numero_pontes' => 2,
            'observacoes' => 'Observação teste',
        ];

        $response = $this->actingAs($admin)->post(route('estradas.store'), $data);

        $response->assertRedirect(route('estradas.index'));
        $this->assertDatabaseHas('trechos', ['nome' => 'Estrada Principal']);

        $trecho = Trecho::where('nome', 'Estrada Principal')->first();
        $this->assertStringStartsWith('EST', $trecho->codigo);
        $this->assertNotEmpty($trecho->codigo);
    }

    #[Test]
    public function cannot_create_trecho_without_required_fields()
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)->post(route('estradas.store'), []);

        $response->assertSessionHasErrors(['nome', 'localidade_id', 'tipo', 'condicao']);
    }

    #[Test]
    public function admin_can_update_trecho()
    {
        $admin = $this->createAdmin();
        $localidade = Localidade::create(['nome' => 'Localidade ' . uniqid(), 'codigo' => 'LOC-' . uniqid(), 'ativo' => true]);
        $trecho = Trecho::create([
            'codigo' => 'EST-TEST',
            'nome' => 'Estrada Velha',
            'localidade_id' => $localidade->id,
            'tipo' => 'vicinal',
            'extensao_km' => 5.0,
            'condicao' => 'ruim',
        ]);

        $data = [
            'nome' => 'Estrada Nova',
            'localidade_id' => $localidade->id,
            'tipo' => 'vicinal',
            'extensao_km' => 5.0,
            'condicao' => 'regular',
        ];

        $response = $this->actingAs($admin)->put(route('estradas.update', $trecho->id), $data);

        $response->assertRedirect(route('estradas.index'));
        $this->assertDatabaseHas('trechos', ['nome' => 'Estrada Nova', 'condicao' => 'regular']);
    }

    #[Test]
    public function admin_can_delete_trecho()
    {
        $admin = $this->createAdmin();
        $localidade = Localidade::create(['nome' => 'Localidade ' . uniqid(), 'codigo' => 'LOC-' . uniqid(), 'ativo' => true]);
        $trecho = Trecho::create([
            'codigo' => 'EST-DEL',
            'nome' => 'Estrada Delete',
            'localidade_id' => $localidade->id,
            'tipo' => 'vicinal',
            'extensao_km' => 5.0,
            'condicao' => 'ruim',
        ]);

        $this->actingAs($admin)->delete(route('estradas.destroy', $trecho->id));

        $this->assertSoftDeleted('trechos', ['id' => $trecho->id]);
    }

    #[Test]
    public function export_routes_work()
    {
        $admin = $this->createAdmin();
        $localidade = Localidade::create(['nome' => 'Localidade ' . uniqid(), 'codigo' => 'LOC-' . uniqid(), 'ativo' => true]);
        Trecho::create([
            'codigo' => 'EST-EXP',
            'nome' => 'Estrada Export',
            'localidade_id' => $localidade->id,
            'tipo' => 'vicinal',
            'extensao_km' => 5.0,
            'condicao' => 'boa',
        ]);

        $responsePdf = $this->actingAs($admin)->get(route('estradas.index', ['format' => 'pdf']));
        $responsePdf->assertStatus(200);

        // Testing CSV as checking content type or successful response
        $responseCsv = $this->actingAs($admin)->get(route('estradas.index', ['format' => 'csv']));
        $responseCsv->assertStatus(200);
    }
}
