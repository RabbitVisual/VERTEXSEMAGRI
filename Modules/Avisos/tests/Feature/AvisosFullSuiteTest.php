<?php

namespace Modules\Avisos\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use Modules\Avisos\App\Models\Aviso;

class AvisosFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Configuração básica do ambiente
        \Illuminate\Support\Facades\Route::get('/admin/dashboard', function() { return 'dashboard'; })->name('admin.dashboard');
    }


    #[Test]
    public function database_has_78_tables_as_production()
    {
        $tables = DB::select('SHOW TABLES');
        $this->assertCount(78, $tables, "O banco de dados de teste deve conter exatamente 78 tabelas para paridade com produção.");
    }

    #[Test]
    public function admin_can_access_avisos_index()
    {
        $role = DB::table('roles')->insertGetId(['name' => 'admin', 'guard_name' => 'web']);
        $user = User::create(['name' => 'Admin', 'email' => 'admin@avisos.com', 'password' => 'secret']);
        DB::table('model_has_roles')->insert([
            'role_id' => $role,
            'model_type' => User::class,
            'model_id' => $user->id
        ]);

        Aviso::create([
            'titulo' => 'Aviso de Teste',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('admin.avisos.index'));

        $response->assertStatus(200);
        $response->assertSee('Aviso de Teste');
    }

    #[Test]
    public function admin_can_store_new_aviso()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@store.com', 'password' => 'secret']);

        $data = [
            'titulo' => 'Novo Aviso Importante',
            'descricao' => 'Descrição do aviso',
            'tipo' => 'danger',
            'posicao' => 'flutuante',
            'estilo' => 'modal',
            'ativo' => 1,
            'dismissivel' => 1
        ];

        $response = $this->actingAs($user)->post(route('admin.avisos.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('avisos', [
            'titulo' => 'Novo Aviso Importante',
            'tipo' => 'danger'
        ]);
    }

    #[Test]
    public function admin_can_update_aviso()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@upd.com', 'password' => 'secret']);
        $aviso = Aviso::create([
            'titulo' => 'Aviso Original',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'user_id' => $user->id
        ]);

        $data = [
            'titulo' => 'Aviso Atualizado',
            'tipo' => 'success',
            'posicao' => ' rodape', // corrigindo espaço se necessário ou mantendo padrão
            'posicao' => 'rodape',
            'estilo' => 'toast',
            'ativo' => 0
        ];

        $response = $this->actingAs($user)->put(route('admin.avisos.update', $aviso->id), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('avisos', [
            'id' => $aviso->id,
            'titulo' => 'Aviso Atualizado',
            'ativo' => 0
        ]);
    }

    #[Test]
    public function admin_can_destroy_aviso()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@del.com', 'password' => 'secret']);
        $aviso = Aviso::create([
            'titulo' => 'Aviso para Deletar',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->delete(route('admin.avisos.destroy', $aviso->id));

        $response->assertRedirect(route('admin.avisos.index'));
        $this->assertSoftDeleted('avisos', ['id' => $aviso->id]);
    }

    #[Test]
    public function public_api_returns_avisos_by_position()
    {
        Aviso::create([
            'titulo' => 'Aviso Topo',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true
        ]);

        Aviso::create([
            'titulo' => 'Aviso Rodape',
            'tipo' => 'warning',
            'posicao' => 'rodape',
            'estilo' => 'banner',
            'ativo' => true
        ]);

        $response = $this->get(route('avisos.api.posicao', 'topo'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['titulo' => 'Aviso Topo']);
        $response->assertJsonMissing(['titulo' => 'Aviso Rodape']);
    }

    #[Test]
    public function api_can_record_view_and_click()
    {
        $aviso = Aviso::create([
            'titulo' => 'Aviso Métricas',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'visualizacoes' => 0,
            'cliques' => 0
        ]);

        // Registrar Visualização
        $this->post(route('avisos.api.visualizar', $aviso->id));
        $this->assertEquals(1, $aviso->fresh()->visualizacoes);

        // Registrar Clique
        $this->post(route('avisos.api.clique', $aviso->id));
        $this->assertEquals(1, $aviso->fresh()->cliques);
    }

    #[Test]
    public function aviso_respects_date_range()
    {
        // Aviso futuro (não deve estar nos ativos)
        $futuro = Aviso::create([
            'titulo' => 'Aviso Futuro',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'data_inicio' => now()->addDays(1)
        ]);

        // Aviso expirado
        $expirado = Aviso::create([
            'titulo' => 'Aviso Expirado',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'data_fim' => now()->subDays(1)
        ]);

        // Aviso válido
        $valido = Aviso::create([
            'titulo' => 'Aviso Válido',
            'tipo' => 'info',
            'posicao' => 'topo',
            'estilo' => 'banner',
            'ativo' => true,
            'data_inicio' => now()->subDays(1),
            'data_fim' => now()->addDays(1)
        ]);

        $ativos = Aviso::ativos()->get();

        $this->assertTrue($ativos->contains($valido));
        $this->assertFalse($ativos->contains($futuro));
        $this->assertFalse($ativos->contains($expirado));
    }
}
