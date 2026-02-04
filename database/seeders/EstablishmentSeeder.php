<?php

declare(strict_types=1);

namespace Database\Seeders;

use PDO;

class EstablishmentSeeder
{
    public function run(PDO $db): void
    {
        $establishments = [
            [
                'name' => 'City Grand Hotel',
                'type' => 'Accommodation',
                'location' => '123 Main St, Central District',
                'status' => 'Active',
                'contact' => json_encode(['phone' => '0917-123-4567', 'email' => 'info@citygrand.com'])
            ],
            [
                'name' => 'The Daily Grind Coffee',
                'type' => 'Restaurant/Cafe',
                'location' => '45 South Ave, Business Park',
                'status' => 'Active',
                'contact' => json_encode(['phone' => '0918-765-4321', 'email' => 'hello@dailygrind.ph'])
            ],
            [
                'name' => 'Evergreen Shopping Mall',
                'type' => 'Commercial',
                'location' => '88 North Blvd, Green Valley',
                'status' => 'Active',
                'contact' => json_encode(['phone' => '02-888-9999', 'email' => 'admin@evergreen.com'])
            ],
            [
                'name' => 'Industrial Storage Solutions',
                'type' => 'Warehouse',
                'location' => 'Industrial Zone, Tower 3',
                'status' => 'Suspended',
                'contact' => json_encode(['phone' => '0999-111-2222', 'email' => 'contact@iss.com'])
            ]
        ];

        foreach ($establishments as $est) {
            $stmt = $db->prepare("INSERT INTO establishments (name, type, location, status, contact_json, gps_coordinates) 
                                 VALUES (?, ?, ?, ?, ?, ST_GeomFromText('POINT(121.0 14.0)'))");
            $stmt->execute([$est['name'], $est['type'], $est['location'], $est['status'], $est['contact']]);
        }
    }
}
