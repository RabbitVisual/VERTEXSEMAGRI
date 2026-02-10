<?php

namespace Modules\Demandas\Tests\Feature;

use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DemandasPublicTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        config(['modules.statuses.Demandas' => true]);
        config(['modules.statuses.Localidades' => true]);
        config(['modules.statuses.Homepage' => true]);
        config(['modules.statuses.Avisos' => true]);
        config(['modules.statuses.Chat' => true]);

        // Create Schemas
        Schema::dropIfExists('chat_configs');
        Schema::dropIfExists('avisos');
        Schema::dropIfExists('system_configs');
        Schema::dropIfExists('demanda_interessados');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('model_has_roles');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('localidade_id');
            $table->string('tipo');
            $table->text('descricao');
            $table->text('motivo');
            $table->string('status')->default('aberta');
            $table->string('prioridade')->default('baixa');
            $table->timestamp('data_abertura')->nullable();
            $table->string('solicitante_nome');
            $table->string('solicitante_apelido')->nullable();
            $table->string('solicitante_telefone')->nullable();
            $table->string('solicitante_email')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->unsignedBigInteger('poco_id')->nullable();
            $table->unsignedBigInteger('ponto_luz_id')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->text('observacoes')->nullable();
            $table->json('fotos')->nullable();
            $table->integer('total_interessados')->default(1);
            $table->decimal('score_similaridade_max', 5, 2)->nullable();
            $table->text('palavras_chave')->nullable();
            $table->boolean('image_consent')->default(false);
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
            $table->string('cpf', 14)->nullable();
            $table->text('descricao_adicional')->nullable();
            $table->json('fotos')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->boolean('notificar')->default(true);
            $table->boolean('confirmado')->default(false);
            $table->timestamp('data_vinculo')->useCurrent();
            $table->decimal('score_similaridade', 5, 2)->nullable();
            $table->string('metodo_vinculo')->default('manual');
            $table->timestamps();
        });

        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id')->nullable();
            $table->string('numero')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

         Schema::create('pessoas_cad', function (Blueprint $table) {
            $table->id();
            $table->string('nom_pessoa');
            $table->string('nom_apelido_pessoa')->nullable();
            $table->string('num_cpf_pessoa')->nullable();
            $table->string('num_nis_pessoa_atual')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestamps();
        });

        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('conteudo')->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('posicao')->default('flutuante');
            $table->integer('ordem')->default(0);
            $table->boolean('destacar')->default(false);
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_fim')->nullable();
            $table->string('tipo')->default('info');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('chat_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestamps();
        });

        // Mock Roles for permissions
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
            $table->index(['model_id', 'model_type']);
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('chat_configs');
        Schema::dropIfExists('avisos');
        Schema::dropIfExists('system_configs');
        Schema::dropIfExists('demanda_interessados');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_public_consultation_page_loads()
    {
        $response = $this->get(route('demandas.public.consulta'));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::public.consulta');
    }

    public function test_consultar_finds_demand()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Teste',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'data_abertura' => now(),
        ]);

        $response = $this->post(route('demandas.public.consultar'), [
            'codigo' => 'DEM-001'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('demandas::public.resultado');
        $response->assertSee('DEM-001');
    }

    public function test_consultar_finds_demand_case_insensitive()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-ABC-123',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Teste',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'data_abertura' => now(),
        ]);

        // Input lowercase
        $response = $this->post(route('demandas.public.consultar'), [
            'codigo' => 'dem-abc-123'
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('demandas::public.resultado');
    }

    public function test_show_public_url_loads()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Teste',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'data_abertura' => now(),
        ]);

        $response = $this->get(route('demandas.public.show', 'DEM-001'));

        $response->assertStatus(200);
        $response->assertSee('DEM-001');
    }

    public function test_api_status_check()
    {
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Teste',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste',
            'data_abertura' => now(),
        ]);

        $response = $this->get(route('demandas.public.status', 'DEM-001'));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'aberta',
            'dias_aberta' => 0
        ]);
    }
}
