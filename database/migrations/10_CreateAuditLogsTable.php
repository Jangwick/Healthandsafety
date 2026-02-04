<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class CreateAuditLogsTable
{
    public function up(PDO $db): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS audit_logs (
            id BIGINT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            action VARCHAR(50) NOT NULL,
            table_name VARCHAR(50) NOT NULL,
            record_id INT NOT NULL,
            changes_json JSON,
            ip_address VARCHAR(45),
            user_agent TEXT,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            INDEX (user_id),
            INDEX (table_name),
            INDEX (record_id),
            INDEX (timestamp)
        ) ENGINE=InnoDB;";
        
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS audit_logs;");
    }
}
