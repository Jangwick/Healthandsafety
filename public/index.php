<?php

declare(strict_types=1);

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    if (class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    }
} else {
    require_once __DIR__ . '/../app/Autoloader.php';
    App\Env::load(__DIR__ . '/../.env');
}

// Basic error handling
if (($_ENV['APP_DEBUG'] ?? 'false') === 'true') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}

// Start router
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Simple routing logic
if ($requestUri === '/' || $requestUri === '/index.php') {
    require_once __DIR__ . '/../routes/web.php';
} elseif (str_starts_with($requestUri, '/api')) {
    require_once __DIR__ . '/../routes/api.php';
} else {
    // Default to web routes for other paths
    require_once __DIR__ . '/../routes/web.php';
}
