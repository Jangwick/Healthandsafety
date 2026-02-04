<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateViolationsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS violations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            inspection_id INT NOT NULL,
            description TEXT NOT NULL,
            fine_amount DECIMAL(10,2) DEFAULT 0.00,
            status ENUM('Pending', 'Paid', 'Resolved', 'In Progress') DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (inspection_id) REFERENCES inspections(id),
            INDEX (inspection_id),
            INDEX (status)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS violations;");
    }
}
