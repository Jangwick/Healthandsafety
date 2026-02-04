<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database;
use App\Middleware\AuthMiddleware;
use PDO;

class SettingsController extends BaseController {
    private $db;
    protected AuthMiddleware $auth;

    public function __construct() {
        $this->auth = new AuthMiddleware();
        $this->db = Database::getInstance();
        $this->ensureTableExists();
    }

    private function ensureTableExists() {
        $sql = "CREATE TABLE IF NOT EXISTS settings (
            setting_key VARCHAR(50) PRIMARY KEY,
            setting_value TEXT NOT NULL,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->db->exec($sql);

        // Seed defaults if empty
        $stmt = $this->db->query("SELECT COUNT(*) FROM settings");
        if ($stmt->fetchColumn() == 0) {
            $defaults = [
                ['lgu_name', 'MUNICIPALITY OF SAMPLE'],
                ['office_name', 'HEALTH AND SAFETY OFFICE'],
                ['system_title', 'H&S COMPLIANCE SYSTEM'],
                ['penalty_amount', '2500.00'],
                ['permit_validity_years', '1']
            ];
            $stmt = $this->db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
            foreach ($defaults as $default) {
                $stmt->execute($default);
            }
        }
    }

    public function index() {
        $user = $this->auth->handle();
        
        $stmt = $this->db->query("SELECT * FROM settings");
        $settings_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($settings_raw as $s) {
            $settings[$s['setting_key']] = $s['setting_value'];
        }

        ob_start();
        $this->view('pages/settings/index', [
            'settings' => $settings
        ]);
        $content = ob_get_clean();

        $this->view('layouts/main', [
            'content' => $content,
            'pageTitle' => 'System Settings',
            'pageHeading' => 'System Configuration',
            'user' => $user
        ]);
    }

    public function update() {
        $this->auth->handle();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $this->db->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            foreach ($_POST['settings'] as $key => $value) {
                $stmt->execute([$value, $key]);
            }
            header('Location: /settings?success=1');
            exit;
        }
    }
}
