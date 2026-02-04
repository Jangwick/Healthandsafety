<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class CertificateController extends BaseController
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
        
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';

        $query = "
            SELECT c.*, e.name as establishment_name 
            FROM certificates c
            JOIN establishments e ON c.establishment_id = e.id
        ";

        $where = [];
        $params = [];

        if ($search) {
            $where[] = "(c.certificate_number LIKE ? OR e.name LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($status) {
            $where[] = "c.status = ?";
            $params[] = $status;
        }

        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $query .= " ORDER BY c.issue_date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get Statistics
        $stats = [
            'total' => $this->db->query("SELECT COUNT(*) FROM certificates")->fetchColumn(),
            'active' => $this->db->query("SELECT COUNT(*) FROM certificates WHERE status = 'Valid' AND expiry_date >= CURRENT_DATE")->fetchColumn(),
            'expired' => $this->db->query("SELECT COUNT(*) FROM certificates WHERE status = 'Expired' OR expiry_date < CURRENT_DATE")->fetchColumn(),
            'revoked' => $this->db->query("SELECT COUNT(*) FROM certificates WHERE status = 'Revoked'")->fetchColumn()
        ];

        ob_start();
        $this->view('pages/certificates/list', [
            'certificates' => $certificates,
            'stats' => $stats,
            'currentSearch' => $search,
            'currentStatus' => $status
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Certificates - LGU H&S',
            'pageHeading' => 'Sanitary Permits & Certificates',
            'breadcrumb' => ['Certificates' => '/certificates'],
            'content' => $content
        ]);
    }

    public function show(int $id): void
    {
        $this->auth->handle();
        
        $stmt = $this->db->prepare("
            SELECT c.*, e.name as establishment_name, e.location, e.type as establishment_type
            FROM certificates c
            JOIN establishments e ON c.establishment_id = e.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        $certificate = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$certificate) {
            die("Certificate not found");
        }

        ob_start();
        $this->view('pages/certificates/show', ['certificate' => $certificate]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Certificate View',
            'pageHeading' => 'Clearance #' . $certificate['certificate_number'],
            'breadcrumb' => ['Certificates' => '/certificates', 'View' => '#'],
            'content' => $content
        ]);
    }

    public function create(): void
    {
        $this->auth->handle();
        
        $establishments = $this->db->query("SELECT id, name FROM establishments ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/certificates/create', [
            'establishments' => $establishments
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Manual Certificate Issuance',
            'pageHeading' => 'Issue New Certificate',
            'breadcrumb' => ['Certificates' => '/certificates', 'Manual Issue' => '#'],
            'content' => $content
        ]);
    }

    public function store(): void
    {
        $this->auth->handle();
        
        $establishmentId = (int)($_POST['establishment_id'] ?? 0);
        $type = $_POST['type'] ?? 'Sanitary Clearance';
        $certNum = $_POST['certificate_number'] ?? '';
        $issueDate = $_POST['issue_date'] ?? date('Y-m-d');
        $expiryDate = $_POST['expiry_date'] ?? date('Y-m-d', strtotime('+1 year'));

        if (empty($certNum)) {
            header('Location: /certificates/create?error=Please fill in all required fields');
            exit;
        }

        // Check if certificate number already exists
        $check = $this->db->prepare("SELECT id FROM certificates WHERE certificate_number = ?");
        $check->execute([$certNum]);
        if ($check->fetch()) {
            header('Location: /certificates/create?error=Certificate number ' . htmlspecialchars($certNum) . ' already exists in the system');
            exit;
        }

        $stmt = $this->db->prepare("INSERT INTO certificates (establishment_id, type, certificate_number, issue_date, expiry_date, status) VALUES (?, ?, ?, ?, ?, 'Valid')");
        
        if ($stmt->execute([$establishmentId, $type, $certNum, $issueDate, $expiryDate])) {
            $lastId = $this->db->lastInsertId();
            // Log action
            $this->db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json) VALUES (?, ?, ?, ?, ?)")
                ->execute([
                    $_SESSION['user_id'],
                    'Manual Certificate Issuance',
                    'certificates',
                    $lastId,
                    json_encode(["certificate_number" => $certNum, "type" => $type, "action" => "Manual Issue"])
                ]);

            header('Location: /certificates?success=Certificate issued successfully');
        } else {
            header('Location: /certificates/create?error=Failed to issue certificate');
        }
        exit;
    }

    public function delete(): void
    {
        $this->auth->handle();
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: /certificates?error=Invalid certificate ID');
            exit;
        }

        // Get cert info for logging
        $stmt = $this->db->prepare("SELECT certificate_number FROM certificates WHERE id = ?");
        $stmt->execute([$id]);
        $certNum = $stmt->fetchColumn();

        $stmt = $this->db->prepare("DELETE FROM certificates WHERE id = ?");
        if ($stmt->execute([$id])) {
            // Log the action
            $this->db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json) VALUES (?, ?, ?, ?, ?)")
                ->execute([
                    $_SESSION['user_id'],
                    'Certificate Deleted',
                    'certificates',
                    $id,
                    json_encode(["action" => "Hard Delete", "certificate_number" => $certNum])
                ]);

            header('Location: /certificates?success=Certificate record deleted');
        } else {
            header('Location: /certificates?error=Failed to delete certificate');
        }
        exit;
    }

    public function revoke(): void
    {
        $this->auth->handle();
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: /certificates?error=Invalid certificate ID');
            exit;
        }

        // Get cert info for logging
        $stmt = $this->db->prepare("SELECT certificate_number FROM certificates WHERE id = ?");
        $stmt->execute([$id]);
        $certNum = $stmt->fetchColumn();

        $stmt = $this->db->prepare("UPDATE certificates SET status = 'Revoked' WHERE id = ?");
        if ($stmt->execute([$id])) {
            // Log the action
            $this->db->prepare("INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json) VALUES (?, ?, ?, ?, ?)")
                ->execute([
                    $_SESSION['user_id'],
                    'Certificate Revoked',
                    'certificates',
                    $id,
                    json_encode(["status" => "Revoked", "certificate_number" => $certNum])
                ]);

            header('Location: /certificates?success=Certificate revoked successfully');
        } else {
            header('Location: /certificates?error=Failed to revoke certificate');
        }
        exit;
    }
}
