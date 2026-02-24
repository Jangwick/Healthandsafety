<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class AnalyticsController extends BaseController {
    private $db;
    protected AuthMiddleware $auth;

    public function __construct() {
        $this->auth = new AuthMiddleware();
        $this->db = Database::getInstance();
    }

    public function index() {
        $user = $this->auth->handle();
        
        // 1. Overview Statistics
        $stats = [
            'total_inspections' => $this->db->query("SELECT COUNT(*) FROM inspections")->fetchColumn(),
            'avg_score' => $this->db->query("SELECT AVG(score) FROM inspections WHERE status = 'Completed'")->fetchColumn() ?? 0,
            'total_violations' => $this->db->query("SELECT COUNT(*) FROM violations")->fetchColumn(),
            'total_fines' => $this->db->query("SELECT SUM(fine_amount) FROM violations WHERE status = 'Paid'")->fetchColumn() ?? 0,
            'pending_fines' => $this->db->query("SELECT SUM(fine_amount) FROM violations WHERE status != 'Paid'")->fetchColumn() ?? 0,
            'total_establishments' => $this->db->query("SELECT COUNT(*) FROM establishments")->fetchColumn(),
        ];

        // 2. Weekly Inspection Trends (Last 8 weeks)
        $trendsQuery = $this->db->query("
            SELECT 
                DATE_FORMAT(scheduled_date, '%Y-%u') as week,
                COUNT(*) as count,
                AVG(score) as avg_score
            FROM inspections 
            WHERE scheduled_date >= DATE_SUB(NOW(), INTERVAL 8 WEEK)
            GROUP BY week
            ORDER BY week ASC
        ");
        $trends = $trendsQuery->fetchAll(PDO::FETCH_ASSOC);

        // 3. Violation Status Breakdown
        $violationStats = $this->db->query("
            SELECT status, COUNT(*) as count 
            FROM violations 
            GROUP BY status
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 4. Distribution by Establishment Category
        $categoryCompliance = $this->db->query("
            SELECT e.type, 
                   COUNT(i.id) as total_inspections,
                   AVG(i.score) as avg_score,
                   SUM(CASE WHEN i.status = 'Completed' AND i.score < 75 THEN 1 ELSE 0 END) as failure_count
            FROM establishments e
            LEFT JOIN inspections i ON e.id = i.establishment_id
            GROUP BY e.type
            ORDER BY avg_score DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 5. Inspector Productivity Heatmap (Last 30 Days)
        $inspectorStats = $this->db->query("
            SELECT u.full_name as inspector_name, 
                   COUNT(i.id) as total_conducted,
                   AVG(i.score) as avg_rating_given
            FROM users u
            JOIN inspections i ON u.id = i.inspector_id
            WHERE i.status = 'Completed' AND i.completed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY u.id
            ORDER BY total_conducted DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 6. Revenue Growth (Last 6 Months)
        $revenueTrends = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%b %Y') as month,
                   SUM(fine_amount) as total_imposed,
                   SUM(CASE WHEN status = 'Paid' THEN fine_amount ELSE 0 END) as total_collected
            FROM violations
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY month
            ORDER BY MIN(created_at)
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 7. Recent High-Risk Failures (Scores < 70)
        $highRisk = $this->db->query("
            SELECT e.name, i.score, i.scheduled_date, e.type as category
            FROM inspections i
            JOIN establishments e ON i.establishment_id = e.id
            WHERE i.score < 70 AND i.status = 'Completed'
            ORDER BY i.scheduled_date DESC
            LIMIT 6
        ")->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        $this->view('pages/reports/index', [
            'stats' => $stats,
            'trends' => $trends,
            'violationStats' => $violationStats,
            'categoryCompliance' => $categoryCompliance,
            'inspectorStats' => $inspectorStats,
            'revenueTrends' => $revenueTrends,
            'highRisk' => $highRisk
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'content' => $content,
            'pageTitle' => 'Reports & Analytics',
            'pageHeading' => 'Reports & Analytics',
            'user' => $user,
            'breadcrumb' => [
                'Main' => '/dashboard',
                'Intelligence' => '/reports'
            ]
        ]);
    }

    public function export() {
        $user = $this->auth->handle();
        $type = $_GET['type'] ?? 'csv';
        
        if ($type === 'csv') {
            $this->exportViolationsCSV();
        } else {
            header('Location: /reports');
        }
    }

    private function exportViolationsCSV() {
        $filename = "violations_report_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Establishment', 'Inspector', 'Description', 'Fine Amount', 'Status', 'Date Recorded']);
        
        $query = "
            SELECT v.id, e.name as establishment_name, u.full_name as inspector_name, 
                   v.description, v.fine_amount, v.status, v.created_at
            FROM violations v
            JOIN inspections i ON v.inspection_id = i.id
            JOIN establishments e ON i.establishment_id = e.id
            JOIN users u ON i.inspector_id = u.id
            ORDER BY v.created_at DESC
        ";
        
        $stmt = $this->db->query($query);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, [
                $row['id'],
                $row['establishment_name'],
                $row['inspector_name'],
                $row['description'],
                $row['fine_amount'],
                $row['status'],
                $row['created_at']
            ]);
        }
        fclose($output);
        exit;
    }
}
