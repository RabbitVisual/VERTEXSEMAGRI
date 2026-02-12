<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações Customizadas do Sistema Vertex
    |--------------------------------------------------------------------------
    |
    | Este arquivo centraliza configurações mapeadas a partir de variáveis de
    | ambiente (.env) para evitar chamadas diretas a env() fora dos arquivos
    | de configuração, permitindo o uso eficiente do 'config:cache'.
    |
    */

    'pix' => [
        'base_url' => env('PIX_BASE_URL', 'https://api-pix.gerencianet.com.br'),
        'client_id' => env('PIX_CLIENT_ID', ''),
        'client_secret' => env('PIX_CLIENT_SECRET', ''),
        'certificate_path' => env('PIX_CERTIFICATE_PATH', ''),
        'webhook_secret' => env('PIX_WEBHOOK_SECRET', ''),
        'webhook_url' => env('PIX_WEBHOOK_URL'),
        'psp_name' => env('PIX_PSP_NAME', 'gerencianet'),
        'environment' => env('PIX_ENVIRONMENT', 'sandbox'),
        'qrcode_expiration' => env('PIX_QRCODE_EXPIRATION', 3600),
        'debug' => env('PIX_DEBUG', false),
        'timeout' => env('PIX_TIMEOUT', 30),
        'chave_plataforma' => env('PIX_CHAVE_PLATAFORMA', ''),
        'taxa_plataforma' => env('PIX_TAXA_PLATAFORMA', 0),
        'tarifa_fixa' => env('PIX_TARIFA_FIXA', 0.00),
        'split_ativo' => env('PIX_SPLIT_ATIVO', false),
    ],

    'recaptcha' => [
        'enabled' => env('RECAPTCHA_ENABLED', false),
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
        'min_score' => env('RECAPTCHA_MIN_SCORE', 0.5),
    ],

    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY', ''),
    ],
];
