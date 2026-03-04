<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('category')->latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'নাম', 'এসকেইউ', 'ক্যাটাগরি', 'ক্রয় মূল্য', 'বিক্রয় মূল্য', 'পরিমাণ', 'একক'];
    }

    public function map($product): array
    {
        static $i = 0;
        $i++;
        return [$i, $product->name, $product->sku, $product->category->name, $product->buy_price, $product->sell_price, $product->quantity, $product->unit];
    }
}
