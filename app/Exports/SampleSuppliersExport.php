<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleSuppliersExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['নাম', 'ইমেইল', 'ফোন', 'ঠিকানা'];
    }

    public function array(): array
    {
        return [
            ['রহিম ট্রেডার্স', 'rahim@example.com', '01712345678', 'মতিঝিল, ঢাকা'],
            ['করিম সাপ্লায়ার্স', 'karim@example.com', '01812345678', 'চট্টগ্রাম'],
            ['আলম এন্টারপ্রাইজ', 'alam@example.com', '01912345678', 'সিলেট'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
