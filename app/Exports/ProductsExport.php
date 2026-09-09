<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ProductsExport extends DocumentExport
{
    protected string $activeName = 'active_products';
    protected string $trashedName = 'deleted_products';
    protected string $extension = ".xlsx";

    protected string $dateColumn;
    protected string $createtAtColumn = 'registered_at';
    protected string $deletedAtColumn = 'deleted_at';

    protected string $activeTitle = 'Products';
    protected string $trashedTitle = 'Deleted Products';

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'category',
            'price ($)',
            'stock',
            'reserved_stock',
            'available_stock',
            $this->dateColumn,
        ];
    }

    public function map($product): array
    {
        $date_val = $this->parseDateColumn($product);

        return [
            $product->id,
            $product->name,
            $product->description,
            $product->type->getTypeName(),
            strval($product->price),
            strval($product->stock),
            strval($product->reserved_stock),
            strval($product->available_stock),
            $date_val,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $highestRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            "B2:B{$highestRow}" => ['font' => ['italic' => true]],
            "E2:E{$highestRow}" => ['font' => ['color' => ['argb' => Color::COLOR_DARKGREEN]]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'aftersheet']
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $highestRow = $sheet->getHighestRow();

        $range = "D2:D{$highestRow}";

        $categories = [
            Color::COLOR_BLUE => [
                'Electronics',
                'Software',
                'Digital Products',
            ],

            Color::COLOR_RED => [
                'Clothing',
                'Footwear',
                'Accessories',
                'Jewelry',
                'Watches',
                'Beauty & Personal Care',
            ],

            Color::COLOR_DARKGREEN => [
                'Home & Kitchen',
                'Furniture',
                'Garden & Outdoor',
                'Tools & Hardware',
            ],

            Color::COLOR_DARKYELLOW => [
                'Health & Wellness',
                'Food & Beverages',
                'Pet Supplies',
                'Baby Products',
            ],

            Color::COLOR_DARKBLUE => [
                'Sports & Outdoors',
                'Toys & Games',
                'Art & Crafts',
                'Musical Instruments',
            ],

            'FF6C757D' => [ //Gray color
                'Books',
                'Office Supplies',
            ],

            Color::COLOR_BLACK => [
                'Automotive',
            ],

            Color::COLOR_WHITE => [
                'Gift Cards',
            ],
        ];

        $conditions = [];

        foreach($categories as $color => $categories)
        {
            foreach($categories as $category)
            {
                $conditions[] = self::conditionalColor($category, $color);
            }
        }

        $sheet->getStyle($range)
           ->setConditionalStyles($conditions);

        $sheet->setSelectedCell('A1');
    }
}
