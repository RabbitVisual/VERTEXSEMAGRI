-- ==============================================
-- ADICIONAR COLUNA sem_material NA TABELA ordens_servico
-- ==============================================
-- Esta coluna indica se o serviço foi realizado sem
-- uso de materiais do estoque (apenas reparo no local)
--
-- Executar via phpMyAdmin ou SSH:
-- mysql -u usuario -p banco < add_sem_material_column.sql
-- ==============================================

-- Verificar se a coluna já existe antes de adicionar
SET @dbname = DATABASE();
SET @tablename = 'ordens_servico';
SET @columnname = 'sem_material';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = @dbname
    AND TABLE_NAME = @tablename
    AND COLUMN_NAME = @columnname
  ) > 0,
  "SELECT 'Coluna sem_material já existe' AS resultado;",
  "ALTER TABLE `ordens_servico` ADD COLUMN `sem_material` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Indica se o serviço foi realizado sem uso de materiais' AFTER `observacoes`;"
));

PREPARE stmt FROM @preparedStatement;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ou execute diretamente (ignora se já existe):
-- ALTER TABLE `ordens_servico` ADD COLUMN IF NOT EXISTS `sem_material` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Indica se o serviço foi realizado sem uso de materiais' AFTER `observacoes`;

