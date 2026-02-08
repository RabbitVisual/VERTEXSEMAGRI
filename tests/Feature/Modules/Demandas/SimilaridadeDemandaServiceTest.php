<?php

namespace Tests\Feature\Modules\Demandas;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Demandas\App\Models\Demanda;
use Modules\Demandas\App\Services\SimilaridadeDemandaService;
use Modules\Localidades\App\Models\Localidade;
use Tests\TestCase;

class SimilaridadeDemandaServiceTest extends TestCase
{
    // Do NOT use RefreshDatabase as it runs all migrations which are broken for SQLite

    protected $service;

    protected function setUp(): void
    {
        // Force SQLite memory database for this test
        // This must be set BEFORE parent::setUp() because the app boots there
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();

        // Also ensure config is set correctly after boot
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => ':memory:']);

        // Ensure we start with a clean state for these tables
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('localidades');

        // Manually create minimal tables required for the test
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('codigo')->nullable();
            $table->string('tipo')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->timestamps();
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

        $this->service = new SimilaridadeDemandaService();
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('demandas');
        Schema::dropIfExists('localidades');
        parent::tearDown();
    }

    public function test_calcular_similaridade_localidades_proximas()
    {
        // Localidade Base (0, 0)
        $localidadeBase = Localidade::create([
            'latitude' => 0,
            'longitude' => 0,
            'nome' => 'Base',
        ]);

        // Demanda Base
        $demandaBase = Demanda::create([
            'codigo' => 'DEM-001',
            'localidade_id' => $localidadeBase->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
            'status' => 'aberta',
            'data_abertura' => now(),
            'solicitante_nome' => 'Teste',
            'prioridade' => 'baixa',
        ]);

        // Caso 1: Mesma localidade (ID igual)
        $scoreMesma = $this->service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $localidadeBase->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
        ]);

        // Caso 2: Localidade diferente mas MUITO perto (0.0001 graus ~11m)
        $localidadeMuitoPerto = Localidade::create([
            'latitude' => 0.0001,
            'longitude' => 0.0001,
            'nome' => 'Muito Perto',
        ]);
        $scoreMuitoPerto = $this->service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $localidadeMuitoPerto->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
        ]);

        // Caso 3: Localidade Perto (0.009 graus ~1km)
        $localidadePerto = Localidade::create([
            'latitude' => 0.009,
            'longitude' => 0.009,
            'nome' => 'Perto',
        ]);
        $scorePerto = $this->service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $localidadePerto->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
        ]);

        // Caso 4: Localidade Media (0.05 graus ~5.5km)
        $localidadeMedia = Localidade::create([
            'latitude' => 0.05,
            'longitude' => 0.05,
            'nome' => 'Media',
        ]);
        $scoreMedia = $this->service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $localidadeMedia->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
        ]);

        // Caso 5: Localidade Longe (1 grau ~111km)
        $localidadeLonge = Localidade::create([
            'latitude' => 1.0,
            'longitude' => 1.0,
            'nome' => 'Longe',
        ]);
        $scoreLonge = $this->service->calcularScoreSimilaridade($demandaBase, [
            'localidade_id' => $localidadeLonge->id,
            'tipo' => 'agua',
            'descricao' => 'vazamento',
            'motivo' => 'cano estourado',
        ]);

        // Debug output
        dump([
            'mesma' => $scoreMesma,
            'muito_perto' => $scoreMuitoPerto,
            'perto' => $scorePerto,
            'media' => $scoreMedia,
            'longe' => $scoreLonge,
        ]);

        $this->assertTrue($scoreMesma >= $scoreMuitoPerto, "Mesma localidade deve ter score maior ou igual a muito perto");
        $this->assertTrue($scoreMuitoPerto > $scorePerto, "Muito perto deve ser maior que perto");
        $this->assertTrue($scorePerto > $scoreMedia, "Perto deve ser maior que media");
        $this->assertTrue($scoreMedia > $scoreLonge, "Media deve ser maior que longe");
    }
}
