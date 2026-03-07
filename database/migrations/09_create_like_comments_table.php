<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `like_comments` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `comment_id` int NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_like_comment` (`user_id`, `comment_id`),
        KEY `comment_id` (`comment_id`),
        CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
