<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'name' => $row['name'] ?? $row['নাম'] ?? null,
            'email' => $row['email'] ?? $row['ইমেইল'] ?? null,
            'phone' => $row['phone'] ?? $row['ফোন'] ?? null,
            'address' => $row['address'] ?? $row['ঠিকানা'] ?? null,
        ]);
    }
}
