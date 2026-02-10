<?php

namespace Modules\Demandas\Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DemandasFullSuiteTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        putenv('SESSION_DRIVER=array');

        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        config(['session.driver' => 'array']);

        $this->createMocks();
    }

    protected function createMocks()
    {
        // Users & Roles
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        // Global System Mocks (required by views/layouts)
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->text('conteudo')->nullable();
            $table->string('tipo')->default('info');
            $table->string('posicao')->default('topo');
            $table->string('estilo')->default('banner');
            $table->string('cor_primaria')->nullable();
            $table->string('cor_secundaria')->nullable();
            $table->string('imagem')->nullable();
            $table->string('url_acao')->nullable();
            $table->string('texto_botao')->nullable();
            $table->boolean('botao_exibir')->default(true);
            $table->boolean('dismissivel')->default(false);
            $table->boolean('ativo')->default(true);
            $table->boolean('destacar')->default(false);
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_fim')->nullable();
            $table->integer('ordem')->default(0);
            $table->integer('visualizacoes')->default(0);
            $table->integer('cliques')->default(0);
            $table->json('configuracoes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('config_key')->unique();
            $table->text('config_value')->nullable();
            $table->string('config_group')->nullable();
            $table->timestamps();
        });

        Schema::create('chat_configs', function (Blueprint $table) {
            $table->id();
            $table->boolean('whatsapp_enabled')->default(false);
            $table->string('whatsapp_number')->nullable();
            $table->string('whatsapp_message')->nullable();
            $table->timestamps();
        });

        // Localidades & Pessoas
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->nullable();
            $table->boolean('ativo')->default(true);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pessoas_cad', function (Blueprint $table) {
            $table->id();
            $table->string('nom_pessoa');
            $table->string('nom_apelido_pessoa')->nullable();
            $table->string('num_cpf_pessoa')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Materiais & NCM
        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('unidade_medida')->default('un');
            $table->string('codigo_barra')->nullable();
            $table->unsignedBigInteger('ncm_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Demandas & OS
        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('tipo');
            $table->string('prioridade');
            $table->string('status')->default('aberta');
            $table->string('solicitante_nome');
            $table->string('solicitante_apelido')->nullable();
            $table->string('solicitante_telefone')->nullable();
            $table->string('solicitante_email')->nullable();
            $table->text('motivo');
            $table->text('descricao');
            $table->text('observacoes')->nullable();
            $table->integer('total_interessados')->default(1);
            $table->decimal('score_similaridade_max', 5, 2)->nullable();
            $table->text('palavras_chave')->nullable();
            $table->timestamp('data_abertura')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id')->nullable();
            $table->string('numero')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demanda_interessados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id');
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->string('nome');
            $table->string('apelido')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('cpf')->nullable();
            $table->text('descricao_adicional')->nullable();
            $table->json('fotos')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('notificar')->default(true);
            $table->boolean('confirmado')->default(false);
            $table->timestamp('data_vinculo')->nullable();
            $table->decimal('score_similaridade', 5, 2)->nullable();
            $table->string('metodo_vinculo')->default('manual');
            $table->timestamps();
        });
    }

    /** @test */
    public function admin_can_access_index_with_stats()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@suite.com', 'password' => 'secret']);

        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'alta',
            'status' => 'aberta',
            'solicitante_nome' => 'João',
            'motivo' => 'Vazamento',
            'descricao' => 'Cano estourado na calçada',
            'data_abertura' => now()
        ]);

        $response = $this->actingAs($user)->get(route('demandas.index'));

        $response->assertStatus(200);
        $response->assertSee('Gestão de Demandas');
        $response->assertSee('DEM-001');
        $response->assertSee('João');
    }

    /** @test */
    public function admin_can_store_new_demanda()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@suite.com', 'password' => 'secret']);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $data = [
            'solicitante_nome' => 'Maria Oliveira',
            'solicitante_telefone' => '88999999999',
            'solicitante_email' => 'maria@example.com',
            'localidade_id' => $localidade->id,
            'tipo' => 'luz',
            'prioridade' => 'urgente',
            'motivo' => 'Poste caído',
            'descricao' => 'Poste caiu após chuva forte',
        ];

        $response = $this->actingAs($user)->post(route('demandas.store'), $data);

        $response->assertRedirect(route('demandas.index'));
        $this->assertDatabaseHas('demandas', ['solicitante_nome' => 'Maria Oliveira']);

        // Check if interested person was created automatically
        $demanda = Demanda::where('solicitante_nome', 'Maria Oliveira')->first();
        $this->assertEquals(1, $demanda->total_interessados);
    }

    /** @test */
    public function public_search_is_case_insensitive()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => 'DEM-PUB-123',
            'localidade_id' => $localidade->id,
            'tipo' => 'estrada',
            'prioridade' => 'media',
            'status' => 'aberta',
            'solicitante_nome' => 'Publico',
            'motivo' => 'Buraco',
            'descricao' => 'Buraco grande na via principal',
            'data_abertura' => now()
        ]);

        // Search with lowercase
        $responseLow = $this->post(route('demandas.public.consultar'), ['codigo' => 'dem-pub-123']);
        $responseLow->assertStatus(200);
        $responseLow->assertSee('DEM-PUB-123');

        // Search with uppercase
        $responseHigh = $this->post(route('demandas.public.consultar'), ['codigo' => 'DEM-PUB-123']);
        $responseHigh->assertStatus(200);
        $responseHigh->assertSee('DEM-PUB-123');
    }

    /** @test */
    public function offline_sync_contains_ncm_and_materials()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@suite.com', 'password' => 'secret']);

        DB::table('materiais')->insert([
            'nome' => 'Tubo PVC',
            'unidade_medida' => 'un',
            'codigo_barra' => '123',
            'ncm_id' => 3917,
            'ativo' => true
        ]);

        $response = $this->actingAs($user)->get(route('demandas.offline.sync'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['ncm_id' => 3917]);
    }

    /** @test */
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
            'descricao' => 'Teste de privacidade',
            'data_abertura' => now()
        ]);

        $response = $this->getJson(route('demandas.public.status', ['codigo' => 'PRIV-999']));

        $response->assertStatus(200);
        $response->assertJsonMissing(['solicitante_email' => 'secreto@dados.com']);
        $response->assertJsonMissing(['solicitante_nome' => 'Dono dos Dados']);
    }

    /** @test */
    public function admin_can_update_and_close_demanda()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@suite.com', 'password' => 'secret']);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-UPD',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste Update',
            'motivo' => 'Atualizar',
            'descricao' => 'Desc'
        ]);

        $data = [
            'solicitante_nome' => 'Teste Update',
            'solicitante_telefone' => '123',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'motivo' => 'Atualizar',
            'descricao' => 'Descricao longa o suficiente para passar na validacao com 20 caracteres',
            'status' => 'concluida'
        ];

        $response = $this->actingAs($user)->put(route('demandas.update', $demanda->id), $data);

        $response->assertRedirect(route('demandas.show', $demanda->id));
        $this->assertEquals('concluida', $demanda->fresh()->status);
        $this->assertNotNull($demanda->fresh()->data_conclusao);
    }

    /** @test */
    public function migration_command_works_correctly()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);
        $demanda = Demanda::create([
            'codigo' => 'MIG-1',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Migrado',
            'solicitante_email' => 'mig@test.com',
            'motivo' => 'Teste Migração',
            'descricao' => 'Desc'
        ]);

        // Remove automatic interested person if any
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

    /** @test */
    public function observer_calculates_similarity_on_create()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        // Base demanda
        Demanda::create([
            'codigo' => 'BASE',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Base',
            'motivo' => 'Vazamento rua 1',
            'descricao' => 'Muito vazamento aqui'
        ]);

        // Similar demanda
        $similar = Demanda::create([
            'codigo' => 'SIMILAR',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Similar',
            'motivo' => 'Vazamento rua 1',
            'descricao' => 'Muito vazamento aqui'
        ]);

        // Score should be high (observer should have triggered)
        $this->assertGreaterThan(50, $similar->fresh()->score_similaridade_max);
    }

    /** @test */
    public function email_is_sent_on_status_change()
    {
        \Illuminate\Support\Facades\Mail::fake();

        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        // Ensure observer is registered for this test (sometimes traits/mocks interfere)
        Demanda::observe(\Modules\Demandas\App\Observers\DemandaObserver::class);

        $demanda = Demanda::create([
            'codigo' => 'EMAIL-1',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'Email Test',
            'solicitante_email' => 'user@test.com',
            'motivo' => 'Email',
            'descricao' => 'Desc'
        ]);

        $demanda->status = 'concluida';
        $demanda->save();

        \Illuminate\Support\Facades\Mail::assertQueued(\Modules\Demandas\App\Mail\DemandaStatusChanged::class);
    }

    /** @test */
    public function pdf_reports_render_correctly()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@suite.com', 'password' => 'secret']);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'PDF-1',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'baixa',
            'status' => 'aberta',
            'solicitante_nome' => 'PDF Test',
            'motivo' => 'PDF',
            'descricao' => 'Desc'
        ]);

        // Test Relatório de Abertas
        $response = $this->actingAs($user)->get(route('demandas.relatorio.abertas.pdf'));
        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));

        // Test Print Demanda
        $responsePrint = $this->actingAs($user)->get(route('demandas.print', $demanda->id));
        $responsePrint->assertStatus(200);
    }
}
