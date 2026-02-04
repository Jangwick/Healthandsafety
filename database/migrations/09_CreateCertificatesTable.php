<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateCertificatesTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS certificates (
            id INT AUTO_INCREMENT PRIMARY KEY,
            establishment_id INT NOT NULL,
            inspection_id INT NOT NULL,
            qr_code_hash VARCHAR(64) NOT NULL UNIQUE,
            issued_date DATE NOT NULL,
            expiry_date DATE NOT NULL,
            status ENUM('Valid', 'Expired', 'Revoked') DEFAULT 'Valid',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (establishment_id) REFERENCES establishments(id),
            FOREIGN KEY (inspection_id) REFERENCES inspections(id),
            INDEX (establishment_id),
            INDEX (inspection_id),
            INDEX (expiry_date),
            INDEX (status)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS certificates;");
    }
}
