<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Supplier::latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'নাম', 'ইমেইল', 'ফোন', 'ঠিকানা'];
    }

    public function map($supplier): array
    {
        static $i = 0;
        $i++;
        return [$i, $supplier->name, $supplier->email, $supplier->phone, $supplier->address];
    }
}
