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
        $user = $this->auth->handle();

        $db = Database::getInstance();
        
        // 1. Core Statistics with simple trend calculation
        $lastMonth = date('Y-m-d', strtotime('-1 month'));
        $stats = [
            'total_establishments' => (int)$db->query("SELECT COUNT(*) FROM establishments")->fetchColumn(),
            'est_new' => (int)$db->query("SELECT COUNT(*) FROM establishments WHERE created_at >= '$lastMonth'")->fetchColumn(),
            
            'active_inspections' => (int)$db->query("SELECT COUNT(*) FROM inspections WHERE status IN ('Scheduled', 'In Progress')")->fetchColumn(),
            'total_violations' => (int)$db->query("SELECT COUNT(*) FROM violations WHERE status = 'Pending'")->fetchColumn(),
            'compliance_rate' => $db->query("SELECT IFNULL(ROUND(AVG(score), 1), 0) FROM inspections WHERE status = 'Completed'")->fetchColumn(),
            
            // Revenue / Fines
            'total_fines' => $db->query("SELECT IFNULL(SUM(fine_amount), 0) FROM violations WHERE status = 'Paid'")->fetchColumn(),
            'pending_fines' => $db->query("SELECT IFNULL(SUM(fine_amount), 0) FROM violations WHERE status != 'Paid'")->fetchColumn(),
        ];

        // 2. Calculated Trends (Simple Mock percentages if historical data is thin, but structured for UI)
        $stats['est_trend'] = $stats['total_establishments'] > 0 ? round(($stats['est_new'] / $stats['total_establishments']) * 100, 1) : 0;
        
        // 3. Recent Inspection Activity
        $recent = $db->query("
            SELECT i.*, e.name as business_name, e.type as category, u.full_name as inspector_name 
            FROM inspections i 
            JOIN establishments e ON i.establishment_id = e.id 
            JOIN users u ON i.inspector_id = u.id 
            ORDER BY i.scheduled_date DESC LIMIT 6
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 4. Critical Alerts (Violations with high fines or overdue)
        $alerts = $db->query("
            SELECT v.*, e.name as business_name
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
            WHERE v.status = 'Pending' AND v.fine_amount >= 5000
            ORDER BY v.created_at DESC LIMIT 3
        ")->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/dashboard', [
            'stats' => $stats,
            'recent_inspections' => $recent,
            'alerts' => $alerts
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
