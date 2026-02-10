<?php

namespace Modules\Demandas\Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Demandas\App\Models\Demanda;
use Modules\Localidades\App\Models\Localidade;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\View;

class DemandasIndexTest extends TestCase
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
        
        // Setup schemas manually
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('codigo')->nullable();
            $table->string('tipo')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('demandas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->string('tipo')->nullable();
            $table->text('descricao')->nullable();
            $table->text('motivo')->nullable();
            $table->string('status')->default('aberta');
            $table->timestamp('data_abertura')->nullable();
            $table->string('solicitante_nome')->nullable();
            $table->string('prioridade')->default('baixa');
            $table->integer('total_interessados')->default(1);
            $table->decimal('score_similaridade_max', 5, 2)->nullable();
            $table->text('palavras_chave')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->unsignedBigInteger('poco_id')->nullable();
            $table->string('solicitante_apelido')->nullable();
            $table->string('solicitante_telefone')->nullable();
            $table->string('solicitante_email')->nullable();
            $table->timestamp('data_conclusao')->nullable();
            $table->text('observacoes')->nullable();
            $table->json('fotos')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
            $table->string('nom_pessoa')->nullable();
            $table->string('nom_apelido_pessoa')->nullable();
            $table->string('num_cpf_pessoa')->nullable();
            $table->unsignedBigInteger('localidade_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Mock roles and permissions tables for Spatie Permission
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
            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
            $table->primary(['role_id', 'model_id', 'model_type']);
        });
    }

    public function test_index_displays_similarity_alert()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $localidade = Localidade::create([
            'nome' => 'Centro',
            'latitude' => 0,
            'longitude' => 0,
            'ativo' => true,
        ]);

        // Demanda with high similarity score
        $demandaHigh = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidade->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento na rua',
            'motivo' => 'cano estourado',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste 1',
            'score_similaridade_max' => 95.00,
            'data_abertura' => now(),
        ]);

        // Demanda with low similarity score
        $demandaLow = Demanda::create([
            'codigo' => 'DEM-002',
            'localidade_id' => $localidade->id,
            'tipo' => 'luz',
            'descricao' => 'lampada queimada',
            'motivo' => 'escuro',
            'status' => 'aberta',
            'solicitante_nome' => 'Teste 2',
            'score_similaridade_max' => 20.00,
            'data_abertura' => now(),
        ]);
        
        $response = $this->actingAs($user)->get(route('demandas.index'));

        if ($response->status() !== 200) {
            dump($response->exception->getMessage());
        }
        $response->assertStatus(200);
        
        $response->assertSee('DEM-001');
        $response->assertSee('triangle-exclamation'); // The icon name
        $response->assertSee('Duplicata Provável');
    }
}
