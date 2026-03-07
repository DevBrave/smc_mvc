<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `like_posts` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `post_id` int NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_like_post` (`user_id`, `post_id`),
        KEY `post_id` (`post_id`),
        CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
