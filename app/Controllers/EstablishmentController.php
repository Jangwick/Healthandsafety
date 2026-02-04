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
}
