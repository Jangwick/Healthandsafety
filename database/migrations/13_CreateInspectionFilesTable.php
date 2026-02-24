<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateInspectionFilesTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS inspection_files (
            id INT AUTO_INCREMENT PRIMARY KEY,
            inspection_id INT NOT NULL,
            file_name VARCHAR(255) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            file_type VARCHAR(50) NOT NULL,
            file_size INT NOT NULL,
            uploaded_by INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (inspection_id) REFERENCES inspections(id) ON DELETE CASCADE,
            FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
        ) ENGINE=InnoDB;";
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS inspection_files;");
    }
}
