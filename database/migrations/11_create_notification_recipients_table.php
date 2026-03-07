<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `notification_recipients` (
        `id` int NOT NULL AUTO_INCREMENT,
        `notification_id` int NOT NULL,
        `user_id` int NOT NULL,
        `group_key` varchar(255) DEFAULT NULL,
        `read_at` timestamp NULL DEFAULT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `notification_id` (`notification_id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `notification_recipients_ibfk_1` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
        CONSTRAINT `notification_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
