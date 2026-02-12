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
    public function database_has_79_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertEquals(79, count($tables));
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

        $this->assertEquals(2, Material::baixoEstoque()->count());
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

    #[Test]
    public function admin_can_manage_categories_and_subcategories()
    {
        $user = $this->createAdminUser();

        // 1. Create Category
        $response = $this->actingAs($user)->post(route('admin.materiais.categorias.store'), [
            'nome' => 'Nova Categoria',
            'icone' => 'box',
            'ordem' => 1,
            'ativo' => 1
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('categorias_materiais', ['nome' => 'Nova Categoria']);

        $categoria = CategoriaMaterial::where('nome', 'Nova Categoria')->first();

        // 2. Create Subcategory
        $response = $this->actingAs($user)->post(route('admin.materiais.categorias.subcategorias.store', $categoria->id), [
            'nome' => 'Nova Subcategoria',
            'slug' => 'nova-sub',
            'ordem' => 1,
            'ativo' => 1
        ]);
        $response->assertRedirect();
        $this->assertDatabaseHas('subcategorias_materiais', ['nome' => 'Nova Subcategoria', 'categoria_id' => $categoria->id]);
    }

    #[Test]
    public function admin_can_manage_custom_fields()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        // Create Custom Field (Campo)
        // Correct route name from web.php: admin.materiais.categorias.subcategorias.campos.store
        // Note: The route is nested under category AND subcategory in web.php
        $response = $this->actingAs($user)->post(route('admin.materiais.categorias.subcategorias.campos.store', ['categoria' => $cat->id, 'subcategoria' => $sub->id]), [
            'nome' => 'Voltagem',
            'tipo' => 'text',
            'obrigatorio' => 1,
            'ordem' => 1,
            'ativo' => 1
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('campos_categoria_material', [
            'subcategoria_id' => $sub->id,
            'nome' => 'Voltagem'
        ]);
    }

    #[Test]
    public function admin_can_create_material_request_and_generate_pdf()
    {
        $user = $this->createAdminUser();
        list($cat, $sub) = $this->createCategoriaAndSubcategoria();

        $material = Material::create([
            'nome' => 'Material Solicitado',
            'subcategoria_id' => $sub->id,
            'quantidade_estoque' => 100,
            'unidade_medida' => 'un'
        ]);

        // Test Page Load
        $response = $this->actingAs($user)->get(route('admin.materiais.solicitar.create'));
        $response->assertOk();

        // Test PDF Generation (Store)
        // Based on pdf.blade.php content, it expects certain fields
        $data = [
            'cidade' => 'Coração de Maria',
            'data' => now()->format('Y-m-d'),
            'secretario_nome' => 'Secretario Teste',
            'secretario_cargo' => 'Secretário de Agricultura',
            'servidor_nome' => 'Servidor Teste',
            'servidor_cargo' => 'Cargo Teste',
            'observacoes' => 'Teste Integração',
            'materiais' => [
                [
                    'material_id' => $material->id,
                    'quantidade' => 10,
                    'justificativa' => 'Uso imediato'
                ]
            ],
            'materiais_customizados' => [
                [
                    'nome' => 'Item Avulso',
                    'especificacao' => 'Detalhe X',
                    'quantidade' => 2,
                    'unidade_medida' => 'CX',
                    'justificativa' => 'Necessidade especial'
                ]
            ]
        ];

        // The route for generating PDF is admin.materiais.solicitar.gerar-pdf
        $response = $this->actingAs($user)->post(route('admin.materiais.solicitar.gerar-pdf'), $data);

        // Expectation: It streams a PDF download or returns binary
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');

        // Verify database existence of request (if the controller saves it)
        // Controller likely saves to 'solicitacoes_materiais'
        $this->assertDatabaseHas('solicitacoes_materiais', [
            'servidor_nome' => 'Servidor Teste',
            'user_id' => $user->id
        ]);
    }

    #[Test]
    public function admin_can_view_field_requests()
    {
        $user = $this->createAdminUser();

        // Just check if the page loads safely
        $response = $this->actingAs($user)->get(route('admin.materiais.solicitacoes-campo.index'));
        $response->assertOk();
        $response->assertViewIs('materiais::admin.solicitacoes-campo.index');
    }
}
