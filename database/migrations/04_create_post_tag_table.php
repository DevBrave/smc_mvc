<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `post_tag` (
        `post_id` int NOT NULL,
        `tag_id` int NOT NULL,
        PRIMARY KEY (`post_id`, `tag_id`),
        KEY `tag_id` (`tag_id`),
        CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
        CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
