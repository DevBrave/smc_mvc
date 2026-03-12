<?php


use Core\App;
use Core\Database;

const BASE_PATH = __DIR__ . '/../';

require(BASE_PATH . '/vendor/autoload.php');  // autoload with composer

require(BASE_PATH . '/helpers/functions.php');

// Bootstrap the application (this sets up the container and DB connection)
require base_path('bootstrap.php');



$db = App::resolve(Database::class);

echo "Starting Migration and Seeding...\n\n";

try {
    // 1. Drop all tables (Fresh Migration)
    echo "Dropping all existing tables...\n";
    $db->connection->exec('SET FOREIGN_KEY_CHECKS = 0');
    $tablesResult = $db->connection->query("SHOW TABLES");
    $tables = $tablesResult->fetchAll(\PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        $db->connection->exec("DROP TABLE IF EXISTS `$table`");
        echo "Dropped table: $table\n";
    }
    $db->connection->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "All tables dropped successfully.\n\n";

    // 2. Run Migrations
    echo "Running Migrations...\n";
    $migrationsPath = __DIR__ . '/migrations';
    $files = scandir($migrationsPath);

    // Sort alphabetically to ensure correct order
    sort($files);

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            echo "Migrating: $file\n";
            require $migrationsPath . '/' . $file;
            echo "Migrated:  $file\n";
        }
    }
    echo "Migrations complete.\n\n";

    // 3. Run Seeders
    echo "Running Seeders...\n";
    $seedersPath = __DIR__ . '/seeders';
    $seederFiles = scandir($seedersPath);

    sort($seederFiles);

    foreach ($seederFiles as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            echo "Seeding: $file\n";
            require $seedersPath . '/' . $file;
            echo "Seeded:  $file\n";
        }
    }
    echo "Seeding complete.\n\n";

    echo "Migration and Seeding Finished Successfully!\n";
} catch (\Exception $e) {
    echo "Error During Migration: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    exit(1);
}
