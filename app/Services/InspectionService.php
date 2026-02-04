<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BaseModel;
use App\Database;
use PDO;

class InspectionService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function calculateScore(int $inspectionId): array
    {
        // Get all items for this inspection
        $stmt = $this->db->prepare("
            SELECT ii.status, ct.items_json 
            FROM inspections i
            JOIN checklist_templates ct ON i.template_id = ct.id
            JOIN inspection_items ii ON ii.inspection_id = i.id
            WHERE i.id = ?
        ");
        $stmt->execute([$inspectionId]);
        $results = $stmt->fetchAll();

        if (empty($results)) return ['score' => 0, 'rating' => 'Failing'];

        $items = json_decode($results[0]['items_json'], true);
        $itemWeights = [];
        foreach ($items as $item) {
            $itemWeights[$item['id']] = $item['weight'] ?? 1;
        }

        $totalPossible = 0;
        $totalEarned = 0;

        // Re-read inspection_items to get the actual marks
        $stmtItems = $this->db->prepare("SELECT checklist_item_id, status FROM inspection_items WHERE inspection_id = ?");
        $stmtItems->execute([$inspectionId]);
        $marks = $stmtItems->fetchAll();

        foreach ($marks as $mark) {
            $weight = $itemWeights[$mark['checklist_item_id']] ?? 1;
            if ($mark['status'] !== 'N/A') {
                $totalPossible += $weight;
                if ($mark['status'] === 'Pass') {
                    $totalEarned += $weight;
                }
            }
        }

        $score = $totalPossible > 0 ? ($totalEarned / $totalPossible) * 100 : 0;
        $rating = $this->getRating($score);

        return [
            'score' => $score,
            'rating' => $rating
        ];
    }

    private function getRating(float $score): string
    {
        if ($score >= 95) return 'Excellent';
        if ($score >= 85) return 'Good';
        if ($score >= 75) return 'Fair';
        if ($score >= 60) return 'Poor';
        return 'Failing';
    }

    public function finalizeInspection(int $inspectionId): bool
    {
        $results = $this->calculateScore($inspectionId);
        
        $stmt = $this->db->prepare("
            UPDATE inspections 
            SET score = ?, rating = ?, status = 'Completed', completed_at = NOW() 
            WHERE id = ?
        ");
        
        return $stmt->execute([$results['score'], $results['rating'], $inspectionId]);
    }
}
