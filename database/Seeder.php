<?php

declare(strict_types=1);

namespace Database;

use App\Database;
use PDO;

class Seeder
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function seed(): void
    {
        $files = glob(__DIR__ . '/seeders/*.php');

        foreach ($files as $file) {
            require_once $file;
            $className = 'Database\\Seeders\\' . pathinfo($file, PATHINFO_FILENAME);
            $seeder = new $className();
            
            echo "Seeding: " . basename($file) . "...\n";
            $seeder->run($this->db);
            echo "Seeded: " . basename($file) . "\n";
        }
    }
}
