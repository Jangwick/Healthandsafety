<?php

declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class ChecklistTemplateSeeder
{
    public function run(PDO $db): void
    {
        $templates = [
            [
                'category' => 'Food Safety',
                'items' => json_encode([
                    ['id' => 'food_01', 'text' => 'Proper food storage temperature', 'weight' => 10],
                    ['id' => 'food_02', 'text' => 'Cleanliness of food preparation area', 'weight' => 10],
                    ['id' => 'food_03', 'text' => 'Valid health certificates for staff', 'weight' => 5],
                    ['id' => 'food_04', 'text' => 'Pest control measures in place', 'weight' => 10],
                ]),
                'passing_score' => 80
            ],
            [
                'category' => 'Fire Safety',
                'items' => json_encode([
                    ['id' => 'fire_01', 'text' => 'Working fire extinguishers available', 'weight' => 10],
                    ['id' => 'fire_02', 'text' => 'Clear emergency exits', 'weight' => 10],
                    ['id' => 'fire_03', 'text' => 'Functional fire alarm system', 'weight' => 10],
                    ['id' => 'fire_04', 'text' => 'Smoke detectors installed and tested', 'weight' => 5],
                ]),
                'passing_score' => 90
            ],
            [
                'category' => 'Building Safety',
                'items' => json_encode([
                    ['id' => 'bld_01', 'text' => 'Structural integrity inspection', 'weight' => 20],
                    ['id' => 'bld_02', 'text' => 'Electrical wiring safety', 'weight' => 10],
                    ['id' => 'bld_03', 'text' => 'Plumbing and sanitation functional', 'weight' => 5],
                ]),
                'passing_score' => 75
            ],
            [
                'category' => 'Sanitation & Health',
                'items' => json_encode([
                    ['id' => 'san_01', 'text' => 'Proper waste disposal system', 'weight' => 10],
                    ['id' => 'san_02', 'text' => 'Clean restroom facilities', 'weight' => 5],
                    ['id' => 'san_03', 'text' => 'Water supply safety', 'weight' => 10],
                ]),
                'passing_score' => 70
            ],
        ];

        $stmt = $db->prepare("INSERT IGNORE INTO checklist_templates (category, items_json, passing_score) VALUES (?, ?, ?)");
        
        foreach ($templates as $template) {
            $stmt->execute([$template['category'], $template['items'], $template['passing_score']]);
        }
    }
}
