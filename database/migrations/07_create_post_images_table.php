<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `post_images` (
        `id` int NOT NULL AUTO_INCREMENT,
        `post_id` int NOT NULL,
        `path` varchar(255) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `post_id` (`post_id`),
        CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
