<?php

namespace Modules\Demandas\Tests\Feature;

use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Modules\Materiais\App\Models\Material;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class OfflineSyncTest extends TestCase
{
    protected function setUp(): void
    {
        // Force SQLite memory database for this test
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();

        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        // Ensure required tables exist
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('materiais');
        Schema::dropIfExists('ordens_servico');
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
            $table->string('nome')->nullable();
            $table->string('codigo')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create materiais table
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

        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demanda_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('aberta');
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('localidades');
        Schema::dropIfExists('materiais');
        Schema::dropIfExists('ordens_servico');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_sync_data_returns_demands_and_materials_with_ncm()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $localidade = Localidade::create(['nome' => 'Test Loc', 'ativo' => true]);

        Demanda::create([
            'status' => 'aberta',
            'localidade_id' => $localidade->id
        ]);

        Material::create([
            'nome' => 'Material Test',
            'unidade_medida' => 'kg',
            'codigo_barra' => '123456',
            'ncm_id' => 100, // Dummy NCM ID
            'ativo' => true
        ]);

        $response = $this->actingAs($user)->getJson(route('demandas.offline.sync'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'demands',
            'materials' => [
                '*' => [
                    'id',
                    'nome',
                    'unidade',
                    'codigo',
                    'ncm_id'
                ]
            ],
            'timestamp'
        ]);
    }
}
