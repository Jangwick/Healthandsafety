<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\EstablishmentController;
use App\Controllers\InspectionController;
use App\Controllers\AuthController;
use App\Controllers\ViolationController;
use App\Controllers\CertificateController;
use App\Controllers\UserController;
use App\Controllers\SettingsController;
use App\Controllers\ProfileController;
use App\Controllers\AnalyticsController;
use App\Controllers\AuditLogController;

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
} elseif ($requestUri === '/inspections/upload-file' && $method === 'POST') {
    (new InspectionController())->uploadFile();
} elseif ($requestUri === '/inspections/delete-file' && $method === 'POST') {
    (new InspectionController())->deleteFile();
} elseif ($requestUri === '/inspections/update-checklist' && $method === 'POST') {
    (new InspectionController())->updateChecklist();
} elseif ($requestUri === '/inspections/download-checklist') {
    (new InspectionController())->downloadChecklist();
} elseif ($requestUri === '/violations') {
    (new ViolationController())->index();
} elseif ($requestUri === '/violations/create') {
    (new ViolationController())->create();
} elseif ($requestUri === '/violations/store' && $method === 'POST') {
    (new ViolationController())->store();
} elseif ($requestUri === '/violations/edit') {
    (new ViolationController())->edit((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/violations/update' && $method === 'POST') {
    (new ViolationController())->update();
} elseif ($requestUri === '/violations/show') {
    (new ViolationController())->show((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/violations/update-status' && $method === 'POST') {
    (new ViolationController())->updateStatus();
} elseif ($requestUri === '/violations/assign-fine' && $method === 'POST') {
    (new ViolationController())->assignFine();
} elseif ($requestUri === '/violations/claim-fine' && $method === 'POST') {
    (new ViolationController())->claimFine();
} elseif ($requestUri === '/violations/delete') {
    (new ViolationController())->delete();
} elseif ($requestUri === '/violations/print') {
    (new ViolationController())->print((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/certificates') {
    (new CertificateController())->index();
} elseif ($requestUri === '/certificates/create') {
    (new CertificateController())->create();
} elseif ($requestUri === '/certificates/store' && $method === 'POST') {
    (new CertificateController())->store();
} elseif ($requestUri === '/certificates/show') {
    (new CertificateController())->show((int)($_GET['id'] ?? 0));
} elseif ($requestUri === '/certificates/revoke' && $method === 'POST') {
    (new CertificateController())->revoke();
} elseif ($requestUri === '/certificates/delete' && $method === 'POST') {
    (new CertificateController())->delete();
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
} elseif ($requestUri === '/settings') {
    (new SettingsController())->index();
} elseif ($requestUri === '/settings/update' && $method === 'POST') {
    (new SettingsController())->update();
} elseif ($requestUri === '/reports') {
    (new AnalyticsController())->index();
} elseif ($requestUri === '/reports/export') {
    (new AnalyticsController())->export();
} elseif ($requestUri === '/admin/audit-logs') {
    (new AuditLogController())->index();
} elseif ($requestUri === '/profile') {
    (new ProfileController())->index();
} elseif ($requestUri === '/profile/update' && $method === 'POST') {
    (new ProfileController())->update();
} elseif ($requestUri === '/login') {
    if ($method === 'POST') {
        (new AuthController())->login();
    } else {
        (new AuthController())->showLogin();
    }
} elseif ($requestUri === '/login/otp') {
    if ($method === 'POST') {
        (new AuthController())->verifyOtp();
    } else {
        (new AuthController())->showOtp();
    }
} elseif ($requestUri === '/logout') {
    (new AuthController())->logout();
} else {
    // Basic catch-all
    (new HomeController())->index();
}

