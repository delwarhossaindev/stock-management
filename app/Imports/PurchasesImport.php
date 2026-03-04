<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PurchasesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $productName = $row['product'] ?? $row['পণ্য'] ?? null;
        $product = Product::where('name', $productName)->first();
        if (!$product) return null;

        $supplierName = $row['supplier'] ?? $row['সরবরাহকারী'] ?? null;
        $supplier = Supplier::where('name', $supplierName)->first();
        if (!$supplier) return null;

        $quantity = $row['quantity'] ?? $row['পরিমাণ'] ?? 0;
        $buyPrice = $row['buy_price'] ?? $row['ক্রয় মূল্য'] ?? 0;
        $purchaseDate = $row['purchase_date'] ?? $row['ক্রয়ের তারিখ'] ?? now()->format('Y-m-d');
        $note = $row['note'] ?? $row['নোট'] ?? null;

        $lineTotal = $quantity * $buyPrice;

        // Create purchase as single-item invoice
        $purchase = Purchase::create([
            'purchase_no' => Purchase::generatePurchaseNo(),
            'supplier_id' => $supplier->id,
            'subtotal' => $lineTotal,
            'discount' => 0,
            'total_price' => $lineTotal,
            'paid_amount' => $lineTotal,
            'due_amount' => 0,
            'purchase_date' => $purchaseDate,
            'note' => $note,
        ]);

        $purchase->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'buy_price' => $buyPrice,
            'total' => $lineTotal,
        ]);

        // Update product stock
        $product->increment('quantity', $quantity);
        $product->update(['buy_price' => $buyPrice]);

        return null; // Already created manually
    }
}
