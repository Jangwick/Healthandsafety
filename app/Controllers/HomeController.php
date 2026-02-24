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
        
        // 1. Core Statistics
        $now = date('Y-m-d H:i:s');
        $lastMonth = date('Y-m-d H:i:s', strtotime('-1 month'));
        $prevMonth = date('Y-m-d H:i:s', strtotime('-2 months'));
        
        $lastWeek = date('Y-m-d H:i:s', strtotime('-7 days'));
        $prevWeek = date('Y-m-d H:i:s', strtotime('-14 days'));

        // Establishments data
        $totalEst = (int)$db->query("SELECT COUNT(*) FROM establishments")->fetchColumn();
        $newEstMonth = (int)$db->query("SELECT COUNT(*) FROM establishments WHERE created_at >= '$lastMonth'")->fetchColumn();
        $prevNewEstMonth = (int)$db->query("SELECT COUNT(*) FROM establishments WHERE created_at >= '$prevMonth' AND created_at < '$lastMonth'")->fetchColumn();
        
        $estTrend = 0;
        if ($prevNewEstMonth > 0) {
            $estTrend = round((($newEstMonth - $prevNewEstMonth) / $prevNewEstMonth) * 100, 1);
        } elseif ($newEstMonth > 0) {
            $estTrend = 100.0;
        }

        // Active Inspections
        $activeInspections = (int)$db->query("SELECT COUNT(*) FROM inspections WHERE status IN ('Scheduled', 'In Progress')")->fetchColumn();
        $inspectionsThisWeek = (int)$db->query("SELECT COUNT(*) FROM inspections WHERE scheduled_date >= '$lastWeek'")->fetchColumn();
        $inspectionsPrevWeek = (int)$db->query("SELECT COUNT(*) FROM inspections WHERE scheduled_date >= '$prevWeek' AND scheduled_date < '$lastWeek'")->fetchColumn();
        $inspTrend = 0;
        if ($inspectionsPrevWeek > 0) {
            $inspTrend = round((($inspectionsThisWeek - $inspectionsPrevWeek) / $inspectionsPrevWeek) * 100, 1);
        } elseif ($inspectionsThisWeek > 0) {
            $inspTrend = 5.0; // Minimal default for activity
        }

        // Pending Violations
        $pendingViolations = (int)$db->query("SELECT COUNT(*) FROM violations WHERE status = 'Pending'")->fetchColumn();
        $violationsThisWeek = (int)$db->query("SELECT COUNT(*) FROM violations WHERE created_at >= '$lastWeek'")->fetchColumn();
        $violationsPrevWeek = (int)$db->query("SELECT COUNT(*) FROM violations WHERE created_at >= '$prevWeek' AND created_at < '$lastWeek'")->fetchColumn();
        $violationTrend = 0;
        if ($violationsPrevWeek > 0) {
            $violationTrend = round((($violationsThisWeek - $violationsPrevWeek) / $violationsPrevWeek) * 100, 1);
        }

        // Compliance Rate (Average score of completed inspections)
        $complianceScore = $db->query("SELECT IFNULL(ROUND(AVG(score), 1), 0) FROM inspections WHERE status = 'Completed'")->fetchColumn();
        
        // Revenue / Fines
        $finesCollected = $db->query("SELECT IFNULL(SUM(fine_amount), 0) FROM violations WHERE status = 'Paid'")->fetchColumn();
        $pendingCollection = $db->query("SELECT IFNULL(SUM(fine_amount), 0) FROM violations WHERE status = 'Pending'")->fetchColumn();

        $stats = [
            'total_establishments' => $totalEst,
            'est_trend' => $estTrend,
            'active_inspections' => $activeInspections,
            'insp_trend' => $inspTrend,
            'total_violations' => $pendingViolations,
            'violation_trend' => $violationTrend,
            'compliance_rate' => $complianceScore,
            'total_fines' => $finesCollected,
            'pending_fines' => $pendingCollection
        ];

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
