<?php

declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class RoleSeeder
{
    public function run(PDO $db): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'hierarchy_level' => 10,
                'permissions' => json_encode(['all' => true])
            ],
            [
                'name' => 'Inspector',
                'hierarchy_level' => 5,
                'permissions' => json_encode(['inspect' => true, 'view_establishments' => true])
            ],
            [
                'name' => 'Clerk',
                'hierarchy_level' => 3,
                'permissions' => json_encode(['view_reports' => true, 'manage_establishments' => true])
            ],
            [
                'name' => 'Owner',
                'hierarchy_level' => 1,
                'permissions' => json_encode(['view_own_compliance' => true])
            ],
        ];

        $stmt = $db->prepare("INSERT IGNORE INTO roles (name, hierarchy_level, permissions_json) VALUES (?, ?, ?)");
        
        foreach ($roles as $role) {
            $stmt->execute([$role['name'], $role['hierarchy_level'], $role['permissions']]);
        }
    }
}
