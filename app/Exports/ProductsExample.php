<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Excel;

class ProductsExample implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, Responsable
{
    use Exportable;

    private $fileName = 'products_example.xlsx';
    private $writerType = Excel::XLSX;
    private $headers = [
        'Content-Type' => 'text/csv'
    ];

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $products = collect([
            [
                'name' => 'Smart Air Purifier',
                'brand' => 'AirNova',
                'price' => 129.99,
                'product_type' => 1,
                'stock' => 56,
                'description' => 'Compact smart air purifier with multi-stage filtration, quiet operation, air quality monitoring, and automatic fan control.',
            ],
            [
                'name' => 'Wireless Mechanical Keyboard',
                'brand' => 'TypeCore',
                'price' => 79.99,
                'product_type' => 2,
                'stock' => 91,
                'description' => 'Wireless mechanical keyboard with customizable RGB lighting, tactile switches, rechargeable battery, and compact layout.',
            ],
            [
                'name' => 'Vacuum Insulated Travel Tumbler',
                'brand' => 'ThermoPeak',
                'price' => 32.50,
                'product_type' => 3,
                'stock' => 174,
                'description' => 'Double-wall insulated travel tumbler designed to maintain drink temperature and prevent spills with a secure lid.',
            ],
            [
                'name' => 'Multi-Port USB Charger',
                'brand' => 'PowerGrid',
                'price' => 34.95,
                'product_type' => 4,
                'stock' => 267,
                'description' => 'Multi-port USB charger featuring fast charging technology and multiple outputs for phones, tablets, and other devices.',
            ],
            [
                'name' => 'Adjustable Monitor Arm',
                'brand' => 'DeskFlex',
                'price' => 89.99,
                'product_type' => 5,
                'stock' => 63,
                'description' => 'Adjustable monitor arm with smooth positioning, sturdy construction, cable management, and support for various monitor sizes.',
            ],
            [
                'name' => 'Mini Bluetooth Speaker',
                'brand' => 'EchoCore',
                'price' => 54.99,
                'product_type' => 6,
                'stock' => 112,
                'description' => 'Compact Bluetooth speaker delivering balanced audio, enhanced bass, wireless connectivity, and extended battery life.',
            ],
            [
                'name' => 'Linen Casual Shirt',
                'brand' => 'ThreadHouse',
                'price' => 39.95,
                'product_type' => 7,
                'stock' => 143,
                'description' => 'Lightweight linen casual shirt with a relaxed fit, breathable fabric, and versatile styling for everyday wear.',
            ],
            [
                'name' => 'Lightweight Training Sneakers',
                'brand' => 'AeroRun',
                'price' => 94.99,
                'product_type' => 8,
                'stock' => 76,
                'description' => 'Lightweight training sneakers with responsive cushioning, breathable mesh construction, and durable rubber outsoles.',
            ],
            [
                'name' => 'Touch Control Table Lamp',
                'brand' => 'LumiHome',
                'price' => 42.99,
                'product_type' => 9,
                'stock' => 129,
                'description' => 'Modern table lamp with touch controls, adjustable brightness levels, and a warm ambient lighting mode.',
            ],
            [
                'name' => 'Double Wall Coffee Cup',
                'brand' => 'CupWorks',
                'price' => 18.95,
                'product_type' => 10,
                'stock' => 238,
                'description' => 'Double-wall coffee cup with a comfortable grip, heat-resistant design, and durable construction for everyday use.',
            ],
        ]);
    }

    public function headings(): array
    {

        return [
                'name',
                'brand',
                'price',
                'product_type',
                'stock',
                'description',
            ];
    }

    public function title(): string
    {
        return "Product Import Example";
    }
}
