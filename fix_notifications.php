<?php
$host = '127.0.0.1';
$dbname = 'health_safety_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->exec("ALTER TABLE notifications ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
    echo "Column deleted_at added to notifications.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
