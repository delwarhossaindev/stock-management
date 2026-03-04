<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Customer::latest()->get();
    }

    public function headings(): array
    {
        return ['#', 'নাম', 'ইমেইল', 'ফোন', 'ঠিকানা'];
    }

    public function map($customer): array
    {
        static $i = 0;
        $i++;
        return [$i, $customer->name, $customer->email, $customer->phone, $customer->address];
    }
}
