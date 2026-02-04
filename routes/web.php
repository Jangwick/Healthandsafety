<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\EstablishmentController;
use App\Controllers\InspectionController;
use App\Controllers\AuthController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/':
    case '/dashboard':
        (new HomeController())->index();
        break;
        
    case '/establishments':
        (new EstablishmentController())->index();
        break;

    case '/establishments/show':
        (new EstablishmentController())->show((int)($_GET['id'] ?? 0));
        break;

    case '/inspections':
        (new InspectionController())->index();
        break;

    case '/inspections/create':
        (new InspectionController())->create();
        break;
        
    case '/login':
        if ($method === 'POST') {
            (new AuthController())->login();
        } else {
            (new AuthController())->showLogin();
        }
        break;

    case '/logout':
        (new AuthController())->logout();
        break;

    default:
        // Handle other routes or 404
        (new HomeController())->index(); 
        break;
}
