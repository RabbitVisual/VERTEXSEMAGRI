<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Modules\Pocos\App\Services\PixService;
use Modules\Pocos\App\Models\PagamentoPixPoco;
use Carbon\Carbon;

class PixWebhookTest extends TestCase
{
    // use RefreshDatabase; // Removed to avoid migration conflicts

    protected function setUp(): void
    {
        parent::setUp();

        // Disable foreign key constraints to allow minimal data setup
        DB::statement('PRAGMA foreign_keys=OFF;');

        // Run module migrations
        $this->artisan('migrate', ['--path' => 'Modules/Pocos/database/migrations']);
    }

    public function test_webhook_uses_correct_event_timestamp()
    {
        // Setup minimal data
        // Poco
        DB::table('pocos')->insert([
            'id' => 1,
            'codigo' => 'P123',
            'localidade_id' => 1,
            'endereco' => 'Address',
            'latitude' => 0,
            'longitude' => 0,
            'profundidade_metros' => 10,
            'status' => 'ativo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // UsuarioPoco
        DB::table('usuarios_poco')->insert([
            'id' => 1,
            'codigo' => 'U123',
            'poco_id' => 1,
            'nome' => 'User Test',
            'endereco' => 'Address',
            'codigo_acesso' => 'ABC12345',
            'data_cadastro' => '2025-01-01',
            'status' => 'ativo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // LiderComunidade
        DB::table('lideres_comunidade')->insert([
            'id' => 1,
            'nome' => 'Lider Test',
            'codigo' => 'L123',
            'cpf' => '12345678901',
            'telefone' => '1234567890',
            'email' => 'lider@test.com',
            'localidade_id' => 1,
            'status' => 'ativo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MensalidadePoco
        DB::table('mensalidades_poco')->insert([
            'id' => 1,
            'poco_id' => 1,
            'lider_id' => 1,
            'mes' => 1,
            'ano' => 2025,
            'codigo' => 'M123',
            'data_vencimento' => '2025-01-10',
            'data_criacao' => '2025-01-01',
            'valor_mensalidade' => 100.00,
            'status' => 'aberta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // PagamentoPixPoco
        $txid = 'txid_test_123';
        DB::table('pagamentos_pix_poco')->insert([
            'id' => 1,
            'txid' => $txid,
            'codigo' => 'PIX123',
            'mensalidade_id' => 1,
            'usuario_poco_id' => 1,
            'poco_id' => 1,
            'lider_id' => 1,
            'chave_pix_destino' => 'dummy_key',
            'valor' => 100.00,
            'status' => 'pendente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Prepare webhook payload
        $eventTime = '2025-05-20T14:30:00.000Z';
        $payload = [
            'pix' => [
                [
                    'txid' => $txid,
                    'e2eid' => 'E1234567890123456789012345678901',
                    'endToEndId' => 'E1234567890123456789012345678901',
                    'chave' => 'dummy_key',
                    'valor' => '100.00',
                    'horario' => $eventTime,
                    'infoPagador' => 'Test',
                ]
            ]
        ];

        // Instantiate service and process webhook
        $service = new PixService();
        $result = $service->processarWebhook($payload);

        // Assert success
        $this->assertTrue($result);

        // Fetch the updated payment
        $payment = PagamentoPixPoco::find(1);

        // Assert data_pagamento matches eventTime
        $expected = Carbon::parse($eventTime);

        // Compare timestamps
        $this->assertEquals($expected->timestamp, $payment->data_pagamento->timestamp);

        $this->assertNotEquals(now()->format('Y-m-d H:i'), $payment->data_pagamento->format('Y-m-d H:i'));
    }
}
