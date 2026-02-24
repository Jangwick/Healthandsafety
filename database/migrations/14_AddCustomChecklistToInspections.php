<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class AddCustomChecklistToInspections
{
    public function up(PDO $db): void
    {
        $sql = "ALTER TABLE inspections 
                ADD COLUMN custom_checklist_json LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(custom_checklist_json)) AFTER scheduled_date;";
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $sql = "ALTER TABLE inspections 
                DROP COLUMN custom_checklist_json;";
        $db->exec($sql);
    }
}
