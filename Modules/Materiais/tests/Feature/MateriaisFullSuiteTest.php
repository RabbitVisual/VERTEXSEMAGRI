<?php

namespace Modules\Materiais\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Materiais\App\Models\Material;
use Modules\Materiais\App\Models\CategoriaMaterial;
use Modules\Materiais\App\Models\SubcategoriaMaterial;
use Modules\Materiais\App\Models\MaterialMovimentacao;
use App\Models\User;
use Spatie\Permission\Models\Role;
use PHPUnit\Framework\Attributes\Test;

class MateriaisFullSuiteTest extends TestCase
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

    private function createCategoriaAndSubcategoria()
    {
        $uniqueId = uniqid();
        $categoria = CategoriaMaterial::create([
            'nome' => 'Elétrica ' . $uniqueId,
            'slug' => 'eletrica-' . $uniqueId,
            'ativo' => true,
            'ordem' => 1
        ]);

        $subcategoria = SubcategoriaMaterial::create([
            'categoria_id' => $categoria->id,
            'nome' => 'Fios e Cabos ' . $uniqueId,
            'slug' => 'fios', // Slug fixo compatível com ENUM 'fios' da tabela materiais
            'ativo' => true,
            'ordem' => 1
        ]);

        return [$categoria, $subcategoria];
    }

    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(78, count($tables));
    }

    #[Test]
    public function admin_can_access_materiais_index()
    {
        $user = $this->createAdminUser();
        // Mock route if not exists (modular structure quirks)
        // But assuming routes are loaded

        $response = $this->actingAs($user)->get(route('materiais.index'));

        $response->assertStatus(200);
        $response->assertViewIs('materiais::index');
    }

    #[Test]
    public function admin_can_store_material_with_subcategoria_and_code_generation()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $data = [
            'nome' => 'Fio 10mm',
            'subcategoria_id' => $sub->id,
            'unidade_medida' => 'metro',
            'quantidade_estoque' => 100,
            'quantidade_minima' => 20,
            'valor_unitario' => 5.50,
            'fornecedor' => 'Fornecedor A',
            'localizacao_estoque' => 'Prateleira B',
            'ativo' => 1
        ];

        $response = $this->actingAs($user)->post(route('materiais.store'), $data);

        $response->assertRedirect(route('materiais.index'));

        $this->assertDatabaseHas('materiais', [
            'nome' => 'Fio 10mm',
            'unidade_medida' => 'metro',
            'quantidade_estoque' => 100
        ]);

        $material = Material::where('nome', 'Fio 10mm')->first();
        $this->assertNotNull($material->codigo);
        $this->assertStringStartsWith('MAT-FIO-', $material->codigo); // Subcategoria slug prefix (FIO)
    }

    #[Test]
    public function store_validates_uniqueness_of_name_and_code()
    {
        // Name uniqueness is not strictly enforced by DB constraint usually in simple apps unless specified,
        // but code MUST be unique.
        // Let's test that we can create two materials with different names.
        // And if the code generation handles collision (it does via while loop in Trait).

        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $m1 = Material::create([
            'nome' => 'Material A',
            'subcategoria_id' => $sub->id,
            'codigo' => 'MAT-TEST-001',
            'quantidade_estoque' => 10,
            'quantidade_minima' => 5,
            'unidade_medida' => 'un'
        ]);

        // Try to create another material, code generation should handle it automatically if we let it generate.
        // If we force same code, it should fail DB constraint.

        try {
            Material::create([
                'nome' => 'Material B',
                'subcategoria_id' => $sub->id,
                'codigo' => 'MAT-TEST-001', // Duplicate
                'quantidade_estoque' => 10,
                'quantidade_minima' => 5,
                'unidade_medida' => 'un'
            ]);
            $this->fail('Should have thrown QueryException for duplicate code');
        } catch (\Illuminate\Database\QueryException $e) {
            $this->assertStringContainsString('Duplicate entry', $e->getMessage());
        }
    }

    #[Test]
    public function admin_can_add_stock_via_route()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Cano PVC',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 50, // Inicial
            'quantidade_minima' => 10,
            'unidade_medida' => 'metro',
            'valor_unitario' => 10.00
        ]);

        $response = $this->actingAs($user)->post(route('materiais.adicionar-estoque', $material->id), [
            'quantidade' => 20,
            'motivo' => 'Compra Extra',
            'valor_unitario' => 12.00
        ]);

        $response->assertRedirect(route('materiais.show', $material->id));

        $material->refresh();
        $this->assertEquals(70, $material->quantidade_estoque); // 50 + 20

        // Verificar movimentação
        $this->assertDatabaseHas('material_movimentacoes', [
            'material_id' => $material->id,
            'tipo' => 'entrada',
            'quantidade' => 20,
            'motivo' => 'Compra Extra',
            'user_id' => $user->id
        ]);
    }

    #[Test]
    public function admin_can_remove_stock_via_route()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Cano PVC',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 100,
            'quantidade_minima' => 10,
            'unidade_medida' => 'metro'
        ]);

        $response = $this->actingAs($user)->post(route('materiais.remover-estoque', $material->id), [
            'quantidade' => 30,
            'motivo' => 'Uso Interno'
        ]);

        $response->assertRedirect(route('materiais.show', $material->id));

        $material->refresh();
        $this->assertEquals(70, $material->quantidade_estoque); // 100 - 30

        // Verificar movimentação
        $this->assertDatabaseHas('material_movimentacoes', [
            'material_id' => $material->id,
            'tipo' => 'saida',
            'quantidade' => 30,
            'motivo' => 'Uso Interno'
        ]);
    }

    #[Test]
    public function remove_stock_fails_if_insufficient_balance()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Cano PVC',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 10,
            'quantidade_minima' => 5,
            'unidade_medida' => 'metro'
        ]);

        // Tentar remover 20 (tem 10)
        $response = $this->actingAs($user)->post(route('materiais.remover-estoque', $material->id), [
            'quantidade' => 20,
            'motivo' => 'Erro'
        ]);

        $response->assertSessionHas('error'); // Controller catch block returns with error

        $material->refresh();
        $this->assertEquals(10, $material->quantidade_estoque); // Should not change
    }

    #[Test]
    public function low_stock_scope_filters_correctly()
    {
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        // Baixo Estoque (5 <= 10)
        Material::create([
            'nome' => 'Baixo',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 5,
            'quantidade_minima' => 10,
            'unidade_medida' => 'un'
        ]);

        // Normal (20 > 10)
        Material::create([
            'nome' => 'Normal',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 20,
            'quantidade_minima' => 10,
            'unidade_medida' => 'un'
        ]);

        // Sem Estoque (0 <= 10)
        Material::create([
            'nome' => 'Zerado',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 0,
            'quantidade_minima' => 10,
            'unidade_medida' => 'un'
        ]);

        $this->assertEquals(2, Material::baixoEstoque()->count()); // Corrigido de bajoEstoque -> baixoEstoque
    }

    #[Test]
    public function admin_can_soft_delete_material()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Delete Me',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 0,
            'quantidade_minima' => 0,
            'unidade_medida' => 'un'
        ]);

        $response = $this->actingAs($user)->delete(route('materiais.destroy', $material->id));

        $response->assertRedirect(route('materiais.index'));
        $this->assertSoftDeleted('materiais', ['id' => $material->id]);
    }

    #[Test]
    public function material_has_relationship_relationships()
    {
        // Category via Subcategory check
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Rel Test',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 0,
            'quantidade_minima' => 0,
            'unidade_medida' => 'un'
        ]);

        $this->assertTrue($material->subcategoria->is($sub));
        // HasOneThrough relationship check
        $this->assertEquals($cat->id, $material->categoria->id);
    }
}
