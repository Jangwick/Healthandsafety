<?php
$host = '127.0.0.1';
$dbname = 'health_safety_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->exec("DROP TABLE IF EXISTS notifications");
    echo "Table notifications dropped.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
