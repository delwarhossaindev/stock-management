<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuppliersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Supplier([
            'name' => $row['name'] ?? $row['নাম'] ?? null,
            'email' => $row['email'] ?? $row['ইমেইল'] ?? null,
            'phone' => $row['phone'] ?? $row['ফোন'] ?? null,
            'address' => $row['address'] ?? $row['ঠিকানা'] ?? null,
        ]);
    }
}
