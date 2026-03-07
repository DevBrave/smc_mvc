<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `users` (
        `id` int NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `first_name` varchar(255) NOT NULL,
        `last_name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `avatar` varchar(255) DEFAULT NULL,
        `password` varchar(255) NOT NULL,
        `bio` text DEFAULT NULL,
        `role` varchar(50) DEFAULT 'user',
        `status` varchar(50) DEFAULT 'active',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `username` (`username`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
