<?php declare(strict_types=1);

namespace Shopware\Core\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1536233120Media extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1536233120;
    }

    public function update(Connection $connection): void
    {
        $connection->executeQuery('
            CREATE TABLE `media` (
              `id` BINARY(16) NOT NULL,
              `user_id` BINARY(16) NULL,
              `media_folder_id` BINARY(16) NULL,
              `mime_type` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
              `file_extension` VARCHAR(50) COLLATE utf8mb4_unicode_ci NULL,
              `file_size` INT(10) unsigned NULL,
              `meta_data` LONGBLOB NULL,
              `file_name` LONGTEXT COLLATE utf8mb4_unicode_ci NULL,
              `media_type` LONGBLOB NULL,
              `uploaded_at` DATETIME(3) NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
               PRIMARY KEY (`id`),
               CONSTRAINT `fk.media.user_id` FOREIGN KEY (`user_id`)
                 REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
               CONSTRAINT `fk.media.media_folder_id` FOREIGN KEY (`media_folder_id`)
                 REFERENCES `media_folder` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $connection->executeQuery('
            CREATE TABLE `media_translation` (
              `media_id` BINARY(16) NOT NULL,
              `language_id` BINARY(16) NOT NULL,
              `alt` VARCHAR(255) COLLATE utf8mb4_unicode_ci,
              `title` VARCHAR(255) COLLATE  utf8mb4_unicode_ci NULL,
              `attributes` JSON NULL,
              `created_at` DATETIME(3) NOT NULL,
              `updated_at` DATETIME(3) NULL,
              PRIMARY KEY (`media_id`, `language_id`),
              CONSTRAINT `json.attributes` CHECK (JSON_VALID(`attributes`)),
              CONSTRAINT `fk.media_translation.language_id` FOREIGN KEY (`language_id`)
                REFERENCES `language` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk.media_translation.media_id` FOREIGN KEY (`media_id`)
                REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
