<?php

namespace Modules\Ordens\Tests\Feature;

use Modules\Ordens\App\Models\OrdemServico;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class OrdensCrudTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);
        config(['modules.statuses.Ordens' => true]);
        config(['modules.statuses.Demandas' => true]);
        config(['modules.statuses.Equipes' => true]);
        config(['modules.statuses.Funcionarios' => true]);
        config(['modules.statuses.Materiais' => true]);

        // Drop tables if they exist
        Schema::dropIfExists('ordem_servico_materiais');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('equipes');
        Schema::dropIfExists('funcionarios');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('equipe_membros');
        Schema::dropIfExists('equipe_funcionarios');

        // Create Schemas
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
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pessoas_cad', function (Blueprint $table) {
            $table->id();
            $table->string('nom_pessoa');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->boolean('ativa')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('equipe_membros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipe_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('equipe_funcionarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipe_id');
            $table->unsignedBigInteger('funcionario_id');
            $table->timestamps();
        });

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->string('tipo')->nullable();
            $table->string('status')->default('aberta');
            $table->string('prioridade')->default('baixa');
            $table->text('motivo')->nullable();
            $table->text('descricao')->nullable();
            $table->string('solicitante_nome')->nullable();
            $table->timestamp('data_abertura')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->unsignedBigInteger('poco_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id')->nullable();
            $table->unsignedBigInteger('equipe_id')->nullable();
            $table->unsignedBigInteger('funcionario_id')->nullable();
            $table->unsignedBigInteger('user_id_abertura')->nullable();
            $table->unsignedBigInteger('user_id_execucao')->nullable();
            $table->unsignedBigInteger('user_id_atribuido')->nullable();
            $table->string('numero')->nullable();
            $table->string('status')->default('pendente');
            $table->string('prioridade')->default('media');
            $table->text('descricao')->nullable();
            $table->timestamp('data_abertura')->useCurrent();
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->integer('tempo_execucao')->nullable();
            $table->string('tipo_servico')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ordem_servico_materiais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordem_servico_id');
            $table->unsignedBigInteger('material_id');
            $table->decimal('quantidade', 10, 2);
            $table->decimal('valor_unitario', 10, 2)->nullable();
            $table->string('status_reserva')->default('reservado');
            $table->unsignedBigInteger('poste_id')->nullable();
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
        Schema::dropIfExists('ordem_servico_materiais');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('equipe_funcionarios');
        Schema::dropIfExists('equipe_membros');
        Schema::dropIfExists('funcionarios');
        Schema::dropIfExists('equipes');
        Schema::dropIfExists('pessoas_cad');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_index_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);

        $response = $this->actingAs($user)->get(route('ordens.index'));

        $response->assertStatus(200);
        $response->assertViewIs('ordens::index');
    }

    public function test_show_page_loads()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);

        $ordem = OrdemServico::create([
            'numero' => 'OS-001',
            'status' => 'pendente',
            'prioridade' => 'alta',
            'descricao' => 'Teste OS',
            'user_id_abertura' => $user->id,
            'data_abertura' => now(), // Explicitly setting it though DB defaults should handle it
        ]);

        $response = $this->actingAs($user)->get(route('ordens.show', $ordem->id));

        $response->assertStatus(200);
        $response->assertSee('OS-001');
    }

    public function test_start_order()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $equipe = DB::table('equipes')->insertGetId(['nome' => 'Equipe A', 'ativa' => true]);

        $ordem = OrdemServico::create([
            'numero' => 'OS-002',
            'status' => 'pendente',
            'equipe_id' => $equipe,
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('ordens.iniciar', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));
        $this->assertDatabaseHas('ordens_servico', [
            'id' => $ordem->id,
            'status' => 'em_execucao',
        ]);
    }

    public function test_conclude_order()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $equipe = DB::table('equipes')->insertGetId(['nome' => 'Equipe A', 'ativa' => true]);

        $ordem = OrdemServico::create([
            'numero' => 'OS-003',
            'status' => 'em_execucao',
            'equipe_id' => $equipe,
            'data_inicio' => now()->subHour(),
            'user_id_abertura' => $user->id,
            'user_id_execucao' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('ordens.concluir', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));
        $this->assertDatabaseHas('ordens_servico', [
            'id' => $ordem->id,
            'status' => 'concluida',
        ]);
    }

    public function test_destroy_order()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);

        $ordem = OrdemServico::create([
            'numero' => 'OS-004',
            'status' => 'pendente',
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->delete(route('ordens.destroy', $ordem->id));

        $response->assertRedirect(route('ordens.index'));
        $this->assertDatabaseMissing('ordens_servico', ['id' => $ordem->id]);
    }
}
