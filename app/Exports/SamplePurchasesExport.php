<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SamplePurchasesExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['পণ্য', 'সরবরাহকারী', 'পরিমাণ', 'ক্রয় মূল্য', 'ক্রয়ের তারিখ', 'নোট'];
    }

    public function array(): array
    {
        return [
            ['স্মার্টফোন', 'ডিজিটাল সাপ্লায়ার্স', 20, 12000, '2026-03-01', 'নতুন স্টক'],
            ['টি-শার্ট', 'ফ্যাশন হাব', 50, 200, '2026-03-02', ''],
            ['চাল (মিনিকেট)', 'গ্রোসারি হোলসেল', 30, 400, '2026-03-03', 'বাল্ক অর্ডার'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
