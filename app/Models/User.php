<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends BaseModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT u.*, r.name as role_name, r.hierarchy_level 
                                   FROM users u 
                                   JOIN roles r ON u.role_id = r.id 
                                   WHERE u.email = ? AND u.deleted_at IS NULL");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function getPermissions(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT r.permissions_json 
                                   FROM users u 
                                   JOIN roles r ON u.role_id = r.id 
                                   WHERE u.id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row ? json_decode($row['permissions_json'], true) : [];
    }
}
