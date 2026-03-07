<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `follows` (
        `id` int NOT NULL AUTO_INCREMENT,
        `follower_id` int NOT NULL,
        `following_id` int NOT NULL,
        `status` varchar(50) DEFAULT 'unfollow',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_follow` (`follower_id`, `following_id`),
        KEY `following_id` (`following_id`),
        CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
