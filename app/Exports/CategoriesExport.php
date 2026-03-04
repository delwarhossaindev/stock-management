<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Category::withCount('products')->latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'নাম', 'বিবরণ', 'পণ্য সংখ্যা'];
    }

    public function map($category): array
    {
        static $i = 0;
        $i++;
        return [$i, $category->name, $category->description, $category->products_count];
    }
}
