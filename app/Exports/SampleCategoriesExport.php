<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleCategoriesExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return ['নাম', 'বিবরণ'];
    }

    public function array(): array
    {
        return [
            ['ইলেকট্রনিক্স', 'সকল প্রকার ইলেকট্রনিক পণ্য'],
            ['পোশাক', 'পুরুষ ও মহিলাদের পোশাক'],
            ['মুদি', 'দৈনন্দিন মুদি সামগ্রী'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
