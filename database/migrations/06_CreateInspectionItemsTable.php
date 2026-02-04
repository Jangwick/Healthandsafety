<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateInspectionItemsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS inspection_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            inspection_id INT NOT NULL,
            checklist_item_id VARCHAR(50) NOT NULL,
            status ENUM('Pass', 'Fail', 'N/A') DEFAULT 'N/A',
            notes TEXT,
            photo_path VARCHAR(255),
            gps_timestamp TIMESTAMP NULL,
            FOREIGN KEY (inspection_id) REFERENCES inspections(id) ON DELETE CASCADE,
            INDEX (inspection_id)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS inspection_items;");
    }
}
