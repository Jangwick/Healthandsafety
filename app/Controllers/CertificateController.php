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
        
        $stmt = $this->db->query("
            SELECT c.*, e.name as establishment_name 
            FROM certificates c
            JOIN establishments e ON c.establishment_id = e.id
            ORDER BY c.issue_date DESC
        ");
        $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/certificates/list', ['certificates' => $certificates]);
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
            SELECT c.*, e.name as establishment_name, e.location, e.type as biz_type
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
}
