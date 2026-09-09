<?php

namespace Database\Seeders;

use App\Models\ShipmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShipmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Not Shipped',
            'Packed',
            'Shipped',
            'Delivered',
            'Returned'
        ];

        foreach($statuses as $status)
        {
            ShipmentStatus::create([
                'name' => $status
            ]);
        }
    }
}
