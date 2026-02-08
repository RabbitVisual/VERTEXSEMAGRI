-- ============================================
-- SEMAGRI - Tabela de Logs de Sincronização Offline
-- ============================================
-- Esta tabela garante:
-- 1. Idempotência: Cada ação tem UUID único, evitando duplicatas
-- 2. Auditoria: Registra quem, quando, o quê foi sincronizado
-- 3. Integridade: Hash do payload para verificação
-- 
-- Execute este SQL no MySQL/MariaDB ou rode a migration:
-- php artisan migrate
-- ============================================

CREATE TABLE IF NOT EXISTS `offline_sync_logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  
  -- UUID único gerado pelo cliente - evita duplicatas
  `client_uuid` char(36) NOT NULL,
  
  -- Funcionário que realizou a ação
  `user_id` bigint UNSIGNED NOT NULL,
  
  -- Tipo da ação: iniciar_ordem, concluir_ordem, adicionar_material, etc.
  `action_type` varchar(50) NOT NULL,
  
  -- Modelo/Entidade afetada
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  
  -- Dados da ação (JSON)
  `payload` json DEFAULT NULL,
  
  -- Hash SHA-256 do payload para verificação de integridade
  `payload_hash` varchar(64) DEFAULT NULL,
  
  -- Resultado da sincronização
  `status` enum('pending','processing','completed','failed','duplicate') NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `result_data` json DEFAULT NULL,
  
  -- Timestamps de controle
  `client_timestamp` timestamp NULL DEFAULT NULL COMMENT 'Quando a ação foi feita offline',
  `synced_at` timestamp NULL DEFAULT NULL COMMENT 'Quando foi recebido pelo servidor',
  `processed_at` timestamp NULL DEFAULT NULL COMMENT 'Quando foi processado',
  
  -- Informações do dispositivo
  `device_id` varchar(100) DEFAULT NULL,
  `device_info` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `offline_sync_logs_client_uuid_unique` (`client_uuid`),
  KEY `offline_sync_logs_user_id_action_type_index` (`user_id`, `action_type`),
  KEY `offline_sync_logs_status_created_at_index` (`status`, `created_at`),
  KEY `offline_sync_logs_model_type_model_id_index` (`model_type`, `model_id`),
  
  CONSTRAINT `offline_sync_logs_user_id_foreign` 
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Índice adicional para busca por dispositivo
-- ============================================
CREATE INDEX IF NOT EXISTS `offline_sync_logs_device_id_index` 
ON `offline_sync_logs` (`device_id`);

-- ============================================
-- Comentários descritivos
-- ============================================
ALTER TABLE `offline_sync_logs` 
COMMENT = 'Tabela de auditoria para sincronização offline do módulo Campo. Garante idempotência (não duplica ações) e rastreabilidade completa.';

