<?php

declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    protected function view(string $path, array $data = []): void
    {
        extract($data);
        $fullPath = __DIR__ . "/../../views/{$path}.php";
        
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            die("View not found: {$path}");
        }
    }

    protected function logTransaction(string $action, string $table, int $recordId, array $changes = []): void {
        $db = \App\Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO audit_logs (user_id, action, table_name, record_id, changes_json, ip_address, user_agent)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_SESSION['user_id'] ?? null,
            $action,
            $table,
            $recordId,
            json_encode($changes),
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);
    }
}
