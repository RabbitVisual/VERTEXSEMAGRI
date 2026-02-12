<?php

namespace App\Services\Admin;

use App\Models\AuditLog;
use App\Models\SystemConfig;

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
            if (! isset($grouped[$config->group])) {
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

        $config->value = match ($config->type) {
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
                'value' => config('vertex.pix.base_url', 'https://api-pix.gerencianet.com.br'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'URL base da API do PSP',
            ],
            'pix.client_id' => [
                'value' => config('vertex.pix.client_id', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Client ID OAuth2 do PSP',
            ],
            'pix.client_secret' => [
                'value' => config('vertex.pix.client_secret', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Client Secret OAuth2 do PSP',
            ],
            'pix.certificate_path' => [
                'value' => config('vertex.pix.certificate_path', ''),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Caminho para o certificado SSL (opcional)',
            ],
            'pix.webhook_secret' => [
                'value' => config('vertex.pix.webhook_secret', ''),
                'type' => 'password',
                'group' => 'pix',
                'description' => 'Secret para validação de webhook',
            ],
            'pix.webhook_url' => [
                'value' => config('vertex.pix.webhook_url', config('app.url').'/api/webhook/pix'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'URL do webhook (configurada automaticamente)',
            ],
            'pix.psp_name' => [
                'value' => config('vertex.pix.psp_name', 'gerencianet'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Nome do PSP (gerencianet, mercadopago, pagseguro, etc)',
            ],
            'pix.environment' => [
                'value' => config('vertex.pix.environment', 'sandbox'),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Ambiente: sandbox ou production',
            ],
            'pix.qrcode_expiration' => [
                'value' => config('vertex.pix.qrcode_expiration', '3600'),
                'type' => 'integer',
                'group' => 'pix',
                'description' => 'Tempo de expiração do QR Code em segundos',
            ],
            'pix.debug' => [
                'value' => config('vertex.pix.debug', '0'),
                'type' => 'boolean',
                'group' => 'pix',
                'description' => 'Habilitar logs detalhados do PIX',
            ],
            'pix.timeout' => [
                'value' => config('vertex.pix.timeout', '30'),
                'type' => 'integer',
                'group' => 'pix',
                'description' => 'Timeout para requisições à API PIX em segundos',
            ],
            'pix.chave_plataforma' => [
                'value' => config('vertex.pix.chave_plataforma', ''),
                'type' => 'string',
                'group' => 'pix',
                'description' => 'Chave PIX da Plataforma (Centralizadora)',
            ],
            'pix.taxa_plataforma' => [
                'value' => config('vertex.pix.taxa_plataforma', '0'),
                'type' => 'text', // Usando text para permitir decimais como "2.5"
                'group' => 'pix',
                'description' => 'Taxa da Plataforma em % (ex: 5.00)',
            ],
            'pix.tarifa_fixa' => [
                'value' => config('vertex.pix.tarifa_fixa', '0.00'),
                'type' => 'text',
                'group' => 'pix',
                'description' => 'Tarifa Fixa por transação (ex: 0.99)',
            ],
            'pix.split_ativo' => [
                'value' => config('vertex.pix.split_ativo', '0'),
                'type' => 'boolean',
                'group' => 'pix',
                'description' => 'Ativar divisão automática de pagamentos',
            ],
            // Configurações reCAPTCHA v3
            'recaptcha.enabled' => [
                'value' => config('vertex.recaptcha.enabled', '0'),
                'type' => 'boolean',
                'group' => 'recaptcha',
                'description' => 'Habilitar Google reCAPTCHA v3',
            ],
            'recaptcha.site_key' => [
                'value' => config('vertex.recaptcha.site_key', ''),
                'type' => 'string',
                'group' => 'recaptcha',
                'description' => 'Site Key do Google reCAPTCHA v3',
            ],
            'recaptcha.secret_key' => [
                'value' => config('vertex.recaptcha.secret_key', ''),
                'type' => 'password',
                'group' => 'recaptcha',
                'description' => 'Secret Key do Google reCAPTCHA v3',
            ],
            'recaptcha.min_score' => [
                'value' => config('vertex.recaptcha.min_score', '0.5'),
                'type' => 'string',
                'group' => 'recaptcha',
                'description' => 'Score mínimo aceito (0.0 a 1.0). Recomendado: 0.5',
            ],
            // Configurações Google Maps
            'google_maps.api_key' => [
                'value' => config('vertex.google_maps.api_key', ''),
                'type' => 'password',
                'group' => 'integrations',
                'description' => 'Chave de API do Google Maps (Javascript API)',
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
            'pix.base_url' => config('vertex.pix.base_url', 'https://api-pix.gerencianet.com.br'),
            'pix.client_id' => config('vertex.pix.client_id', ''),
            'pix.client_secret' => config('vertex.pix.client_secret', ''),
            'pix.certificate_path' => config('vertex.pix.certificate_path', ''),
            'pix.webhook_secret' => config('vertex.pix.webhook_secret', ''),
            'pix.webhook_url' => config('vertex.pix.webhook_url', config('app.url').'/api/webhook/pix'),
            'pix.psp_name' => config('vertex.pix.psp_name', 'gerencianet'),
            'pix.environment' => config('vertex.pix.environment', 'sandbox'),
            'pix.qrcode_expiration' => config('vertex.pix.qrcode_expiration', '3600'),
            'pix.debug' => config('vertex.pix.debug') ? '1' : '0',
            'pix.timeout' => config('vertex.pix.timeout', '30'),
            'pix.chave_plataforma' => config('vertex.pix.chave_plataforma', ''),
            'pix.taxa_plataforma' => config('vertex.pix.taxa_plataforma', '0'),
            'pix.tarifa_fixa' => config('vertex.pix.tarifa_fixa', '0.00'),
            'pix.split_ativo' => config('vertex.pix.split_ativo') ? '1' : '0',
        ];

        foreach ($pixConfigs as $key => $envValue) {
            $config = SystemConfig::where('key', $key)->first();
            $defaultConfig = $this->getDefaultConfigs()[$key] ?? null;

            if (! $config) {
                SystemConfig::create([
                    'key' => $key,
                    'value' => $envValue,
                    'type' => $defaultConfig['type'] ?? 'string',
                    'group' => 'pix',
                    'description' => $defaultConfig['description'] ?? '',
                ]);
            } elseif ($config->value !== $envValue && ! empty($envValue)) {
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
            'recaptcha.enabled' => config('vertex.recaptcha.enabled') ? '1' : '0',
            'recaptcha.site_key' => config('vertex.recaptcha.site_key', ''),
            'recaptcha.secret_key' => config('vertex.recaptcha.secret_key', ''),
            'recaptcha.min_score' => config('vertex.recaptcha.min_score', '0.5'),
        ];

        foreach ($recaptchaConfigs as $key => $envValue) {
            $config = SystemConfig::where('key', $key)->first();
            $defaultConfig = $this->getDefaultConfigs()[$key] ?? null;

            if (! $config) {
                SystemConfig::create([
                    'key' => $key,
                    'value' => $envValue,
                    'type' => $defaultConfig['type'] ?? 'string',
                    'group' => 'recaptcha',
                    'description' => $defaultConfig['description'] ?? '',
                ]);
            } elseif ($config->value !== $envValue && ! empty($envValue)) {
                // Sincronizar com .env se o valor do .env não estiver vazio
                $config->value = $envValue;
                $config->save();
            }
        }
    }

    /**
     * Ensure Google Maps configs exist (sync with .env)
     */
    public function ensureGoogleMapsConfigs(): void
    {
        $mapsConfigs = [
            'google_maps.api_key' => config('vertex.google_maps.api_key', ''),
        ];

        foreach ($mapsConfigs as $key => $envValue) {
            $config = SystemConfig::where('key', $key)->first();
            $defaultConfig = $this->getDefaultConfigs()[$key] ?? null;

            if (! $config) {
                SystemConfig::create([
                    'key' => $key,
                    'value' => $envValue,
                    'type' => $defaultConfig['type'] ?? 'string',
                    'group' => 'integrations',
                    'description' => $defaultConfig['description'] ?? '',
                ]);
            } elseif ($config->value !== $envValue && ! empty($envValue)) {
                // Sincronizar com .env se o valor do .env não estiver vazio
                $config->value = $envValue;
                $config->save();
            }
        }
    }

    /**
     * Update config and sync with .env file (supports deferred sync for batch operations)
     */
    public function updateConfigWithEnvSync(string $key, $value, ?string $type = null, ?string $description = null, bool $deferSync = false): SystemConfig
    {
        $config = $this->updateConfig($key, $value, $type, $description);

        if (! $deferSync) {
            $this->syncOneToEnv($key, $config->value);
        }

        return $config;
    }

    /**
     * Update multiple configs and sync with .env in a single write operation
     */
    public function batchUpdateConfigsWithEnvSync(array $configsToUpdate): void
    {
        $envUpdates = [];

        foreach ($configsToUpdate as $key => $value) {
            $config = SystemConfig::where('key', $key)->first();

            if ($config) {
                // Se for boolean, garantir formato 0 ou 1
                $processedValue = $value;
                if ($config->type === 'boolean') {
                    $processedValue = $value ? '1' : '0';
                }

                $this->updateConfig($key, $value, $config->type, $config->description);

                // Verificar se a chave deve ir para o .env
                if (str_starts_with($key, 'pix.') ||
                    str_starts_with($key, 'recaptcha.') ||
                    str_starts_with($key, 'google_maps.')) {

                    $envKey = strtoupper(str_replace('.', '_', $key));
                    $envUpdates[$envKey] = $processedValue;
                }
            } else {
                // Caso a config não exista na DB, apenas atualiza
                $this->updateConfig($key, $value);
            }
        }

        if (! empty($envUpdates)) {
            $this->syncBatchToEnv($envUpdates);
        }
    }

    /**
     * Sync a single config to .env
     */
    protected function syncOneToEnv(string $key, string $value): void
    {
        if (str_starts_with($key, 'pix.') ||
            str_starts_with($key, 'recaptcha.') ||
            str_starts_with($key, 'google_maps.')) {

            $envKey = strtoupper(str_replace('.', '_', $key));
            $this->syncBatchToEnv([$envKey => $value]);
        }
    }

    /**
     * Sync multiple config values to .env file in one go
     */
    protected function syncBatchToEnv(array $updates): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return;
        }

        try {
            $envContent = file_get_contents($envPath);
            $modified = false;

            foreach ($updates as $envKey => $value) {
                // Escapar caracteres especiais para regex
                $escapedKey = preg_quote($envKey, '/');
                $pattern = "/^{$escapedKey}=.*/m";

                // Se o valor contém espaços ou caracteres especiais, usar aspas
                $formattedValue = $value;
                if (preg_match('/[\s#=]/', (string) $value)) {
                    $formattedValue = '"'.addslashes((string) $value).'"';
                }

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, "{$envKey}={$formattedValue}", $envContent);
                } else {
                    // Adicionar no final do arquivo
                    $envContent .= "\n{$envKey}={$formattedValue}";
                }
                $modified = true;
            }

            if ($modified) {
                file_put_contents($envPath, $envContent);
            }
        } catch (\Exception $e) {
            \Log::warning('Erro ao sincronizar lote de configurações com .env: '.$e->getMessage());
        }
    }
}
