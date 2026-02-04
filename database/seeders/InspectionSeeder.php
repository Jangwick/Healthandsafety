<?php

declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class InspectionSeeder
{
    public function run(PDO $db): void
    {
        // Get some IDs
        $establishments = $db->query("SELECT id FROM establishments")->fetchAll(PDO::FETCH_COLUMN);
        $inspectors = $db->query("SELECT id FROM users WHERE role_id = (SELECT id FROM roles WHERE name = 'Inspector')")->fetchAll(PDO::FETCH_COLUMN);
        
        if (empty($establishments) || empty($inspectors)) return;

        $inspections = [
            [
                'establishment_id' => $establishments[0],
                'inspector_id' => $inspectors[0],
                'status' => 'Completed',
                'scheduled_date' => date('Y-m-d', strtotime('-2 days')),
                'score' => 92.5,
                'rating' => 'Satisfactory'
            ],
            [
                'establishment_id' => $establishments[1],
                'inspector_id' => $inspectors[0],
                'status' => 'In Progress',
                'scheduled_date' => date('Y-m-d'),
                'score' => 0,
                'rating' => null
            ],
            [
                'establishment_id' => $establishments[2],
                'inspector_id' => $inspectors[0],
                'status' => 'Scheduled',
                'scheduled_date' => date('Y-m-d', strtotime('+3 days')),
                'score' => 0,
                'rating' => null
            ]
        ];

        foreach ($inspections as $insp) {
            $stmt = $db->prepare("INSERT INTO inspections (establishment_id, inspector_id, status, scheduled_date, score, rating) 
                                 VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $insp['establishment_id'],
                $insp['inspector_id'],
                $insp['status'],
                $insp['scheduled_date'],
                $insp['score'],
                $insp['rating']
            ]);
        }
    }
}
