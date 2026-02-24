<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class AuditLogController extends BaseController {
    private $db;
    protected AuthMiddleware $auth;

    public function __construct() {
        $this->auth = new AuthMiddleware();
        $this->db = Database::getInstance();
    }

    public function index() {
        $user = $this->auth->handle();
        $this->auth->authorize($user, 10); // SuperAdmin only
        
        $table = $_GET['table'] ?? '';
        $action = $_GET['action'] ?? '';
        $user_search = $_GET['user'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        $query = "
            SELECT a.*, u.full_name as user_name, u.email as user_email
            FROM audit_logs a
            LEFT JOIN users u ON a.user_id = u.id
        ";
        
        $where = [];
        $params = [];
        
        if ($table) {
            $where[] = "a.table_name = ?";
            $params[] = $table;
        }
        
        if ($action) {
            $where[] = "a.action = ?";
            $params[] = $action;
        }

        if ($user_search) {
            $where[] = "(u.full_name LIKE ? OR u.email LIKE ?)";
            $params[] = "%$user_search%";
            $params[] = "%$user_search%";
        }

        if ($startDate) {
            $where[] = "DATE(a.timestamp) >= ?";
            $params[] = $startDate;
        }

        if ($endDate) {
            $where[] = "DATE(a.timestamp) <= ?";
            $params[] = $endDate;
        }
        
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        
        $query .= " ORDER BY a.timestamp DESC LIMIT 500";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get unique tables and actions for filters
        $tables = $this->db->query("SELECT DISTINCT table_name FROM audit_logs")->fetchAll(PDO::FETCH_COLUMN);
        $actions = $this->db->query("SELECT DISTINCT action FROM audit_logs")->fetchAll(PDO::FETCH_COLUMN);

        ob_start();
        $this->view('pages/admin/audit_logs', [
            'logs' => $logs,
            'tables' => $tables,
            'actions' => $actions,
            'currentTable' => $table,
            'currentAction' => $action,
            'currentUser' => $user_search,
            'currentStartDate' => $startDate,
            'currentEndDate' => $endDate
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'content' => $content,
            'pageTitle' => 'System Audit Logs',
            'pageHeading' => 'Security & Transaction Logs',
            'user' => $user,
            'breadcrumb' => [
                'Admin' => '#',
                'Audit Logs' => '/admin/audit-logs'
            ]
        ]);
    }
}
