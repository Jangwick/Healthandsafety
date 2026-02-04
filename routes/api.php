<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\EstablishmentController;
use App\Controllers\InspectionController;

header('Content-Type: application/json');

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api', '', $requestUri);

// Define API routes
switch ($path) {
    case '/login':
        (new AuthController())->login();
        break;
        
    case '/establishments':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            (new EstablishmentController())->index();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new EstablishmentController())->store();
        }
        break;

    case '/inspections':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            (new InspectionController())->index();
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
