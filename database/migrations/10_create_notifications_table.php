<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `notifications` (
        `id` int NOT NULL AUTO_INCREMENT,
        `type` varchar(255) NOT NULL,
        `data` text NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
