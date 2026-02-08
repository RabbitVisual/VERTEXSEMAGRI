<?php

namespace App\Services\Admin;

use App\Models\SystemConfig;
use App\Models\AuditLog;

class SystemConfigService
{
    /**
     * Get all configs grouped by group
     */
    public function getConfigsGrouped(): array
    {
        $configs = SystemConfig::all();
        $grouped = [];

        foreach ($configs as $config) {
            if (!isset($grouped[$config->group])) {
                $grouped[$config->group] = [];
            }

            $grouped[$config->group][] = $config;
        }

        return $grouped;
    }

    /**
     * Get configs by group
     */
    public function getConfigsByGroup(string $group)
    {
        return SystemConfig::where('group', $group)->get();
    }

    /**
     * Update config value
     */
    public function updateConfig(string $key, $value, ?string $type = null, ?string $description = null): SystemConfig
    {
        $config = SystemConfig::firstOrNew(['key' => $key]);
        $oldValue = $config->value;

        if ($type) {
            $config->type = $type;
        }

        if ($description) {
            $config->description = $description;
        }

        $config->value = match($config->type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            'integer' => (string) $value,
            default => (string) $value,
        };

        $config->save();

        AuditLog::log(
            'config.update',
            SystemConfig::class,
            $config->id,
            'admin',
            "Configuração {$key} atualizada",
            ['value' => $oldValue],
            ['value' => $config->value]
        );

        return $config;
    }

    /**
     * Bulk update configs
     */
    public function bulkUpdateConfigs(array $configs): void
    {
        foreach ($configs as $key => $value) {
            $this->updateConfig($key, $value);
        }
    }

    /**
     * Get default configs
     */
    public function getDefaultConfigs(): array
    {
        return [
            'system.name' => [
                'value' => 'VERTEXSEMAGRI',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Nome do sistema',
            ],
            'system.version' => [
                'value' => '1.0.0',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Versão do sistema',
            ],
            'email.from_address' => [
                'value' => 'noreply@vertexsemagri.com',
                'type' => 'string',
                'group' => 'email',
                'description' => 'Endereço de email remetente',
            ],
            'email.from_name' => [
                'value' => 'VERTEXSEMAGRI',
                'type' => 'string',
                'group' => 'email',
                'description' => 'Nome do remetente',
            ],
            'backup.enabled' => [
                'value' => '1',
                'type' => 'boolean',
                'group' => 'backup',
                'description' => 'Habilitar backups automáticos',
            ],
            'backup.frequency' => [
                'value' => 'daily',
                'type' => 'string',
                'group' => 'backup',
                'description' => 'Frequência dos backups (daily, weekly, monthly)',
            ],
            'security.login_attempts' => [
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Número máximo de tentativas de login',
            ],
            'security.session_timeout' => [
                'value' => '120',
                'type' => 'integer',
                'group' => 'security',
                'description' => 'Timeout de sessão em minutos',
            ],
            // Configurações PIX
            'pix.base_url' => [
                'value' => env('PIX_BASE_URL', 'https://api-pix.gerencianet.com.br'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'URL base da API do PSP',
            ],
            'pix.client_id' => [
                'value' => env('PIX_CLIENT_ID', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Client ID OAuth2 do PSP',
            ],
            'pix.client_secret' => [
                'value' => env('PIX_CLIENT_SECRET', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Client Secret OAuth2 do PSP',
            ],
            'pix.certificate_path' => [
                'value' => env('PIX_CERTIFICATE_PATH', ''),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Caminho para o certificado SSL (opcional)',
            ],
            'pix.webhook_secret' => [
                'value' => env('PIX_WEBHOOK_SECRET', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Secret para validação de webhook',
            ],
            'pix.webhook_url' => [
                'value' => env('PIX_WEBHOOK_URL', env('APP_URL') . '/api/webhook/pix'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'URL do webhook (configurada automaticamente)',
            ],
            'pix.psp_name' => [
                'value' => env('PIX_PSP_NAME', 'gerencianet'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Nome do PSP (gerencianet, mercadopago, pagseguro, etc)',
            ],
            'pix.environment' => [
                'value' => env('PIX_ENVIRONMENT', 'sandbox'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Ambiente: sandbox ou production',
            ],
            'pix.qrcode_expiration' => [
                'value' => env('PIX_QRCODE_EXPIRATION', '3600'),
                'type' => 'integer',
                'group' => 'pix',
                'description' => 'Tempo de expiração do QR Code em segundos',
            ],
            'pix.debug' => [
                'value' => env('PIX_DEBUG', '0'),
                'type' => 'boolean',
                'group' => 'pix',
                'description' => 'Habilitar logs detalhados do PIX',
            ],
            'pix.timeout' => [
                'value' => env('PIX_TIMEOUT', '30'),
                'type' => 'integer',
                'group' => 'pix',
                'description' => 'Timeout para requisições à API PIX em segundos',
            ],
            'pix.chave_plataforma' => [
                'value' => env('PIX_CHAVE_PLATAFORMA', ''),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Chave PIX da Plataforma (Centralizadora)',
            ],
            'pix.taxa_plataforma' => [
                'value' => env('PIX_TAXA_PLATAFORMA', '0'),
                'type' => 'text', // Usando text para permitir decimais como "2.5"
                'group' => 'pix',
                'description' => 'Taxa da Plataforma em % (ex: 5.00)',
            ],
            'pix.tarifa_fixa' => [
                'value' => env('PIX_TARIFA_FIXA', '0.00'),
                'type' => 'text',
                'group' => 'pix',
                'description' => 'Tarifa Fixa por transação (ex: 0.99)',
            ],
            'pix.split_ativo' => [
                'value' => env('PIX_SPLIT_ATIVO', '0'),
                'type' => 'boolean',
                'group' => 'pix',
                'description' => 'Ativar divisão automática de pagamentos',
            ],
            // Configurações reCAPTCHA v3
            'recaptcha.enabled' => [
                'value' => env('RECAPTCHA_ENABLED', '0'),
                'type' => 'boolean',
                'group' => 'recaptcha',
                'description' => 'Habilitar Google reCAPTCHA v3',
            ],
            'recaptcha.site_key' => [
                'value' => env('RECAPTCHA_SITE_KEY', ''),
                'type' => 'string',
                'group' => 'recaptcha',
                'description' => 'Site Key do Google reCAPTCHA v3',
            ],
            'recaptcha.secret_key' => [
                'value' => env('RECAPTCHA_SECRET_KEY', ''),
                'type' => 'password',
                'group' => 'recaptcha',
                'description' => 'Secret Key do Google reCAPTCHA v3',
            ],
            'recaptcha.min_score' => [
                'value' => env('RECAPTCHA_MIN_SCORE', '0.5'),
                'type' => 'string',
                'group' => 'recaptcha',
                'description' => 'Score mínimo aceito (0.0 a 1.0). Recomendado: 0.5',
            ],
        ];
    }

    /**
     * Initialize default configs
     */
    public function initializeDefaultConfigs(): void
    {
        $defaults = $this->getDefaultConfigs();

        foreach ($defaults as $key => $config) {
            SystemConfig::firstOrCreate(
                ['key' => $key],
                [
                    'value' => $config['value'],
                    'type' => $config['type'],
                    'group' => $config['group'],
                    'description' => $config['description'],
                ]
            );
        }
    }

    /**
     * Ensure PIX configs exist (sync with .env)
     */
    public function ensurePixConfigs(): void
    {
        $pixConfigs = [
            'pix.base_url' => env('PIX_BASE_URL', 'https://api-pix.gerencianet.com.br'),
            'pix.client_id' => env('PIX_CLIENT_ID', ''),
            'pix.client_secret' => env('PIX_CLIENT_SECRET', ''),
            'pix.certificate_path' => env('PIX_CERTIFICATE_PATH', ''),
            'pix.webhook_secret' => env('PIX_WEBHOOK_SECRET', ''),
            'pix.webhook_url' => env('PIX_WEBHOOK_URL', env('APP_URL') . '/api/webhook/pix'),
            'pix.psp_name' => env('PIX_PSP_NAME', 'gerencianet'),
            'pix.environment' => env('PIX_ENVIRONMENT', 'sandbox'),
            'pix.qrcode_expiration' => env('PIX_QRCODE_EXPIRATION', '3600'),
            'pix.debug' => env('PIX_DEBUG', '0'),
            'pix.timeout' => env('PIX_TIMEOUT', '30'),
            'pix.chave_plataforma' => env('PIX_CHAVE_PLATAFORMA', ''),
            'pix.taxa_plataforma' => env('PIX_TAXA_PLATAFORMA', '0'),
            'pix.tarifa_fixa' => env('PIX_TARIFA_FIXA', '0.00'),
            'pix.split_ativo' => env('PIX_SPLIT_ATIVO', '0'),
        ];

        foreach ($pixConfigs as $key => $envValue) {
            $config = SystemConfig::where('key', $key)->first();
            $defaultConfig = $this->getDefaultConfigs()[$key] ?? null;

            if (!$config) {
                SystemConfig::create([
                    'key' => $key,
                    'value' => $envValue,
                    'type' => $defaultConfig['type'] ?? 'string',
                    'group' => 'pix',
                    'description' => $defaultConfig['description'] ?? '',
                ]);
            } elseif ($config->value !== $envValue && !empty($envValue)) {
                // Sincronizar com .env se o valor do .env não estiver vazio
                $config->value = $envValue;
                $config->save();
            }
        }
    }

    /**
     * Ensure reCAPTCHA configs exist (sync with .env)
     */
    public function ensureRecaptchaConfigs(): void
    {
        $recaptchaConfigs = [
            'recaptcha.enabled' => env('RECAPTCHA_ENABLED', '0'),
            'recaptcha.site_key' => env('RECAPTCHA_SITE_KEY', ''),
            'recaptcha.secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
            'recaptcha.min_score' => env('RECAPTCHA_MIN_SCORE', '0.5'),
        ];

        foreach ($recaptchaConfigs as $key => $envValue) {
            $config = SystemConfig::where('key', $key)->first();
            $defaultConfig = $this->getDefaultConfigs()[$key] ?? null;

            if (!$config) {
                SystemConfig::create([
                    'key' => $key,
                    'value' => $envValue,
                    'type' => $defaultConfig['type'] ?? 'string',
                    'group' => 'recaptcha',
                    'description' => $defaultConfig['description'] ?? '',
                ]);
            } elseif ($config->value !== $envValue && !empty($envValue)) {
                // Sincronizar com .env se o valor do .env não estiver vazio
                $config->value = $envValue;
                $config->save();
            }
        }
    }

    /**
     * Update config and sync with .env file
     */
    public function updateConfigWithEnvSync(string $key, $value, ?string $type = null, ?string $description = null): SystemConfig
    {
        $config = $this->updateConfig($key, $value, $type, $description);

        // Sincronizar com .env para configurações PIX
        if (str_starts_with($key, 'pix.')) {
            $envKey = strtoupper(str_replace('.', '_', $key));
            $this->syncToEnv($envKey, $config->value);
        }

        // Sincronizar com .env para configurações reCAPTCHA
        if (str_starts_with($key, 'recaptcha.')) {
            $envKey = strtoupper(str_replace('.', '_', $key));
            $this->syncToEnv($envKey, $config->value);
        }

        return $config;
    }

    /**
     * Sync config value to .env file
     */
    protected function syncToEnv(string $envKey, string $value): void
    {
        $envPath = base_path('.env');

        if (!file_exists($envPath)) {
            return;
        }

        try {
            $envContent = file_get_contents($envPath);

            // Escapar caracteres especiais para regex
            $escapedKey = preg_quote($envKey, '/');
            $pattern = "/^{$escapedKey}=.*/m";

            // Se o valor contém espaços ou caracteres especiais, usar aspas
            $formattedValue = $value;
            if (preg_match('/[\s#=]/', $value)) {
                $formattedValue = '"' . addslashes($value) . '"';
            }

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$envKey}={$formattedValue}", $envContent);
            } else {
                // Adicionar no final do arquivo
                $envContent .= "\n{$envKey}={$formattedValue}";
            }

            file_put_contents($envPath, $envContent);
        } catch (\Exception $e) {
            // Log erro mas não interrompe o processo
            \Log::warning("Erro ao sincronizar configuração {$envKey} com .env: " . $e->getMessage());
        }
    }
}
