<?php

declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class UserSeeder
{
    public function run(PDO $db): void
    {
        $adminRoleStmt = $db->query("SELECT id FROM roles WHERE name = 'Admin'");
        $adminRoleId = $adminRoleStmt->fetchColumn();

        if (!$adminRoleId) return;

        $adminUser = [
            'email' => 'admin@lgu.gov.ph',
            'password' => password_hash('Admin123!', PASSWORD_BCRYPT),
            'role_id' => $adminRoleId,
            'full_name' => 'System Administrator'
        ];

        $stmt = $db->prepare("INSERT IGNORE INTO users (email, password_hash, role_id, full_name, email_verified_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([
            $adminUser['email'],
            $adminUser['password'],
            $adminUser['role_id'],
            $adminUser['full_name']
        ]);
    }
}
