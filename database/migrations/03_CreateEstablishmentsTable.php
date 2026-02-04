<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateEstablishmentsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS establishments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(100) NOT NULL,
            location VARCHAR(255) DEFAULT NULL,
            gps_coordinates POINT NOT NULL,
            status ENUM('Active', 'Suspended', 'Reinstated') DEFAULT 'Active',
            contact_json JSON,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP NULL,
            INDEX (name),
            INDEX (status),
            INDEX (type),
            SPATIAL INDEX(gps_coordinates)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS establishments;");
    }
}
