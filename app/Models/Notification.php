<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;
use PDO;

class Notification extends BaseModel
{
    protected string $table = 'notifications';

    public static function send(int $userId, string $title, string $message, string $type = 'info', string $icon = 'fas fa-info-circle', ?string $link = null): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message, type, icon, link) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $title, $message, $type, $icon, $link]);
    }

    public function allForUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 100");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnread(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? AND is_read = 0 AND deleted_at IS NULL ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsRead(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_read = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function markAllAsRead(int $userId): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_read = 1 WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}
