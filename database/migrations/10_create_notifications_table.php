<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `notifications` (
        `id` int NOT NULL AUTO_INCREMENT,
        `type` varchar(255) NOT NULL,
        `actor_id` int NOT NULL,
        `last_actor_id` int NULL,
        `object_type` varchar(255) NOT NULL,
        `object_id` int NOT NULL,
        `context_type` varchar(255) NULL,
        `context_id` int NULL,
        `group_key` varchar(255) NULL,
        `cnt` int DEFAULT 1,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
