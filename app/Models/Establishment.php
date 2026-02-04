<?php

declare(strict_types=1);

namespace App\Models;

use PDO;

class Establishment extends BaseModel
{
    protected string $table = 'establishments';

    public function search(string $term): array
    {
        $stmt = $this->db->prepare("SELECT * FROM establishments 
                                   WHERE (name LIKE ? OR type LIKE ?) 
                                   AND deleted_at IS NULL");
        $like = "%$term%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }

    public function getHistory(int $id): array
    {
        $stmt = $this->db->prepare("SELECT i.*, u.full_name as inspector_name 
                                   FROM inspections i 
                                   JOIN users u ON i.inspector_id = u.id 
                                   WHERE i.establishment_id = ? 
                                   ORDER BY i.scheduled_date DESC");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
}
