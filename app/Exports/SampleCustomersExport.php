<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleCustomersExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['নাম', 'ইমেইল', 'ফোন', 'ঠিকানা'];
    }

    public function array(): array
    {
        return [
            ['করিম সাহেব', 'karim@example.com', '01712345678', 'মতিঝিল, ঢাকা'],
            ['রহিম মিয়া', 'rahim@example.com', '01812345678', 'চট্টগ্রাম'],
            ['জামাল উদ্দিন', 'jamal@example.com', '01912345678', 'সিলেট'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
