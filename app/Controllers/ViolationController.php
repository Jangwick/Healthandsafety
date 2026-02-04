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

        // Fetch failed items from the inspection
        $stmt = $this->db->prepare("
            SELECT ii.*, t.items_json
            FROM inspection_items ii
            JOIN inspections i ON ii.inspection_id = i.id
            JOIN checklist_templates t ON i.template_id = t.id
            WHERE ii.inspection_id = ? AND ii.status = 'Fail'
        ");
        $stmt->execute([$violation['inspection_id']]);
        $failedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Map failed items to their requirement text
        if (!empty($failedItems)) {
            $templateItems = json_decode($failedItems[0]['items_json'] ?? '[]', true);
            foreach ($failedItems as &$item) {
                $text = "Requirement #" . $item['checklist_item_id'];
                foreach ($templateItems as $tItem) {
                    if ((string)$tItem['id'] === (string)$item['checklist_item_id']) {
                        $text = $tItem['text'] ?? $tItem['description'] ?? $text;
                        break;
                    }
                }
                $item['requirement_text'] = $text;
            }
        }

        ob_start();
        $this->view('pages/violations/show', [
            'violation' => $violation,
            'failedItems' => $failedItems
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Violation Details',
            'pageHeading' => 'Violation Record #' . $id,
            'breadcrumb' => ['Violations' => '/violations', 'Details' => '#'],
            'content' => $content
        ]);
    }

    public function updateStatus(): void
    {
        $this->auth->handle();
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($id > 0 && in_array($status, ['Pending', 'Paid', 'Resolved', 'In Progress'])) {
            $stmt = $this->db->prepare("UPDATE violations SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            header('Location: /violations/show?id=' . $id . '&success=Status updated');
        } else {
            header('Location: /violations?error=Invalid request');
        }
        exit;
    }

    public function print(int $id): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->prepare("
            SELECT v.*, e.name as establishment_name, e.location, i.score, u.full_name as inspector_name, i.scheduled_date
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

        $this->view('pages/violations/print', ['violation' => $violation]);
    }
}
