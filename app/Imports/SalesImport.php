<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $productName = $row['product'] ?? $row['পণ্য'] ?? null;
        $product = Product::where('name', $productName)->first();
        if (!$product) return null;

        $quantity = $row['quantity'] ?? $row['পরিমাণ'] ?? 0;
        $sellPrice = $row['sell_price'] ?? $row['বিক্রয় মূল্য'] ?? 0;
        $saleDate = $row['sale_date'] ?? $row['বিক্রয়ের তারিখ'] ?? now()->format('Y-m-d');
        $customerName = $row['customer_name'] ?? $row['ক্রেতার নাম'] ?? null;
        $note = $row['note'] ?? $row['নোট'] ?? null;

        $lineTotal = $quantity * $sellPrice;

        // Create a single-item invoice for each imported row
        $sale = Sale::create([
            'invoice_no' => Sale::generateInvoiceNo(),
            'customer_name' => $customerName,
            'subtotal' => $lineTotal,
            'discount' => 0,
            'total_price' => $lineTotal,
            'paid_amount' => $lineTotal,
            'due_amount' => 0,
            'sale_date' => $saleDate,
            'note' => $note,
        ]);

        $sale->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'sell_price' => $sellPrice,
            'total' => $lineTotal,
        ]);

        // Reduce stock
        if ($product->quantity >= $quantity) {
            $product->decrement('quantity', $quantity);
        }

        return null; // We already created the sale manually
    }
}
