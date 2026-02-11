<?php

namespace Modules\Demandas\Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Models\DemandaInteressado;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Modules\Localidades\App\Models\Localidade;

class DemandasFullSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock rotas externas usadas em views admin
        Route::get('/admin/dashboard', fn() => 'dashboard')->name('admin.dashboard');
        Route::get('/admin/localidades/{id}', fn() => 'loc')->name('admin.localidades.show');
        Route::get('/admin/demandas', fn() => 'demandas')->name('admin.demandas.index');
    }

    /**
     * Cria helper de dados padrão para demanda
     */
    private function makeDemandaData(Localidade $localidade, array $overrides = []): array
    {
        return array_merge([
            'solicitante_nome' => 'João da Silva',
            'solicitante_telefone' => '63999990000',
            'solicitante_email' => 'joao@email.com',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'motivo' => 'Vazamento de água na calçada',
            'descricao' => 'O vazamento acontece próximo ao poste de energia elétrica da rua 15',
        ], $overrides);
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
    // 2. Index – Acesso Autenticado
    // =======================================

    #[Test]
    public function admin_can_access_demandas_index()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste Index',
            'motivo' => 'Vazamento',
            'descricao' => 'Descrição longa para a demanda de teste',
            'data_abertura' => now()
        ]);

        $response = $this->actingAs($user)->get(route('demandas.index'));
        $response->assertStatus(200);
        $response->assertSee('Teste Index');
    }

    // =======================================
    // 3. Store – Criar Demanda com Auto Código
    // =======================================

    #[Test]
    public function admin_can_store_new_demanda_with_auto_code()
    {
        Mail::fake();

        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $data = $this->makeDemandaData($localidade, ['forcar_criar_nova' => true]);

        $response = $this->actingAs($user)->post(route('demandas.store'), $data);
        $response->assertRedirect(route('demandas.index'));

        $this->assertDatabaseHas('demandas', ['solicitante_nome' => 'João da Silva']);

        $demanda = Demanda::where('solicitante_nome', 'João da Silva')->first();
        $this->assertNotNull($demanda);
        $this->assertNotNull($demanda->codigo, 'Código deve ser gerado automaticamente');
        $this->assertStringStartsWith('DEM-', $demanda->codigo);
        $this->assertEquals('aberta', $demanda->status);
    }

    // =======================================
    // 4. Store – Validação Campos Obrigatórios
    // =======================================

    #[Test]
    public function store_fails_without_required_fields()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);

        // Sem nenhum campo
        $response = $this->actingAs($user)->post(route('demandas.store'), []);
        $response->assertSessionHasErrors(['solicitante_nome', 'solicitante_telefone', 'solicitante_email', 'localidade_id', 'tipo', 'prioridade', 'motivo', 'descricao']);
    }

    // =======================================
    // 5. Store – Validação Mínimo 20 chars na descrição
    // =======================================

    #[Test]
    public function store_fails_with_short_description()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $data = $this->makeDemandaData($localidade, [
            'descricao' => 'Muito curta',
            'forcar_criar_nova' => true
        ]);

        $response = $this->actingAs($user)->post(route('demandas.store'), $data);
        $response->assertSessionHasErrors('descricao');
    }

    // =======================================
    // 6. Update + Conclusão com data_conclusao
    // =======================================

    #[Test]
    public function admin_can_update_and_close_demanda()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste Update',
            'solicitante_telefone' => '63999990000',
            'motivo' => 'Atualizar demanda',
            'descricao' => 'Descrição longa suficiente para validação de 20 caracteres',
            'data_abertura' => now()
        ]);

        $data = [
            'solicitante_nome' => 'Teste Update',
            'solicitante_telefone' => '63999990000',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'motivo' => 'Atualizar demanda',
            'descricao' => 'Descricao longa o suficiente para passar na validacao com 20 caracteres',
            'status' => 'concluida'
        ];

        $response = $this->actingAs($user)->put(route('demandas.update', $demanda->id), $data);
        $response->assertRedirect(route('demandas.show', $demanda->id));

        $demanda->refresh();
        $this->assertEquals('concluida', $demanda->status);
        $this->assertNotNull($demanda->data_conclusao, 'data_conclusao deve ser preenchida ao concluir');
    }

    // =======================================
    // 7. Destroy – Exclusão Física (Hard Delete)
    // =======================================

    #[Test]
    public function admin_can_destroy_demanda_physically()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'luz'),
            'localidade_id' => $localidade->id,
            'tipo' => 'luz',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Para Deletar',
            'motivo' => 'Remoção',
            'descricao' => 'Demanda que será removida permanentemente do sistema',
            'data_abertura' => now()
        ]);

        $demandaId = $demanda->id;

        $response = $this->actingAs($user)->delete(route('demandas.destroy', $demandaId));
        $response->assertRedirect(route('demandas.index'));

        // Hard delete: deve sumir completamente, inclusive de withTrashed
        $this->assertNull(Demanda::withTrashed()->find($demandaId), 'Demanda deve ser excluída fisicamente');
    }

    // =======================================
    // 8. Public – Consulta Case-Insensitive
    // =======================================

    #[Test]
    public function public_search_is_case_insensitive()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => 'DEM-PUB-123',
            'localidade_id' => $localidade->id,
            'tipo' => 'estrada',
            'prioridade' => 'media',
            'status' => 'aberta',
            'solicitante_nome' => 'Publico Teste',
            'motivo' => 'Buraco na estrada',
            'descricao' => 'Buraco grande na via principal da cidade',
            'data_abertura' => now()
        ]);

        // Busca com lowercase deve funcionar
        $responseLow = $this->post(route('demandas.public.consultar'), ['codigo' => 'dem-pub-123']);
        $responseLow->assertStatus(200);
        $responseLow->assertSee('DEM-PUB-123');

        // Busca com uppercase
        $responseHigh = $this->post(route('demandas.public.consultar'), ['codigo' => 'DEM-PUB-123']);
        $responseHigh->assertStatus(200);
        $responseHigh->assertSee('DEM-PUB-123');
    }

    // =======================================
    // 9. Public – Privacy Shield (LGPD)
    // =======================================

    #[Test]
    public function privacy_shield_protects_data_in_api()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => 'PRIV-999',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Dono dos Dados',
            'solicitante_email' => 'secreto@dados.com',
            'solicitante_telefone' => '123456',
            'motivo' => 'Privacidade',
            'descricao' => 'Teste de privacidade do sistema',
            'data_abertura' => now()
        ]);

        $response = $this->getJson(route('demandas.public.status', ['codigo' => 'PRIV-999']));
        $response->assertStatus(200);

        // API status NÃO deve conter dados sensíveis
        $response->assertJsonMissing(['solicitante_email' => 'secreto@dados.com']);
        $response->assertJsonMissing(['solicitante_nome' => 'Dono dos Dados']);

        // Deve conter apenas status e dados operacionais
        $response->assertJsonStructure(['status', 'status_texto', 'tem_os', 'dias_aberta']);
    }

    // =======================================
    // 10. Model – toPublicArray LGPD
    // =======================================

    #[Test]
    public function to_public_array_does_not_expose_sensitive_data()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => 'PUB-ARRAY-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'solicitante_nome' => 'João Sensível',
            'solicitante_email' => 'private@example.com',
            'solicitante_telefone' => '123456789',
            'motivo' => 'Test motivo',
            'descricao' => 'Teste de dados públicos do modelo',
            'data_abertura' => now()
        ]);

        $publicData = $demanda->toPublicArray();

        // Deve ter campos públicos
        $this->assertArrayHasKey('codigo', $publicData);
        $this->assertArrayHasKey('status', $publicData);
        $this->assertArrayHasKey('tipo', $publicData);
        $this->assertArrayHasKey('motivo', $publicData);

        // NÃO deve ter dados sensíveis
        $this->assertArrayNotHasKey('solicitante_email', $publicData);
        $this->assertArrayNotHasKey('solicitante_telefone', $publicData);
        $this->assertArrayNotHasKey('solicitante_nome', $publicData);
        $this->assertArrayNotHasKey('user_id', $publicData);
        $this->assertArrayNotHasKey('pessoa_id', $publicData);
    }

    // =======================================
    // 11. Offline Sync – JSON Structure
    // =======================================

    #[Test]
    public function offline_sync_returns_demands_and_materials()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Sync Test',
            'motivo' => 'Testar sync',
            'descricao' => 'Demanda para teste de sync offline',
            'data_abertura' => now()
        ]);

        // Inserir NCM e material (uso de colunas reais e chaves estrangeiras)
        if (Schema::hasTable('ncms') && Schema::hasTable('materiais')) {
            DB::table('ncms')->insertOrIgnore([
                'id' => 3917,
                'code' => '3917',
                'description' => 'Tubo PVC',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::table('materiais')->insert([
                'nome' => 'Tubo PVC',
                'codigo' => 'MAT-PVC-001',
                'unidade_medida' => 'un',
                'ncm_id' => 3917,
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $response = $this->actingAs($user)->getJson(route('demandas.offline.sync'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['demands', 'materials', 'timestamp']);
    }

    // =======================================
    // 12. Observer – Email na Mudança de Status
    // =======================================

    #[Test]
    public function observer_sends_email_on_status_change()
    {
        Mail::fake();

        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        // Registrar observer explicitamente
        Demanda::observe(\Modules\Demandas\App\Observers\DemandaObserver::class);

        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Email Test',
            'solicitante_email' => 'user@test.com',
            'motivo' => 'Teste email',
            'descricao' => 'Teste de envio de e-mail ao mudar status',
            'data_abertura' => now()
        ]);

        // Mudar status deve disparar email
        $demanda->status = 'concluida';
        $demanda->save();

        Mail::assertQueued(\Modules\Demandas\App\Mail\DemandaStatusChanged::class);
    }

    // =======================================
    // 13. Observer – Similaridade na Criação
    // =======================================

    #[Test]
    public function observer_calculates_similarity_on_create()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true, 'latitude' => -10.0, 'longitude' => -48.0]);

        // Base demanda
        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Base',
            'motivo' => 'Vazamento rua 1',
            'descricao' => 'Muito vazamento de água nesta rua',
            'data_abertura' => now()
        ]);

        // Similar demanda (mesma localidade, tipo, motivo, descrição)
        $similar = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Similar',
            'motivo' => 'Vazamento rua 1',
            'descricao' => 'Muito vazamento de água nesta rua',
            'data_abertura' => now()
        ]);

        // Score deve ser alto (observer calcula na criação)
        $this->assertGreaterThan(50, $similar->fresh()->score_similaridade_max,
            'Score de similaridade deve ser > 50 para demandas quase idênticas');
    }

    // =======================================
    // 14. SimilaridadeService – Geolocalização
    // =======================================

    #[Test]
    public function similaridade_service_ranks_by_proximity()
    {
        $service = app(SimilaridadeDemandaService::class);

        $locBase = Localidade::create(['nome' => 'Base', 'latitude' => 0, 'longitude' => 0, 'ativo' => true]);
        $locPerto = Localidade::create(['nome' => 'Perto', 'latitude' => 0.001, 'longitude' => 0.001, 'ativo' => true]);
        $locLonge = Localidade::create(['nome' => 'Longe', 'latitude' => 1.0, 'longitude' => 1.0, 'ativo' => true]);

        $demandaBase = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $locBase->id,
            'tipo' => 'agua',
            'motivo' => 'vazamento',
            'descricao' => 'cano estourado na rua principal',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'prioridade' => 'baixa',
            'data_abertura' => now()
        ]);

        $scorePerto = $service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $locPerto->id,
            'tipo' => 'agua',
            'motivo' => 'vazamento',
            'descricao' => 'cano estourado na rua principal',
        ]);

        $scoreLonge = $service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $locLonge->id,
            'tipo' => 'agua',
            'motivo' => 'vazamento',
            'descricao' => 'cano estourado na rua principal',
        ]);

        $this->assertGreaterThan($scoreLonge, $scorePerto,
            'Localidade próxima deve ter score maior que localidade distante');
    }

    // =======================================
    // 15. Model – Scopes (abertas, concluidas, urgentes, porTipo)
    // =======================================

    #[Test]
    public function demanda_scopes_filter_correctly()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua', 'prioridade' => 'urgente', 'status' => 'aberta',
            'solicitante_nome' => 'A', 'motivo' => 'M', 'descricao' => 'Desc de teste A',
            'data_abertura' => now()
        ]);

        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'luz'),
            'localidade_id' => $localidade->id,
            'tipo' => 'luz', 'prioridade' => 'baixa', 'status' => 'concluida',
            'solicitante_nome' => 'B', 'motivo' => 'M', 'descricao' => 'Desc de teste B',
            'data_abertura' => now(), 'data_conclusao' => now()
        ]);

        Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'estrada'),
            'localidade_id' => $localidade->id,
            'tipo' => 'estrada', 'prioridade' => 'alta', 'status' => 'em_andamento',
            'solicitante_nome' => 'C', 'motivo' => 'M', 'descricao' => 'Desc de teste C',
            'data_abertura' => now()
        ]);

        $this->assertEquals(1, Demanda::abertas()->count());
        $this->assertEquals(1, Demanda::concluidas()->count());
        $this->assertEquals(1, Demanda::emAndamento()->count());
        $this->assertEquals(1, Demanda::urgentes()->count());
        $this->assertEquals(1, Demanda::porTipo('agua')->count());
        $this->assertEquals(1, Demanda::porTipo('luz')->count());
    }

    // =======================================
    // 16. Model – Accessors
    // =======================================

    #[Test]
    public function demanda_accessors_return_correct_values()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'urgente',
            'status' => 'aberta',
            'solicitante_nome' => 'Accessor Test',
            'motivo' => 'Testar accessors',
            'descricao' => 'Demanda para testar accessors do model',
            'data_abertura' => now()
        ]);

        $this->assertEquals('Aberta', $demanda->status_texto);
        $this->assertEquals('Urgente', $demanda->prioridade_texto);
        $this->assertEquals('Água', $demanda->tipo_texto);
        $this->assertNotNull($demanda->status_cor);
        $this->assertNotNull($demanda->prioridade_cor);
    }

    // =======================================
    // 17. Model – Helpers (podeCriarOS, temOS, podeConcluir)
    // =======================================

    #[Test]
    public function demanda_helpers_work_correctly()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Helper Test',
            'motivo' => 'Testar helpers',
            'descricao' => 'Demanda para testar helper methods',
            'data_abertura' => now()
        ]);

        $this->assertTrue($demanda->podeCriarOS(), 'Demanda aberta pode criar OS');
        $this->assertFalse($demanda->temOS(), 'Demanda sem OS retorna false');
        $this->assertTrue($demanda->podeConcluir(), 'Demanda aberta pode ser concluída');
        $this->assertTrue($demanda->podeCancelar(), 'Demanda aberta pode ser cancelada');

        // Demanda concluída não pode criar OS
        $demanda->update(['status' => 'concluida', 'data_conclusao' => now()]);
        $this->assertFalse($demanda->fresh()->podeCriarOS());
    }

    // =======================================
    // 18. Code Generation – Unique Codes
    // =======================================

    #[Test]
    public function demanda_generates_unique_codes()
    {
        $code1 = Demanda::generateCode('DEM', 'agua');
        $this->assertStringStartsWith('DEM-', $code1);

        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        Demanda::create([
            'codigo' => $code1,
            'localidade_id' => $localidade->id,
            'tipo' => 'agua', 'prioridade' => 'baixa', 'status' => 'aberta',
            'solicitante_nome' => 'Code1', 'motivo' => 'M', 'descricao' => 'D',
            'data_abertura' => now()
        ]);

        $code2 = Demanda::generateCode('DEM', 'agua');
        $this->assertNotEquals($code1, $code2, 'Códigos devem ser únicos após inserção');
    }

    // =======================================
    // 19. Relationships – Demanda ↔ Interessados
    // =======================================

    #[Test]
    public function demanda_has_interessados_relationship()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua', 'prioridade' => 'baixa', 'status' => 'aberta',
            'solicitante_nome' => 'Original', 'solicitante_email' => 'orig@test.com',
            'motivo' => 'Interesse', 'descricao' => 'Demanda com múltiplos interessados',
            'data_abertura' => now()
        ]);

        // Criar interessado original
        DemandaInteressado::create([
            'demanda_id' => $demanda->id,
            'nome' => 'Original',
            'email' => 'orig@test.com',
            'notificar' => true,
            'metodo_vinculo' => 'solicitante_original',
            'data_vinculo' => now()
        ]);

        DemandaInteressado::create([
            'demanda_id' => $demanda->id,
            'nome' => 'Vizinho',
            'email' => 'vizinho@test.com',
            'notificar' => true,
            'metodo_vinculo' => 'manual',
            'data_vinculo' => now()
        ]);

        $this->assertEquals(2, $demanda->interessados()->count());
        $this->assertEquals(2, $demanda->interessadosNotificaveis()->count());
    }

    // =======================================
    // 20. Artisan Command – Migrar Interessados
    // =======================================

    #[Test]
    public function migration_command_creates_original_interested()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => Demanda::generateCode('DEM', 'agua'),
            'localidade_id' => $localidade->id,
            'tipo' => 'agua', 'prioridade' => 'baixa', 'status' => 'aberta',
            'solicitante_nome' => 'Migrado', 'solicitante_email' => 'mig@test.com',
            'motivo' => 'Teste Migração', 'descricao' => 'Demanda para teste de migração',
            'data_abertura' => now()
        ]);

        // Remover interessado automático se houver
        DB::table('demanda_interessados')->where('demanda_id', $demanda->id)->delete();

        $this->artisan('demandas:migrar-interessados', ['--force' => true])
             ->assertExitCode(0);

        $this->assertDatabaseHas('demanda_interessados', [
            'demanda_id' => $demanda->id,
            'nome' => 'Migrado',
            'email' => 'mig@test.com',
            'metodo_vinculo' => 'solicitante_original'
        ]);
    }

    // =======================================
    // 21. Index – Similarity Alert Badge
    // =======================================

    #[Test]
    public function index_displays_similarity_alert_for_high_score()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin_' . uniqid() . '@vertex.com', 'password' => bcrypt('secret')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => 'DEM-SIM-HIGH',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'solicitante_nome' => 'Alto Score',
            'motivo' => 'cano estourado',
            'descricao' => 'vazamento na rua principal',
            'score_similaridade_max' => 95.00,
            'data_abertura' => now()
        ]);

        $response = $this->actingAs($user)->get(route('demandas.index'));
        $response->assertStatus(200);
        $response->assertSee('DEM-SIM-HIGH');

        // A view aplica classe bg-amber-50 e exibe title com score para demandas com score > 80
        $content = $response->getContent();
        $this->assertTrue(
            str_contains($content, 'bg-amber-50') || str_contains($content, 'Duplicata') || str_contains($content, '95'),
            'Index deve destacar demandas com alto score de similaridade'
        );
    }
}
