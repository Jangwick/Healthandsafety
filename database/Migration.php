<?php

declare(strict_types=1);

namespace Database;

use App\Database;
use PDO;

class Migration
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function migrate(): void
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = glob(__DIR__ . '/migrations/*.php');
        sort($files); // Ensure numeric order if prefixed
        $toApply = [];

        foreach ($files as $file) {
            $migrationName = basename($file);
            if (!in_array($migrationName, $appliedMigrations)) {
                $toApply[] = $file;
            }
        }

        if (empty($toApply)) {
            echo "No new migrations to apply.\n";
            return;
        }

        foreach ($toApply as $file) {
            require_once $file;
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $className = preg_replace('/^\d+_/', '', $fileName);
            $fullClassName = 'Database\\Migrations\\' . $className;
            
            echo "Migrating: " . basename($file) . "...\n";
            $migration = new $fullClassName();
            $migration->up($this->db);
            
            $this->logMigration(basename($file));
            echo "Migrated: " . basename($file) . "\n";
        }
    }

    private function createMigrationsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";
        $this->db->exec($sql);
    }

    private function getAppliedMigrations(): array
    {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function logMigration(string $migration): void
    {
        $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migration]);
    }
}
