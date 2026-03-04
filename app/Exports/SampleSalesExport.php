<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleSalesExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['পণ্য', 'ক্রেতার নাম', 'পরিমাণ', 'বিক্রয় মূল্য', 'বিক্রয়ের তারিখ', 'নোট'];
    }

    public function array(): array
    {
        return [
            ['স্মার্টফোন', 'করিম সাহেব', 2, 15000, '2026-03-01', ''],
            ['টি-শার্ট', 'রহিম মিয়া', 5, 350, '2026-03-02', 'পাইকারি বিক্রয়'],
            ['চাল (মিনিকেট)', 'জামাল উদ্দিন', 3, 480, '2026-03-03', ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
