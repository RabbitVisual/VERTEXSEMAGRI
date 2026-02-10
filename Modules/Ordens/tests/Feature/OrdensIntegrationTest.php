<?php

namespace Modules\Ordens\Tests\Feature;

use Modules\Ordens\App\Models\OrdemServico;
use Modules\Demandas\App\Models\Demanda;
use Modules\Materiais\App\Models\Material;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class OrdensIntegrationTest extends TestCase
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
        config(['modules.statuses.Materiais' => true]);

        // Clean up
        Schema::dropIfExists('ordem_servico_materiais');
        Schema::dropIfExists('material_movimentacoes');
        Schema::dropIfExists('materiais');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('equipes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('pessoas_cad');

        // Schemas
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

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->string('tipo')->nullable();
            $table->string('status')->default('aberta');
            $table->string('prioridade')->default('baixa');
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
            $table->string('numero')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamp('data_abertura')->useCurrent();
            $table->timestamp('data_inicio')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->integer('tempo_execucao')->nullable();
            $table->unsignedBigInteger('user_id_abertura')->nullable();
            $table->unsignedBigInteger('user_id_execucao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('quantidade_estoque', 10, 2)->default(0);
            $table->decimal('quantidade_minima', 10, 2)->default(0);
            $table->decimal('valor_unitario', 10, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->unsignedBigInteger('ncm_id')->nullable();
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

        Schema::create('material_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->string('tipo'); // entrada, saida
            $table->decimal('quantidade', 10, 2);
            $table->string('motivo')->nullable();
            $table->unsignedBigInteger('ordem_servico_id')->nullable();
            $table->string('status')->default('confirmado'); // reservado, confirmado
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('material_movimentacoes');
        Schema::dropIfExists('ordem_servico_materiais');
        Schema::dropIfExists('materiais');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('equipes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('pessoas_cad');
        parent::tearDown();
    }

    public function test_starting_order_updates_demand_status()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $equipe = DB::table('equipes')->insertGetId(['nome' => 'Equipe A', 'ativa' => true]);

        $demanda = Demanda::create([
            'status' => 'aberta',
            'tipo' => 'agua',
            'localidade_id' => 1
        ]);

        $ordem = OrdemServico::create([
            'demanda_id' => $demanda->id,
            'status' => 'pendente',
            'equipe_id' => $equipe,
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('ordens.iniciar', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));

        $this->assertDatabaseHas('demandas', [
            'id' => $demanda->id,
            'status' => 'em_andamento',
        ]);
    }

    public function test_concluding_order_updates_demand_status()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $equipe = DB::table('equipes')->insertGetId(['nome' => 'Equipe A', 'ativa' => true]);

        $demanda = Demanda::create([
            'status' => 'em_andamento',
            'tipo' => 'agua',
            'localidade_id' => 1
        ]);

        $ordem = OrdemServico::create([
            'demanda_id' => $demanda->id,
            'status' => 'em_execucao',
            'equipe_id' => $equipe,
            'data_inicio' => now()->subHour(),
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->post(route('ordens.concluir', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));

        $this->assertDatabaseHas('demandas', [
            'id' => $demanda->id,
            'status' => 'concluida',
        ]);
    }

    public function test_concluding_order_confirms_material_reservation()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);
        $equipe = DB::table('equipes')->insertGetId(['nome' => 'Equipe A', 'ativa' => true]);

        // Create Material with stock
        $material = Material::create([
            'nome' => 'Cano PVC',
            'quantidade_estoque' => 10,
            'ativo' => true
        ]);

        $ordem = OrdemServico::create([
            'status' => 'em_execucao',
            'equipe_id' => $equipe,
            'data_inicio' => now()->subHour(),
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        // Create reservation in material_movimentacoes as 'reservado'
        DB::table('material_movimentacoes')->insert([
            'material_id' => $material->id,
            'tipo' => 'saida',
            'quantidade' => 2,
            'motivo' => 'Reserva OS',
            'ordem_servico_id' => $ordem->id,
            'status' => 'reservado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create related OrdemServicoMaterial using CREATE (not attach)
        $ordem->materiais()->create([
            'material_id' => $material->id,
            'quantidade' => 2,
            'status_reserva' => 'reservado'
        ]);

        $response = $this->actingAs($user)->post(route('ordens.concluir', $ordem->id));

        $response->assertRedirect(route('ordens.show', $ordem->id));

        // Check if reservation was confirmed in pivot
        $this->assertDatabaseHas('ordem_servico_materiais', [
            'ordem_servico_id' => $ordem->id,
            'material_id' => $material->id,
            'status_reserva' => 'confirmado',
        ]);

        // Check if reservation was confirmed in movimentacoes (Material logic)
        $this->assertDatabaseHas('material_movimentacoes', [
            'ordem_servico_id' => $ordem->id,
            'material_id' => $material->id,
            'status' => 'confirmado',
        ]);
    }

    public function test_pdf_report_generation()
    {
        $user = User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('123')]);

        $ordem = OrdemServico::create([
            'numero' => 'OS-005',
            'status' => 'concluida',
            'data_conclusao' => now(),
            'user_id_abertura' => $user->id,
            'data_abertura' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('ordens.relatorio.demandas-dia.pdf'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
