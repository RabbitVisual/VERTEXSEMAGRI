<?php

namespace Modules\Ordens\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use Modules\Equipes\App\Models\Equipe;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\CategoriaMaterial;
use Modules\Materiais\App\Models\SubcategoriaMaterial;
use Modules\Locais\App\Models\Localidade; // Adjust namespace if needed, usually Localidades
use Modules\Localidades\App\Models\Localidade as LocalidadeModel; // Using correct namespace if exists
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class OrdensFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

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

    private function createDependencies()
    {
        // Equipe
        $equipe = Equipe::create([
            'nome' => 'Equipe Alpha',
            'codigo' => 'EQP-001',
            'ativo' => true,
            'tipo' => 'mista' // Enum allowed value
        ]);

        // Material with Category/Subcategory
        $cat = CategoriaMaterial::create(['nome' => 'Geral', 'slug' => 'geral-' . uniqid(), 'ativo' => true, 'ordem' => 1]);
        $sub = SubcategoriaMaterial::create(['categoria_id' => $cat->id, 'nome' => 'SubGeral ' . uniqid(), 'slug' => 'sub-geral-' . uniqid(), 'ativo' => true, 'ordem' => 1]);

        $material = Material::create([
            'nome' => 'Cabo 10mm',
            'categoria' => 'outros', // Required ENUM field
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 100,
            'quantidade_minima' => 10,
            'unidade_medida' => 'metro',
            'valor_unitario' => 5.00,
            'ativo' => true
        ]);

        // Localidade for Demanda
        $localidade = null;
        if (class_exists(\Modules\Localidades\App\Models\Localidade::class)) {
            $localidade = \Modules\Localidades\App\Models\Localidade::create([
                'nome' => 'Local B',
                'codigo' => 'LOC-' . uniqid(),
                'ativo' => true
            ]);
        }

        // Demanda
        $demanda = Demanda::create([
            'solicitante_nome' => 'João',
            'tipo' => 'luz',
            'prioridade' => 'media',
            'motivo' => 'Manutenção Geral', // Required field
            'descricao' => 'Sem luz no poste',
            'status' => 'aberta',
            'localidade_id' => $localidade ? $localidade->id : null,
            'data_abertura' => now(),
            'codigo' => 'DEM-' . uniqid()
        ]);

        return compact('equipe', 'material', 'demanda');
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(78, count($tables));
    }

    #[Test]
    public function admin_can_create_ordem_from_demanda_and_reserves_stock()
    {
        $user = $this->createAdminUser();
        $deps = $this->createDependencies(); // equipe, material, demanda

        $data = [
            'demanda_id' => $deps['demanda']->id,
            'equipe_id' => $deps['equipe']->id,
            'tipo_servico' => 'Manutenção Elétrica',
            'descricao' => 'Troca de fiação',
            'prioridade' => 'alta',
            'materiais' => [
                [
                    'material_id' => $deps['material']->id,
                    'quantidade' => 10
                ]
            ]
        ];

        $response = $this->actingAs($user)->post(route('ordens.store'), $data);

        $response->assertStatus(302);

        // Assert Ordem Created
        $this->assertDatabaseHas('ordens_servico', [
            'demanda_id' => $deps['demanda']->id,
            'status' => 'pendente'
        ]);

        $ordem = OrdemServico::where('demanda_id', $deps['demanda']->id)->first();

        // Assert Demanda Status Updated
        $this->assertDatabaseHas('demandas', [
            'id' => $deps['demanda']->id,
            'status' => 'em_andamento'
        ]);

        // Assert Material Reserved (Stock should NOT decrease yet, but reservation exists)
        // Wait, checking Controller logic:
        // Controller calls $material->reservarEstoque() which uses MOVIMENTACAO with status 'reservado'
        // And decrements 'quantidade_estoque' (available stock).
        // Let's verify Controller logic again in planning...
        // Yes, reservarEstoque DOES decrement quantidade_estoque immediately to prevent overselling.

        $deps['material']->refresh();
        $this->assertEquals(90, $deps['material']->quantidade_estoque); // 100 - 10

        $this->assertDatabaseHas('material_movimentacoes', [
            'material_id' => $deps['material']->id,
            'ordem_servico_id' => $ordem->id,
            'tipo' => 'saida',
            'status' => 'reservado',
            'quantidade' => 10
        ]);

        $this->assertDatabaseHas('ordem_servico_materiais', [
            'ordem_servico_id' => $ordem->id,
            'material_id' => $deps['material']->id,
            'quantidade' => 10,
            // 'status_reserva' => 'reservado' // Assuming default or handled? migration indicates column exists
        ]);
    }

    #[Test]
    public function admin_can_start_ordem()
    {
        $user = $this->createAdminUser();
        $deps = $this->createDependencies();

        $ordem = OrdemServico::create([
            'demanda_id' => $deps['demanda']->id,
            'equipe_id' => $deps['equipe']->id,
            'tipo_servico' => 'Teste',
            'descricao' => 'Teste Start',
            'prioridade' => 'media',
            'status' => 'pendente',
            'numero' => 'OS-START-001'
        ]);

        $response = $this->actingAs($user)->post(route('ordens.iniciar', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));

        $this->assertDatabaseHas('ordens_servico', [
            'id' => $ordem->id,
            'status' => 'em_execucao'
        ]);

        $ordem->refresh();
        $this->assertNotNull($ordem->data_inicio);
    }

    #[Test]
    public function admin_can_conclude_ordem_and_finalize_stock_and_demanda()
    {
        $user = $this->createAdminUser();
        $deps = $this->createDependencies();

        // Create Ordem in execution with materials reserved
        $ordem = OrdemServico::create([
            'demanda_id' => $deps['demanda']->id,
            'equipe_id' => $deps['equipe']->id,
            'tipo_servico' => 'Teste Conclusao',
            'descricao' => 'Teste End',
            'prioridade' => 'media',
            'status' => 'em_execucao',
            'data_inicio' => now()->subHour(),
            'numero' => 'OS-END-001'
        ]);

        // Reserve material manually via model helper or create rows
        $deps['material']->reservarEstoque(5, $ordem->id, 'Reserva Teste');

        // Link in pivot
        DB::table('ordem_servico_materiais')->insert([
            'ordem_servico_id' => $ordem->id,
            'material_id' => $deps['material']->id,
            'quantidade' => 5,
            'valor_unitario' => 5.00,
            'status_reserva' => 'reservado',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update to conclude via Controller logic (simulating form submission)
        // Note: controller uses 'update' method for conclusion when status is passed as 'concluida'
        // It's NOT a separate 'concluir' route POST action?
        // Wait, route list showed: Route::post('/ordens/{id}/concluir', ...)->name('ordens.concluir');
        // BUT the plan mentioned 'concluir' status workflow using 'update' OR 'concluir' method.
        // Let's use the named route 'ordens.concluir' logic as it seems to be the specific action per routes file.
        // Checking Controller::concluir method... yes it exists.

        $response = $this->actingAs($user)->post(route('ordens.concluir', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));

        // Check Ordem Concluded
        $this->assertDatabaseHas('ordens_servico', [
            'id' => $ordem->id,
            'status' => 'concluida',
        ]);
        $ordem->refresh();
        $this->assertNotNull($ordem->data_conclusao);

        // Check Demanda Concluded
        $this->assertDatabaseHas('demandas', [
            'id' => $deps['demanda']->id,
            'status' => 'concluida'
        ]);

        // Check Stock Confirmation
        // Reservation status in pivot should be 'confirmado'
        $this->assertDatabaseHas('ordem_servico_materiais', [
            'ordem_servico_id' => $ordem->id,
            'material_id' => $deps['material']->id,
            'status_reserva' => 'confirmado'
        ]);

        // Check Movimentacao Status
        $this->assertDatabaseHas('material_movimentacoes', [
            'ordem_servico_id' => $ordem->id,
            'material_id' => $deps['material']->id,
            'tipo' => 'saida',
            'status' => 'confirmado'
        ]);
    }

    #[Test]
    public function pdf_generation_works()
    {
        $user = $this->createAdminUser();
        // Create a concluded order to appear in report
         $deps = $this->createDependencies();
         $ordem = OrdemServico::create([
            'demanda_id' => $deps['demanda']->id,
            'equipe_id' => $deps['equipe']->id,
            'tipo_servico' => 'PDF Test',
            'descricao' => 'PDF',
            'prioridade' => 'baixa',
            'status' => 'concluida',
            'data_inicio' => now()->startOfDay(),
            'data_conclusao' => now(), // Today
            'numero' => 'OS-PDF-001'
        ]);

        $response = $this->actingAs($user)->get(route('ordens.relatorio.demandas-dia.pdf', ['data' => now()->toDateString()]));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    #[Test]
    public function cannot_create_ordem_without_team_or_demanda_enabled()
    {
        // Simple validation check
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->post(route('ordens.store'), [
            'tipo_servico' => 'Fail',
            'prioridade' => 'baixa',
            // Missing required fields
        ]);

        $response->assertSessionHasErrors(['equipe_id', 'descricao']);
    }
}
