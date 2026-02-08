-- ==============================================
-- SCRIPT SQL PARA CORRIGIR PRODUÇÃO
-- ==============================================
-- Execute após fazer o deploy do ZIP

-- 1. Adicionar coluna sem_material se não existir
ALTER TABLE `ordens_servico` 
ADD COLUMN IF NOT EXISTS `sem_material` TINYINT(1) NOT NULL DEFAULT 0 
COMMENT 'Indica se o serviço foi realizado sem uso de materiais' 
AFTER `observacoes`;

-- 2. Criar tabela ordem_servico_materiais se não existir
CREATE TABLE IF NOT EXISTS `ordem_servico_materiais` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ordem_servico_id` BIGINT UNSIGNED NOT NULL,
    `material_id` BIGINT UNSIGNED NOT NULL,
    `quantidade` DECIMAL(10, 2) NOT NULL DEFAULT 0,
    `valor_unitario` DECIMAL(10, 2) NULL DEFAULT NULL,
    `observacoes` TEXT NULL,
    `funcionario_id` BIGINT UNSIGNED NULL DEFAULT NULL COMMENT 'Funcionário que registrou o material',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `osm_ordem_servico_id_idx` (`ordem_servico_id`),
    INDEX `osm_material_id_idx` (`material_id`),
    INDEX `osm_funcionario_id_idx` (`funcionario_id`),
    UNIQUE INDEX `osm_unique_material_ordem` (`ordem_servico_id`, `material_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 3. Criar tabela offline_sync_logs se não existir
CREATE TABLE IF NOT EXISTS `offline_sync_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(36) NOT NULL COMMENT 'UUID v4 único da ação',
    `device_id` VARCHAR(100) NOT NULL COMMENT 'ID único do dispositivo',
    `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'ID do usuário autenticado',
    `action_type` VARCHAR(50) NOT NULL COMMENT 'Tipo da ação (iniciar, concluir, material, foto)',
    `entity_type` VARCHAR(50) NOT NULL COMMENT 'Tipo da entidade (ordem_servico, material, etc)',
    `entity_id` BIGINT UNSIGNED NULL COMMENT 'ID da entidade afetada',
    `payload_hash` VARCHAR(64) NOT NULL COMMENT 'Hash SHA-256 do payload para verificação',
    `payload` JSON NULL COMMENT 'Dados originais da requisição',
    `result` JSON NULL COMMENT 'Resultado do processamento',
    `status` ENUM('pending', 'processed', 'failed', 'duplicate') NOT NULL DEFAULT 'pending',
    `processed_at` TIMESTAMP NULL DEFAULT NULL,
    `error_message` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `osl_uuid_unique` (`uuid`),
    INDEX `osl_device_id_idx` (`device_id`),
    INDEX `osl_user_id_idx` (`user_id`),
    INDEX `osl_action_type_idx` (`action_type`),
    INDEX `osl_status_idx` (`status`),
    INDEX `osl_created_at_idx` (`created_at`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ==============================================
-- CONFIRMAR SUCESSO
-- ==============================================
SELECT 'Script executado com sucesso!' AS resultado;

