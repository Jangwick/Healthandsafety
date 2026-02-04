<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Establishment;
use App\Middleware\AuthMiddleware;

class EstablishmentController extends BaseController
{
    private Establishment $model;
    private AuthMiddleware $auth;

    public function __construct()
    {
        $this->model = new Establishment();
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        $user = $this->auth->handle();
        $establishments = $this->model->all();

        ob_start();
        $this->view('pages/establishments/list', ['establishments' => $establishments]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Establishments - LGU H&S',
            'pageHeading' => 'Business Registry',
            'breadcrumb' => ['Establishments' => '/establishments'],
            'content' => $content
        ]);
    }

    public function show(int $id): void
    {
        $user = $this->auth->handle();
        $establishment = $this->model->find($id);
        $history = $this->model->getHistory($id);

        if (!$establishment) {
            die("Establishment not found");
        }

        ob_start();
        $this->view('pages/establishments/show', [
            'establishment' => $establishment,
            'history' => $history
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => $establishment['name'] . ' - Details',
            'pageHeading' => $establishment['name'],
            'breadcrumb' => ['Establishments' => '/establishments', 'Details' => '#'],
            'content' => $content
        ]);
    }

    public function create(): void
    {
        $user = $this->auth->handle();
        
        ob_start();
        $this->view('pages/establishments/create');
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Register Establishment',
            'pageHeading' => 'New Establishment',
            'breadcrumb' => ['Establishments' => '/establishments', 'Create' => '#'],
            'content' => $content
        ]);
    }

    public function store(): void
    {
        $user = $this->auth->handle();
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'type' => $_POST['type'] ?? '',
            'location' => $_POST['location'] ?? '',
            'status' => 'Active',
            'contact_json' => json_encode([
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'owner' => $_POST['owner'] ?? ''
            ])
        ];

        $db = \App\Database::getInstance();
        $stmt = $db->prepare("INSERT INTO establishments (name, type, location, status, contact_json, gps_coordinates) 
                                   VALUES (?, ?, ?, ?, ?, ST_GeomFromText('POINT(121.0 14.0)'))");
        $stmt->execute([$data['name'], $data['type'], $data['location'], $data['status'], $data['contact_json']]);

        header('Location: /establishments');
        exit;
    }
}
