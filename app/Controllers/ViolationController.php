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
        
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';
        
        $query = "
            SELECT v.*, e.name as establishment_name, i.scheduled_date as inspection_date 
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
        ";
        
        $where = [];
        $params = [];
        
        if ($status) {
            $where[] = "v.status = ?";
            $params[] = $status;
        }
        
        if ($search) {
            $where[] = "(e.name LIKE ? OR v.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        $query .= " ORDER BY v.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $violations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get stats
        $stats = [
            'total' => $this->db->query("SELECT COUNT(*) FROM violations")->fetchColumn(),
            'pending' => $this->db->query("SELECT COUNT(*) FROM violations WHERE status = 'Pending'")->fetchColumn(),
            'paid' => $this->db->query("SELECT COUNT(*) FROM violations WHERE status = 'Paid'")->fetchColumn(),
            'resolved' => $this->db->query("SELECT COUNT(*) FROM violations WHERE status = 'Resolved'")->fetchColumn(),
            'overdue' => $this->db->query("SELECT COUNT(*) FROM violations WHERE status NOT IN ('Paid', 'Resolved') AND due_date < CURRENT_DATE")->fetchColumn(),
        ];

        ob_start();
        $this->view('pages/violations/list', [
            'violations' => $violations,
            'currentStatus' => $status,
            'currentSearch' => $search,
            'stats' => $stats
        ]);
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

        // Fetch Audit Logs
        $stmt = $this->db->prepare("
            SELECT a.*, u.full_name as user_name
            FROM audit_logs a
            LEFT JOIN users u ON a.user_id = u.id
            WHERE a.table_name = 'violations' AND a.record_id = ?
            ORDER BY a.timestamp DESC
        ");
        $stmt->execute([$id]);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/violations/show', [
            'violation' => $violation,
            'failedItems' => $failedItems,
            'logs' => $logs
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
            // Get current status for audit log
            $stmt = $this->db->prepare("SELECT status FROM violations WHERE id = ?");
            $stmt->execute([$id]);
            $currentStatus = $stmt->fetchColumn();

            $stmt = $this->db->prepare("UPDATE violations SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);

            // Create Audit Log
            $stmt = $this->db->prepare("
                INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_id'] ?? null,
                'UPDATE_STATUS',
                'violations',
                $id,
                json_encode(['old_status' => $currentStatus, 'new_status' => $status]),
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? ''
            ]);

            header('Location: /violations/show?id=' . $id . '&success=Status updated to ' . $status);
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

        // Fetch failed items for the citation
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

        $this->view('pages/violations/print', [
            'violation' => $violation,
            'failedItems' => $failedItems
        ]);
    }

    public function create(): void
    {
        $this->auth->handle();
        
        // Fetch inspections that don't have violations yet (optional logic) or all inspections
        $stmt = $this->db->prepare("
            SELECT i.id, e.name as establishment_name, i.scheduled_date 
            FROM inspections i
            JOIN establishments e ON i.establishment_id = e.id
            ORDER BY i.scheduled_date DESC
        ");
        $stmt->execute();
        $inspections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/violations/create', [
            'inspections' => $inspections
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Create Violation',
            'pageHeading' => 'Record New Violation',
            'breadcrumb' => ['Violations' => '/violations', 'Create' => '#'],
            'content' => $content
        ]);
    }

    public function store(): void
    {
        $this->auth->handle();
        
        $inspection_id = (int)($_POST['inspection_id'] ?? 0);
        $description = $_POST['description'] ?? '';
        $fine_amount = (float)($_POST['fine_amount'] ?? 0);
        $status = $_POST['status'] ?? 'Pending';
        $due_date = $_POST['due_date'] ?? null;

        if ($inspection_id > 0 && !empty($description)) {
            $stmt = $this->db->prepare("
                INSERT INTO violations (inspection_id, description, fine_amount, status, due_date)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$inspection_id, $description, $fine_amount, $status, $due_date]);
            $id = $this->db->lastInsertId();

            // Create Audit Log
            $stmt = $this->db->prepare("
                INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_id'] ?? null,
                'CREATE',
                'violations',
                $id,
                json_encode(['description' => $description, 'fine_amount' => $fine_amount, 'status' => $status]),
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? ''
            ]);

            header('Location: /violations?success=Violation recorded successfully');
        } else {
            header('Location: /violations/create?error=Please fill in all required fields');
        }
        exit;
    }

    public function edit(int $id): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->prepare("
            SELECT v.*, e.name as establishment_name
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
            WHERE v.id = ?
        ");
        $stmt->execute([$id]);
        $violation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$violation) {
            header('Location: /violations?error=Violation not found');
            exit;
        }

        ob_start();
        $this->view('pages/violations/edit', [
            'violation' => $violation
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Edit Violation',
            'pageHeading' => 'Edit Violation Record #' . $id,
            'breadcrumb' => ['Violations' => '/violations', 'Edit' => '#'],
            'content' => $content
        ]);
    }

    public function update(): void
    {
        $this->auth->handle();
        
        $id = (int)($_POST['id'] ?? 0);
        $description = $_POST['description'] ?? '';
        $fine_amount = (float)($_POST['fine_amount'] ?? 0);
        $status = $_POST['status'] ?? 'Pending';
        $due_date = $_POST['due_date'] ?? null;

        if ($id > 0 && !empty($description)) {
            // Get current for audit
            $stmt = $this->db->prepare("SELECT * FROM violations WHERE id = ?");
            $stmt->execute([$id]);
            $old = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->db->prepare("
                UPDATE violations 
                SET description = ?, fine_amount = ?, status = ?, due_date = ?
                WHERE id = ?
            ");
            $stmt->execute([$description, $fine_amount, $status, $due_date, $id]);

            // Create Audit Log
            $stmt = $this->db->prepare("
                INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_SESSION['user_id'] ?? null,
                'UPDATE',
                'violations',
                $id,
                json_encode(['old' => $old, 'new' => ['description' => $description, 'fine_amount' => $fine_amount, 'status' => $status, 'due_date' => $due_date]]),
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? ''
            ]);

            header('Location: /violations/show?id=' . $id . '&success=Violation updated successfully');
        } else {
            header('Location: /violations/edit?id=' . $id . '&error=Please fill in all required fields');
        }
        exit;
    }

    public function delete(): void
    {
        $this->auth->handle();
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            // Check if citations exist (might want to delete them too or restrict)
            $stmt = $this->db->prepare("DELETE FROM violations WHERE id = ?");
            $stmt->execute([$id]);

            header('Location: /violations?success=Violation record deleted');
        } else {
            header('Location: /violations?error=Invalid request');
        }
        exit;
    }
}
