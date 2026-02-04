<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\BaseModel;
use App\Services\InspectionService;
use App\Middleware\AuthMiddleware;
use App\Database;

class InspectionController extends BaseController
{
    private InspectionService $service;
    private AuthMiddleware $auth;

    public function __construct()
    {
        $this->service = new InspectionService();
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        $user = $this->auth->handle();
        $db = Database::getInstance();
        
        $inspections = $db->query("
            SELECT i.*, e.name as business_name, u.full_name as inspector_name 
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id 
            JOIN users u ON i.inspector_id = u.id 
            ORDER BY i.scheduled_date DESC
        ")->fetchAll(\PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/inspections/list', ['inspections' => $inspections]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Inspections - LGU H&S',
            'pageHeading' => 'Inspection Management',
            'breadcrumb' => ['Inspections' => '/inspections'],
            'content' => $content
        ]);
    }

    public function create(): void
    {
        $user = $this->auth->handle();
        $this->auth->authorize($user, 5); // Inspector or above

        $db = Database::getInstance();
        $establishments = $db->query("SELECT id, business_name as name FROM establishments WHERE deleted_at IS NULL ORDER BY business_name ASC")->fetchAll();
        $templates = $db->query("SELECT id, category FROM checklist_templates")->fetchAll();
        $inspectors = $db->query("SELECT u.id, u.full_name FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name = 'Inspector' ORDER BY u.full_name ASC")->fetchAll();

        ob_start();
        $this->view('pages/inspections/create', [
            'establishments' => $establishments,
            'templates' => $templates,
            'inspectors' => $inspectors
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Schedule Inspection',
            'pageHeading' => 'New Inspection',
            'breadcrumb' => ['Inspections' => '/inspections', 'Create' => '#'],
            'content' => $content
        ]);
    }

    public function store(): void
    {
        $user = $this->auth->handle();
        
        $establishment_id = $_POST['establishment_id'] ?? null;
        $inspector_id = $_POST['inspector_id'] ?? $user['id'];
        $scheduled_date = $_POST['scheduled_date'] ?? null;
        $priority = $_POST['priority'] ?? 'Medium';
        $template_id = $_POST['template_id'] ?? null;

        if (!$establishment_id || !$scheduled_date || !$template_id) {
            header('Location: /inspections/create?error=Missing required fields');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare(
            "INSERT INTO inspections (establishment_id, inspector_id, template_id, scheduled_date, status, priority) 
             VALUES (?, ?, ?, ?, 'Scheduled', ?)"
        );
        $stmt->execute([$establishment_id, $inspector_id, $template_id, $scheduled_date, $priority]);

        header('Location: /inspections?success=Inspection scheduled successfully');
        exit;
    }

    public function conduct(): void
    {
        $user = $this->auth->handle();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /inspections');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT i.*, e.name as business_name, t.category as template_name, t.items_json
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id
            JOIN checklist_templates t ON i.template_id = t.id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        $inspection = $stmt->fetch();

        if (!$inspection) {
            header('Location: /inspections?error=Inspection not found');
            exit;
        }

        // Checklist items are stored in JSON within the template
        $items = json_decode($inspection['items_json'] ?? '[]', true);

        ob_start();
        $this->view('pages/inspections/conduct', [
            'inspection' => $inspection,
            'items' => $items
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Conduct Audit',
            'pageHeading' => 'Safety Audit: ' . $inspection['business_name'],
            'breadcrumb' => ['Inspections' => '/inspections', 'Conduct' => '#'],
            'content' => $content
        ]);
    }

    public function show(): void
    {
        $this->auth->handle();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /inspections');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT i.*, e.name as business_name, e.location, t.category as template_name, u.full_name as inspector_name
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id
            JOIN checklist_templates t ON i.template_id = t.id
            JOIN users u ON i.inspector_id = u.id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        $inspection = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inspection) {
            header('Location: /inspections?error=Inspection not found');
            exit;
        }

        // Get inspection items
        $stmt = $db->prepare("SELECT * FROM inspection_items WHERE inspection_id = ?");
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/inspections/show', [
            'inspection' => $inspection,
            'results' => $results
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Inspection Result',
            'pageHeading' => 'Audit Report #' . $id,
            'breadcrumb' => ['Inspections' => '/inspections', 'Report' => '#'],
            'content' => $content
        ]);
    }

    public function process(): void
    {
        $this->auth->handle();
        
        $inspectionId = (int)($_POST['inspection_id'] ?? 0);
        $items = $_POST['items'] ?? []; // ['item_id' => 'Pass' or 'Fail']
        $remarks = $_POST['remarks'] ?? '';
        
        if ($inspectionId <= 0) {
            header('Location: /inspections?error=Invalid inspection ID');
            exit;
        }

        $totalItems = count($items);
        if ($totalItems === 0) {
            header('Location: /inspections/conduct?id=' . $inspectionId . '&error=No items provided');
            exit;
        }

        $passedItems = 0;
        foreach ($items as $result) {
            if ($result === 'Pass') {
                $passedItems++;
            }
        }
        $score = ($passedItems / $totalItems) * 100;
        $rating = $score >= 90 ? 'Excellent' : ($score >= 75 ? 'Satisfactory' : 'Needs Improvement');

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // 1. Save individual items
            $stmt = $db->prepare("INSERT INTO inspection_items (inspection_id, checklist_item_id, result) VALUES (?, ?, ?)");
            foreach ($items as $itemId => $result) {
                $stmt->execute([$inspectionId, (string)$itemId, $result]);
            }

            // 2. Update inspection record
            $stmt = $db->prepare("UPDATE inspections SET status = 'Completed', score = ?, rating = ?, remarks = ?, completed_at = NOW() WHERE id = ?");
            $stmt->execute([$score, $rating, $remarks, $inspectionId]);

            // 3. Get establishment ID
            $stmt = $db->prepare("SELECT establishment_id FROM inspections WHERE id = ?");
            $stmt->execute([$inspectionId]);
            $establishmentId = $stmt->fetchColumn();

            // 4. Auto-generate Violation if score < 75
            if ($score < 75) {
                $stmt = $db->prepare("INSERT INTO violations (inspection_id, description, fine_amount, status) VALUES (?, ?, ?, 'Pending')");
                $desc = "Inspection result: " . $rating . " (" . number_format($score, 1) . "%). Failure to meet minimum health and safety standards.";
                $stmt->execute([$inspectionId, $desc, 5000.00]);
            } 
            // 5. Auto-generate Certificate if score >= 75
            else {
                $stmt = $db->prepare("INSERT INTO certificates (establishment_id, type, certificate_number, issue_date, expiry_date) VALUES (?, ?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR))");
                $certNum = "CERT-" . date('Y') . "-" . str_pad((string)$inspectionId, 5, '0', STR_PAD_LEFT);
                $stmt->execute([$establishmentId, 'Sanitary Clearance', $certNum]);
            }

            $db->commit();
            header('Location: /inspections?success=Audit completed successfully');
        } catch (\Exception $e) {
            $db->rollBack();
            header('Location: /inspections/conduct?id=' . $inspectionId . '&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
}
