<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UnitsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Unit::withCount('products')->latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'নাম', 'পণ্য সংখ্যা'];
    }

    public function map($unit): array
    {
        static $i = 0;
        $i++;
        return [$i, $unit->name, $unit->products_count];
    }
}
