<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\EstablishmentController;
use App\Controllers\InspectionController;
use App\Controllers\AuthController;
use App\Controllers\ViolationController;
use App\Controllers\CertificateController;
use App\Controllers\UserController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Simple routing logic
if ($requestUri === '/' || $requestUri === '/dashboard') {
    (new HomeController())->index();
} elseif ($requestUri === '/establishments') {
    (new EstablishmentController())->index();
} elseif ($requestUri === '/establishments/create') {
    (new EstablishmentController())->create();
} elseif ($requestUri === '/establishments/store' && $method === 'POST') {
    (new EstablishmentController())->store();
} elseif ($requestUri === '/establishments/show') {
    (new EstablishmentController())->show((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/establishments/edit') {
    (new EstablishmentController())->edit((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/establishments/update' && $method === 'POST') {
    (new EstablishmentController())->update();
} elseif ($requestUri === '/establishments/delete') {
    (new EstablishmentController())->delete();
} elseif ($requestUri === '/inspections') {
    (new InspectionController())->index();
} elseif ($requestUri === '/inspections/create') {
    (new InspectionController())->create();
} elseif ($requestUri === '/inspections/store' && $method === 'POST') {
    (new InspectionController())->store();
} elseif ($requestUri === '/inspections/conduct') {
    (new InspectionController())->conduct();
} elseif ($requestUri === '/inspections/process' && $method === 'POST') {
    (new InspectionController())->process();
} elseif ($requestUri === '/inspections/show') {
    (new InspectionController())->show();
} elseif ($requestUri === '/violations') {
    (new ViolationController())->index();
} elseif ($requestUri === '/violations/show') {
    (new ViolationController())->show((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/certificates') {
    (new CertificateController())->index();
} elseif ($requestUri === '/certificates/show') {
    (new CertificateController())->show((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/users') {
    (new UserController())->index();
} elseif ($requestUri === '/users/create') {
    (new UserController())->create();
} elseif ($requestUri === '/users/store' && $method === 'POST') {
    (new UserController())->store();
} elseif ($requestUri === '/users/edit') {
    (new UserController())->edit();
} elseif ($requestUri === '/users/update' && $method === 'POST') {
    (new UserController())->update();
} elseif ($requestUri === '/users/delete') {
    (new UserController())->delete();
} elseif ($requestUri === '/login') {
    if ($method === 'POST') {
        (new AuthController())->login();
    } else {
        (new AuthController())->showLogin();
    }
} elseif ($requestUri === '/logout') {
    (new AuthController())->logout();
} else {
    // Basic catch-all
    (new HomeController())->index();
}

