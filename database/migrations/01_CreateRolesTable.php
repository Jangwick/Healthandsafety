<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateRolesTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL UNIQUE,
            permissions_json JSON,
            hierarchy_level INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS roles;");
    }
}
