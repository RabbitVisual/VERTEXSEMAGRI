<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações PIX - API Banco Central do Brasil
    |--------------------------------------------------------------------------
    |
    | Configurações para integração com a API PIX do Banco Central do Brasil
    | através de um PSP (Prestador de Serviços de Pagamento)
    |
    */

    'base_url' => env('PIX_BASE_URL', 'https://api-pix.gerencianet.com.br'),

    'client_id' => env('PIX_CLIENT_ID'),
    'client_secret' => env('PIX_CLIENT_SECRET'),

    'certificate_path' => env('PIX_CERTIFICATE_PATH', null),

    'webhook_secret' => env('PIX_WEBHOOK_SECRET', null),

    'webhook_url' => env('PIX_WEBHOOK_URL', env('APP_URL') . '/api/webhook/pix'),

    /*
    |--------------------------------------------------------------------------
    | PSP (Prestador de Serviços de Pagamento)
    |--------------------------------------------------------------------------
    |
    | Configurações específicas do PSP utilizado
    | Exemplos: Gerencianet, Mercado Pago, PagSeguro, etc.
    |
    */

    'psp' => [
        'name' => env('PIX_PSP_NAME', 'gerencianet'),
        'environment' => env('PIX_ENVIRONMENT', 'sandbox'), // sandbox ou production
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações Adicionais
    |--------------------------------------------------------------------------
    */

    'qrcode_expiration' => env('PIX_QRCODE_EXPIRATION', 3600), // Tempo de expiração em segundos

    'debug' => env('PIX_DEBUG', false), // Habilitar logs detalhados

    'timeout' => env('PIX_TIMEOUT', 30), // Timeout para requisições em segundos

    /*
    |--------------------------------------------------------------------------
    | Configurações de Split (Plataforma)
    |--------------------------------------------------------------------------
    */
    'chave_plataforma' => env('PIX_CHAVE_PLATAFORMA'),
    'taxa_plataforma' => env('PIX_TAXA_PLATAFORMA', 0),
    'tarifa_fixa' => env('PIX_TARIFA_FIXA', 0.00),
    'split_ativo' => env('PIX_SPLIT_ATIVO', false),
];
