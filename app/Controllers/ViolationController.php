<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class ViolationController extends BaseController
{
    private PDO $db;
    private AuthMiddleware $auth;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->query("
            SELECT v.*, e.name as establishment_name, i.scheduled_date as inspection_date 
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
            ORDER BY v.created_at DESC
        ");
        $violations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/violations/list', ['violations' => $violations]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Violations - LGU H&S',
            'pageHeading' => 'Compliance Violations',
            'breadcrumb' => ['Violations' => '/violations'],
            'content' => $content
        ]);
    }

    public function show(int $id): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->prepare("
            SELECT v.*, e.name as establishment_name, e.location, i.score, u.full_name as inspector_name
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
            JOIN users u ON i.inspector_id = u.id
            WHERE v.id = ?
        ");
        $stmt->execute([$id]);
        $violation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$violation) {
            die("Violation not found");
        }

        ob_start();
        $this->view('pages/violations/show', ['violation' => $violation]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Violation Details',
            'pageHeading' => 'Violation Record #' . $id,
            'breadcrumb' => ['Violations' => '/violations', 'Details' => '#'],
            'content' => $content
        ]);
    }
}
