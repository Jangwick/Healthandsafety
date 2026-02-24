<?php
require_once __DIR__ . '/vendor/autoload.php';
// If vendor/autoload.php doesn't exist, use manual autoloader
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/app/Autoloader.php';
    App\Env::load(__DIR__ . '/.env');
} else {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

use App\Database;

$db = Database::getInstance();
$adminId = 1;

$notifications = [
    [
        'user_id' => $adminId,
        'title' => 'System Update',
        'message' => 'System will be updated tonight at 11 PM',
        'type' => 'info',
        'icon' => 'fas fa-info-circle',
        'link' => '#'
    ],
    [
        'user_id' => $adminId,
        'title' => 'New User Registered',
        'message' => 'John Doe joined the platform',
        'type' => 'success',
        'icon' => 'fas fa-user-plus',
        'link' => '/users'
    ],
    [
        'user_id' => $adminId,
        'title' => 'Storage Warning',
        'message' => 'Disk space is running low (85% used)',
        'type' => 'warning',
        'icon' => 'fas fa-exclamation-triangle',
        'link' => '#'
    ]
];

foreach ($notifications as $n) {
    $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message, type, icon, link) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$n['user_id'], $n['title'], $n['message'], $n['type'], $n['icon'], $n['link']]);
}

echo "Sample notifications created.\n";
