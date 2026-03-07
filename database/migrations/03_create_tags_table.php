<?php

/** @var \Core\Database $db */

$db->connection->exec("
    CREATE TABLE `tags` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `slug` varchar(255) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `slug` (`slug`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
