<?php

declare(strict_types=1);

use App\Controllers\HomeController;

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
        // Show login page
        require_once __DIR__ . '/../views/pages/login.php';
        break;

    case '/logout':
        // Handle logout
        session_start();
        session_destroy();
        header('Location: /login');
        break;

    default:
        // Handle other routes or 404
        (new HomeController())->index(); 
        break;
}
