<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['ইনভয়েস নং', 'তারিখ', 'ক্রেতা', 'পণ্য', 'পরিমাণ', 'একক মূল্য', 'আইটেম মোট', 'ছাড়', 'সর্বমোট', 'পরিশোধ', 'বকেয়া'];
    }

    public function array(): array
    {
        $rows = [];
        $sales = Sale::with('items.product')->latest()->get();

        foreach ($sales as $sale) {
            foreach ($sale->items as $i => $item) {
                $rows[] = [
                    $i === 0 ? $sale->invoice_no : '',
                    $i === 0 ? $sale->sale_date->format('d/m/Y') : '',
                    $i === 0 ? ($sale->customer_name ?? '-') : '',
                    $item->product->name,
                    $item->quantity,
                    $item->sell_price,
                    $item->total,
                    $i === 0 ? $sale->discount : '',
                    $i === 0 ? $sale->total_price : '',
                    $i === 0 ? $sale->paid_amount : '',
                    $i === 0 ? $sale->due_amount : '',
                ];
            }
        }

        return $rows;
    }
}
