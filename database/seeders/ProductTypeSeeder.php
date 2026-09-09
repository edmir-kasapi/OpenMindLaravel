<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            "Electronics",
            "Clothing",
            "Footwear",
            "Accessories",
            "Home & Kitchen",
            "Furniture",
            "Beauty & Personal Care",
            "Health & Wellness",
            "Sports & Outdoors",
            "Toys & Games",
            "Books",
            "Office Supplies",
            "Automotive",
            "Pet Supplies",
            "Food & Beverages",
            "Jewelry",
            "Watches",
            "Baby Products",
            "Garden & Outdoor",
            "Tools & Hardware",
            "Art & Crafts",
            "Musical Instruments",
            "Software",
            "Digital Products",
            "Gift Cards"
        ];

        foreach($types as $type)
        {
            ProductType::firstOrCreate([
                'type' => $type
            ]);
        }
    }
}
