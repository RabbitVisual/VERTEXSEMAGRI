<?php

namespace Modules\Demandas\Tests\Feature;

use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Modules\Pessoas\App\Models\PessoaCad;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class DemandasCrudTest extends TestCase
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('system_configs');

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
            $table->unsignedBigInteger('localidade_id')->nullable();
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

        Schema::create('system_configs', function (Blueprint $table) {
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
        Schema::dropIfExists('system_configs');
        Schema::dropIfExists('demanda_interessados');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_index_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);

        $response = $this->actingAs($user)->get(route('demandas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::index');
    }

    public function test_create_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        // Need at least one locality to load create page without warning redirect
        Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $response = $this->actingAs($user)->get(route('demandas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::create');
    }

    public function test_store_creates_demand_and_notifies()
    {
        Notification::fake();
        Mail::fake();

        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $data = [
            'solicitante_nome' => 'João Silva',
            'solicitante_email' => 'joao@test.com',
            'solicitante_telefone' => '99999999',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'media',
            'motivo' => 'Vazamento',
            'descricao' => 'Vazamento grande na rua principal ao lado do mercado.',
        ];

        $response = $this->actingAs($user)->post(route('demandas.store'), $data);

        $response->assertRedirect(route('demandas.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('demandas', [
            'solicitante_nome' => 'João Silva',
            'tipo' => 'agua',
            'motivo' => 'Vazamento',
            'total_interessados' => 1,
        ]);

        $demanda = Demanda::where('solicitante_email', 'joao@test.com')->first();
        $this->assertNotNull($demanda->codigo);

        // Check if interested was created
        $this->assertDatabaseHas('demanda_interessados', [
            'demanda_id' => $demanda->id,
            'nome' => 'João Silva',
            'metodo_vinculo' => 'solicitante_original',
        ]);
    }

    public function test_store_detects_duplicate_and_warns()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        // Create first demand
        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'solicitante_nome' => 'João Silva',
            'solicitante_email' => 'joao@test.com',
            'solicitante_telefone' => '99999999',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'media',
            'motivo' => 'Vazamento',
            'descricao' => 'Vazamento grande na rua principal.',
            'status' => 'aberta',
            'data_abertura' => now(),
        ]);

        // Try to create similar demand
        $data = [
            'solicitante_nome' => 'Maria Souza',
            'solicitante_email' => 'maria@test.com',
            'solicitante_telefone' => '88888888',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'prioridade' => 'media',
            'motivo' => 'Vazamento', // Same motif
            'descricao' => 'Tem um vazamento na rua principal.', // Similar description
        ];

        $response = $this->actingAs($user)->post(route('demandas.store'), $data);

        // Should NOT redirect to index (success), but back to create with warning
        $response->assertSessionHas('warning_similaridade');
        $response->assertSessionHas('demanda_similar');
    }

    public function test_show_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'solicitante_nome' => 'João',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Teste',
            'descricao' => 'Teste descricao longa',
            'status' => 'aberta',
            'prioridade' => 'baixa',
        ]);

        $response = $this->actingAs($user)->get(route('demandas.show', $demanda->id));

        $response->assertStatus(200);
        $response->assertSee('DEM-001');
    }

    public function test_edit_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'solicitante_nome' => 'João',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Teste',
            'descricao' => 'Teste descricao longa',
            'status' => 'aberta',
            'prioridade' => 'baixa',
        ]);

        $response = $this->actingAs($user)->get(route('demandas.edit', $demanda->id));

        $response->assertStatus(200);
        $response->assertViewIs('demandas::edit');
    }

    public function test_update_modifies_demand()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'solicitante_nome' => 'João',
            'solicitante_email' => 'joao@old.com',
            'solicitante_telefone' => '11111111',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Teste',
            'descricao' => 'Teste descricao longa',
            'status' => 'aberta',
            'prioridade' => 'baixa',
        ]);

        $newData = [
            'solicitante_nome' => 'João Silva',
            'solicitante_email' => 'joao@new.com',
            'solicitante_telefone' => '22222222',
            'localidade_id' => $localidade->id,
            'tipo' => 'luz',
            'prioridade' => 'alta',
            'motivo' => 'Novo Motivo',
            'descricao' => 'Nova descrição muito mais detalhada.',
            'status' => 'em_andamento',
        ];

        $response = $this->actingAs($user)->put(route('demandas.update', $demanda->id), $newData);

        $response->assertRedirect(route('demandas.show', $demanda->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('demandas', [
            'id' => $demanda->id,
            'tipo' => 'luz',
            'prioridade' => 'alta',
            'status' => 'em_andamento',
            'motivo' => 'Novo Motivo',
        ]);
    }

    public function test_destroy_deletes_demand()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $localidade = Localidade::create(['nome' => 'Centro', 'ativo' => true]);

        $demanda = Demanda::create([
            'codigo' => 'DEM-001',
            'solicitante_nome' => 'João',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'motivo' => 'Teste',
            'descricao' => 'Teste descricao longa',
            'status' => 'aberta',
            'prioridade' => 'baixa',
        ]);

        $response = $this->actingAs($user)->delete(route('demandas.destroy', $demanda->id));

        $response->assertRedirect(route('demandas.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('demandas', ['id' => $demanda->id]);
    }
}
