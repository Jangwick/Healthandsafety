<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;
use PDO;

abstract class BaseModel
{
    protected PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE deleted_at IS NULL");
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "$column = ?";
        }
        $setString = implode(', ', $sets);
        
        $sql = "UPDATE {$this->table} SET $setString WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        $params = array_values($data);
        $params[] = $id;
        
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        // Soft delete if column exists, else hard delete
        $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
