<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return ['#', 'তারিখ', 'ক্রয় নং', 'সরবরাহকারী', 'পণ্য', 'পরিমাণ', 'একক মূল্য', 'আইটেম মোট', 'ছাড়', 'মোট', 'পরিশোধ', 'বকেয়া'];
    }

    public function array(): array
    {
        $purchases = Purchase::with('supplier', 'items.product')->latest()->get();
        $rows = [];
        $i = 0;

        foreach ($purchases as $purchase) {
            $first = true;
            foreach ($purchase->items as $item) {
                $i++;
                $rows[] = [
                    $i,
                    $first ? $purchase->purchase_date->format('d/m/Y') : '',
                    $first ? $purchase->purchase_no : '',
                    $first ? ($purchase->supplier->name ?? '-') : '',
                    $item->product->name,
                    $item->quantity,
                    $item->buy_price,
                    $item->total,
                    $first ? $purchase->discount : '',
                    $first ? $purchase->total_price : '',
                    $first ? $purchase->paid_amount : '',
                    $first ? $purchase->due_amount : '',
                ];
                $first = false;
            }
        }

        return $rows;
    }
}
