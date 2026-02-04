<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class HomeController extends BaseController
{
    protected AuthMiddleware $auth;

    public function __construct()
    {
        $this->auth = new AuthMiddleware();
    }

    public function index(): void
    {
        // $user = $this->auth->handle(); // Uncomment when session is fully set up
        $user = ['full_name' => 'System Admin', 'role' => 'Admin']; 

        $db = Database::getInstance();
        
        // Mock stats or real queries
        $stats = [
            'total_establishments' => $db->query("SELECT COUNT(*) FROM establishments")->fetchColumn(),
            'active_inspections' => $db->query("SELECT COUNT(*) FROM inspections WHERE status IN ('Scheduled', 'In Progress')")->fetchColumn(),
            'total_violations' => $db->query("SELECT COUNT(*) FROM violations WHERE status = 'Open'")->fetchColumn(),
            'compliance_rate' => 85 // Mock or complex query
        ];

        $recent = $db->query("
            SELECT i.*, e.name as business_name, e.type as category, u.full_name as inspector_name 
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id 
            JOIN users u ON i.inspector_id = u.id 
            ORDER BY i.created_at DESC LIMIT 5
        ")->fetchAll();

        ob_start();
        $this->view('pages/dashboard', [
            'stats' => $stats,
            'recent_inspections' => $recent
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'pageTitle' => 'Dashboard - LGU H&S',
            'pageHeading' => 'Executive Overview',
            'breadcrumb' => ['Dashboard' => '/dashboard'],
            'content' => $content
        ]);
    }
}
