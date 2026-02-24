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
        $establishments = $db->query("SELECT id, name FROM establishments WHERE deleted_at IS NULL ORDER BY name ASC")->fetchAll();
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
        $id = (int)$db->lastInsertId();

        $this->logTransaction('SCHEDULE_INSPECTION', 'inspections', $id, [
            'establishment_id' => $establishment_id,
            'scheduled_date' => $scheduled_date,
            'priority' => $priority
        ]);

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
            SELECT i.*, e.name as business_name, e.location, t.category as template_name, t.items_json, u.full_name as inspector_name
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id
            JOIN checklist_templates t ON i.template_id = t.id
            JOIN users u ON i.inspector_id = u.id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        $inspection = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$inspection) {
            header('Location: /inspections?error=Inspection not found');
            exit;
        }

        // Get inspection items
        $stmt = $db->prepare("SELECT * FROM inspection_items WHERE inspection_id = ?");
        $stmt->execute([$id]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Decode template items for better display
        $templateItems = json_decode($inspection['items_json'] ?? '[]', true);
        $mappedResults = [];
        foreach ($results as $res) {
            // Find the text in templateItems using id
            $text = "Requirement #" . $res['checklist_item_id'];
            foreach ($templateItems as $item) {
                if ((string)$item['id'] === (string)$res['checklist_item_id']) {
                    $text = $item['text'] ?? $item['description'] ?? $text;
                    break;
                }
            }
            $res['requirement_text'] = $text;
            $mappedResults[] = $res;
        }

        ob_start();
        $this->view('pages/inspections/show', [
            'inspection' => $inspection,
            'results' => $mappedResults
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
            $stmt = $db->prepare("INSERT INTO inspection_items (inspection_id, checklist_item_id, status, photo_path) VALUES (?, ?, ?, ?)");
            foreach ($items as $itemId => $result) {
                $photoPath = null;
                
                // Handle file upload for this item
                if (isset($_FILES['photos']['name'][$itemId]) && $_FILES['photos']['error'][$itemId] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../uploads/inspections/' . $inspectionId;
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $fileExtension = pathinfo($_FILES['photos']['name'][$itemId], PATHINFO_EXTENSION);
                    $fileName = 'item_' . $itemId . '_' . time() . '.' . $fileExtension;
                    $targetPath = $uploadDir . '/' . $fileName;
                    $relativePath = '/uploads/inspections/' . $inspectionId . '/' . $fileName;
                    
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$itemId], $targetPath)) {
                        $photoPath = $relativePath;
                    }
                }
                
                $stmt->execute([$inspectionId, (string)$itemId, $result, $photoPath]);
            }

            // 2. Update inspection record
            $stmt = $db->prepare("UPDATE inspections SET status = 'Completed', score = ?, rating = ?, remarks = ?, completed_at = NOW() WHERE id = ?");
            $stmt->execute([$score, $rating, $remarks, $inspectionId]);

            $this->logTransaction('COMPLETE_INSPECTION', 'inspections', $inspectionId, [
                'score' => $score,
                'rating' => $rating,
                'passed_items' => $passedItems,
                'total_items' => $totalItems
            ]);

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
                $certType = 'Sanitary Clearance';
                $certNum = "CERT-" . date('Y') . "-" . str_pad((string)$inspectionId, 5, '0', STR_PAD_LEFT);
                $issueDate = date('Y-m-d');
                $expiryDate = date('Y-m-d', strtotime('+1 year'));

                $stmt = $db->prepare("INSERT INTO certificates (establishment_id, inspection_id, type, certificate_number, issue_date, expiry_date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$establishmentId, $inspectionId, $certType, $certNum, $issueDate, $expiryDate]);
            }

            $db->commit();
            header('Location: /inspections?success=Audit completed successfully');
        } catch (\Exception $e) {
            $db->rollBack();
            header('Location: /inspections/conduct?id=' . $inspectionId . '&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function uploadFile(): void
    {
        $user = $this->auth->handle();
        $inspectionId = (int)($_POST['inspection_id'] ?? 0);
        
        if ($inspectionId <= 0 || !isset($_FILES['file'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid request']);
            exit;
        }

        $file = $_FILES['file'];
        $uploadDir = __DIR__ . '/../../uploads/inspections/' . $inspectionId;
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . basename($file['name']);
        $filePath = $uploadDir . '/' . $fileName;
        $relativePath = '/uploads/inspections/' . $inspectionId . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $db = Database::getInstance();
            $stmt = $db->prepare("INSERT INTO inspection_files (inspection_id, file_name, file_path, file_type, file_size, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$inspectionId, $file['name'], $relativePath, $file['type'], $file['size'], $user['id']]);

            echo json_encode([
                'success' => true,
                'file' => [
                    'id' => $db->lastInsertId(),
                    'name' => htmlspecialchars($file['name']),
                    'path' => $relativePath,
                    'size' => round($file['size'] / 1024, 2) . ' KB'
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to move file']);
        }
        exit;
    }

    public function deleteFile(): void
    {
        $user = $this->auth->handle();
        $fileId = (int)($_POST['file_id'] ?? 0);

        if ($fileId <= 0) {
            echo json_encode(['success' => false, 'error' => 'Invalid request']);
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT file_path FROM inspection_files WHERE id = ?");
        $stmt->execute([$fileId]);
        $file = $stmt->fetch();

        if ($file) {
            $absolutePath = __DIR__ . '/../..' . $file['file_path'];
            if (file_exists($absolutePath)) {
                unlink($absolutePath);
            }
            $stmt = $db->prepare("DELETE FROM inspection_files WHERE id = ?");
            $stmt->execute([$fileId]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'File not found']);
        }
        exit;
    }
    
    public function updateChecklist(): void
    {
        $user = $this->auth->handle();
        $inspectionId = (int)($_POST['inspection_id'] ?? 0);
        $customChecklist = $_POST['custom_checklist'] ?? '';

        if ($inspectionId <= 0 || empty($customChecklist)) {
            echo json_encode(['success' => false, 'error' => 'Invalid request']);
            exit;
        }

        if (json_decode($customChecklist) === null) {
            echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE inspections SET custom_checklist_json = ? WHERE id = ?");
        $stmt->execute([$customChecklist, $inspectionId]);

        echo json_encode(['success' => true]);
        exit;
    }

    public function downloadChecklist(): void
    {
        $this->auth->handle();
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /inspections');
            exit;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT i.custom_checklist_json, t.items_json
            FROM inspections i 
            JOIN checklist_templates t ON i.template_id = t.id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        $inspection = $stmt->fetch();

        if (!$inspection) {
            header('Location: /inspections?error=Inspection not found');
            exit;
        }

        $itemsJson = $inspection['custom_checklist_json'] ?? $inspection['items_json'] ?? '[]';
        $items = json_decode($itemsJson, true);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="checklist_' . $id . '.csv"');

        $output = fopen('php://output', 'w');
        // Output BOM for UTF-8 compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['Requirement ID', 'Description/Requirement Task', 'Weight %', 'Inspector Status (Pass/Fail/NA)', 'Remarks and Notes']);

        if (is_array($items)) {
            foreach ($items as $item) {
                fputcsv($output, [$item['id'], $item['text'] ?? $item['description'] ?? '', $item['weight'] ?? 0, '', '']);
            }
        }

        fclose($output);
        exit;
    }
}
