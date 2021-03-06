<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536233370CmsSlot extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536233370;
    }

    public function update(Connection $connection): void
    {
        $sql = <<<SQL
            CREATE TABLE `cms_slot` (
              `id` BINARY(16) NOT NULL,
              `version_id` BINARY(16) NOT NULL,
              `cms_block_id` BINARY(16) NOT NULL,
              `type` VARCHAR(255) NOT NULL,
              `slot` VARCHAR(255) NOT NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`id`, `version_id`),
              CONSTRAINT `fk.cms_slot.cms_block_id` FOREIGN KEY (`cms_block_id`)
                REFERENCES `cms_block` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

        $connection->executeQuery($sql);

        $sql = <<<SQL
            CREATE TABLE `cms_slot_translation` (
              `cms_slot_id` BINARY(16) NOT NULL,
              `cms_slot_version_id` BINARY(16) NOT NULL,
              `language_id` BINARY(16) NOT NULL,
              `config` JSON NULL,
              `attributes` JSON NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`cms_slot_id`, `cms_slot_version_id`, `language_id`),
              CONSTRAINT `json.config` CHECK(JSON_VALID(`config`)),
              CONSTRAINT `json.attributes` CHECK (JSON_VALID(`attributes`)),
              CONSTRAINT `fk.cms_slot_translation.cms_slot_id` FOREIGN KEY (`cms_slot_id`, `cms_slot_version_id`)
                REFERENCES `cms_slot` (`id`, `version_id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk.cms_slot_translation.language_id` FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

        $connection->executeQuery($sql);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}
