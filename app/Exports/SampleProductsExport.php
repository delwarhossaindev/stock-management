<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleProductsExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['ক্যাটাগরি', 'নাম', 'এসকেইউ', 'বিবরণ', 'ক্রয় মূল্য', 'বিক্রয় মূল্য', 'পরিমাণ', 'একক'];
    }

    public function array(): array
    {
        return [
            ['ইলেকট্রনিক্স', 'স্মার্টফোন', 'EL-001', 'অ্যান্ড্রয়েড স্মার্টফোন', 12000, 15000, 50, 'পিস'],
            ['পোশাক', 'টি-শার্ট', 'CL-001', 'কটন টি-শার্ট', 200, 350, 100, 'পিস'],
            ['মুদি', 'চাল (মিনিকেট)', 'GR-001', 'মিনিকেট চাল ৫কেজি', 400, 480, 30, 'বস্তা'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
