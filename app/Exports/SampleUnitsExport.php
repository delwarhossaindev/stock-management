<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleUnitsExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['নাম'];
    }

    public function array(): array
    {
        return [
            ['পিস'],
            ['কেজি'],
            ['লিটার'],
            ['বক্স'],
            ['ডজন'],
            ['প্যাকেট'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
