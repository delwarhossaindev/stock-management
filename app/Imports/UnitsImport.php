<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UnitsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Unit([
            'name' => $row['name'] ?? $row['নাম'] ?? null,
        ]);
    }
}
