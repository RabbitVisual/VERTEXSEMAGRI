-- ============================================
-- SEMAGRI - Tabela de Materiais por Ordem de Serviço
-- ============================================
-- Esta tabela vincula materiais às ordens de serviço
-- Permite controle de estoque e custos por OS
-- 
-- Execute este SQL no MySQL/MariaDB ou rode a migration:
-- php artisan migrate
-- ============================================

CREATE TABLE IF NOT EXISTS `ordem_servico_materiais` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  
  -- Ordem de Serviço
  `ordem_servico_id` bigint UNSIGNED NOT NULL,
  
  -- Material
  `material_id` bigint UNSIGNED NOT NULL,
  
  -- Quantidade utilizada
  `quantidade` decimal(10,2) NOT NULL DEFAULT '0.00',
  
  -- Valor unitário no momento do uso (histórico de preço)
  `valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`),
  KEY `ordem_servico_materiais_os_mat_index` (`ordem_servico_id`, `material_id`),
  KEY `ordem_servico_materiais_material_id_foreign` (`material_id`),
  
  CONSTRAINT `ordem_servico_materiais_ordem_servico_id_foreign` 
    FOREIGN KEY (`ordem_servico_id`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ordem_servico_materiais_material_id_foreign` 
    FOREIGN KEY (`material_id`) REFERENCES `materiais` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Comentário descritivo
-- ============================================
ALTER TABLE `ordem_servico_materiais` 
COMMENT = 'Materiais utilizados em cada ordem de serviço. Permite rastreamento de consumo e custos.';

