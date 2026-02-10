<?php

namespace Modules\Demandas\Tests\Feature;

use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DemandasSearchTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        // Enable module in config/modules (mocking)
        config(['modules.statuses.Demandas' => true]);
        config(['modules.statuses.Localidades' => true]);
        config(['modules.statuses.Pessoas' => true]);

        // Create Schemas
        Schema::dropIfExists('demanda_interessados');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');

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

        Schema::create('pessoas_cad', function (Blueprint $table) {
            $table->id();
            $table->string('nom_pessoa');
            $table->string('nom_apelido_pessoa')->nullable();
            $table->string('num_cpf_pessoa')->nullable();
            $table->string('num_nis_pessoa_atual')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->date('data_nascimento')->nullable();
            $table->boolean('recebe_pbf')->default(false);
            $table->integer('idade')->nullable();
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

        // Need to create demanda_interessados table for controller dependencies
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
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('demanda_interessados');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_buscar_pessoa_returns_json()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        PessoaCad::create([
            'nom_pessoa' => 'João da Silva',
            'num_cpf_pessoa' => '12345678900',
            'localidade_id' => $localidade->id,
            'ativo' => true
        ]);

        $response = $this->actingAs($user)->get(route('demandas.buscar-pessoa', ['q' => 'João']));

        $response->assertStatus(200);
        $response->assertJsonFragment(['nome' => 'João da Silva']);
    }

    public function test_verificar_similares_returns_matches()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Vazamento grande na rua principal',
            'status' => 'aberta',
            'prioridade' => 'alta',
            'solicitante_nome' => 'Maria',
        ]);

        $response = $this->actingAs($user)->postJson(route('demandas.verificar-similares'), [
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Tem um vazamento na rua principal', // Similar
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['encontrou' => true]);
        $response->assertJsonFragment(['codigo' => 'DEM-001']);
    }

    public function test_export_csv()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'descricao' => 'Vazamento grande na rua principal',
            'status' => 'aberta',
            'prioridade' => 'alta',
            'solicitante_nome' => 'Maria',
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('demandas.index', ['format' => 'csv']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('DEM-001', $response->streamedContent());
    }
}
