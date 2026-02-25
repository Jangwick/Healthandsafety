<?php

declare(strict_types=1);

// Start session at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent browser back/undo navigation by disabling caching for sensitive pages
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past


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
    require_once __DIR__ . '/routes/web.php';
} elseif (str_starts_with($requestUri, '/api')) {
    require_once __DIR__ . '/routes/api.php';
} else {
    // Default to web routes for other paths
    require_once __DIR__ . '/routes/web.php';
}
