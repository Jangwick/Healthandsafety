<?php
$host = '127.0.0.1';
$db   = 'LGU';
$user = 'lgu_admin';
$pass = 'YsqnXk6q#145';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $stmt = $pdo->query("DESCRIBE users");
     $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
     echo "Columns in 'users' table:\n";
     print_r($columns);
     
     if (in_array('otp_code', $columns)) {
         echo "\nSUCCESS: 'otp_code' exists!";
     } else {
         echo "\nFAILURE: 'otp_code' NOT FOUND!";
     }
} catch (\PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
}
