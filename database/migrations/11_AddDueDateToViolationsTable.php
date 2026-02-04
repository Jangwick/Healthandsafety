<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class AddDueDateToViolationsTable
{
    public function up(PDO $db): void
    {
        $sql = "ALTER TABLE violations ADD COLUMN due_date DATE AFTER fine_amount;";
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $db->exec("ALTER TABLE violations DROP COLUMN due_date;");
    }
}
