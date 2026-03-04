<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $categoryName = $row['category'] ?? $row['ক্যাটাগরি'] ?? null;
        $category = Category::firstOrCreate(['name' => $categoryName]);

        return new Product([
            'category_id' => $category->id,
            'name' => $row['name'] ?? $row['নাম'] ?? null,
            'sku' => $row['sku'] ?? $row['এসকেইউ'] ?? null,
            'description' => $row['description'] ?? $row['বিবরণ'] ?? null,
            'buy_price' => $row['buy_price'] ?? $row['ক্রয় মূল্য'] ?? 0,
            'sell_price' => $row['sell_price'] ?? $row['বিক্রয় মূল্য'] ?? 0,
            'quantity' => $row['quantity'] ?? $row['পরিমাণ'] ?? 0,
            'unit' => $row['unit'] ?? $row['একক'] ?? 'পিস',
        ]);
    }
}
