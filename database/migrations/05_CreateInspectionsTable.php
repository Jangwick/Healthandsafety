<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateInspectionsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS inspections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            establishment_id INT NOT NULL,
            inspector_id INT NOT NULL,
            template_id INT NOT NULL,
            scheduled_date DATE NOT NULL,
            completed_at TIMESTAMP NULL,
            status ENUM('Scheduled', 'In Progress', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
            priority ENUM('Low', 'Medium', 'High', 'Urgent') DEFAULT 'Medium',
            score DECIMAL(5, 2) DEFAULT 0.00,
            rating ENUM('Excellent', 'Good', 'Fair', 'Poor', 'Failing') NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (establishment_id) REFERENCES establishments(id),
            FOREIGN KEY (inspector_id) REFERENCES users(id),
            FOREIGN KEY (template_id) REFERENCES checklist_templates(id),
            INDEX (establishment_id),
            INDEX (inspector_id),
            INDEX (scheduled_date),
            INDEX (status)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS inspections;");
    }
}
