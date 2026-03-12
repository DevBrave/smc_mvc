<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `posts` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `title` varchar(255) NOT NULL,
        `body` text NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
