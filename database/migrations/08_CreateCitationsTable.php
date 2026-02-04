<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateCitationsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS citations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            violation_id INT NOT NULL,
            citation_hash VARCHAR(64) NOT NULL UNIQUE,
            qr_code_path VARCHAR(255),
            issued_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (violation_id) REFERENCES violations(id),
            INDEX (violation_id),
            INDEX (citation_hash)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS citations;");
    }
}
