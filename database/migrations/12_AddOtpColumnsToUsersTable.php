<?php

declare(strict_types=1);

namespace Database\Migrations;

use PDO;

class AddOtpColumnsToUsersTable
{
    public function up(PDO $db): void
    {
        $sql = "ALTER TABLE users 
                ADD COLUMN otp_code VARCHAR(10) NULL AFTER password_hash,
                ADD COLUMN otp_expires_at TIMESTAMP NULL AFTER otp_code;";
        $db->exec($sql);
    }

    public function down(PDO $db): void
    {
        $sql = "ALTER TABLE users 
                DROP COLUMN otp_code,
                DROP COLUMN otp_expires_at;";
        $db->exec($sql);
    }
}
