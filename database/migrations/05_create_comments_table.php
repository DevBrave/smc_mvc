<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `comments` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `post_id` int NOT NULL,
        `body` text NOT NULL,
        `parent_id` int DEFAULT NULL,
        `status` boolean DEFAULT 0,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `post_id` (`post_id`),
        KEY `parent_id` (`parent_id`),
        CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
        CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
