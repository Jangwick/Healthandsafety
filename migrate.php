<?php

declare(strict_types=1);

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
} else {
    require_once __DIR__ . '/app/Autoloader.php';
    App\Env::load(__DIR__ . '/.env');
}

// Create database if not exists
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';
$dbname = $_ENV['DB_DATABASE'] ?? 'health_safety_db';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "Database `$dbname` ensured.\n";
} catch (PDOException $e) {
    die("Error creating database: " . $e->getMessage() . "\n");
}

use Database\Migration;
use Database\Seeder;

echo "Starting Migrations...\n";
$migrator = new Migration();
$migrator->migrate();

echo "Starting Seeding...\n";
$seeder = new Seeder();
$seeder->seed();

echo "Database preparation complete.\n";
