<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('quantity', '>', 0)->with('category')->get();
        $customers = Customer::orderBy('name')->get();
        return view('pos.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.sell_price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['sell_price'];
        }

        $discount = $request->input('discount', 0);
        $totalPrice = $subtotal - $discount;
        $paidAmount = $request->paid_amount;
        $dueAmount = max(0, $totalPrice - $paidAmount);

        $sale = Sale::create([
            'invoice_no' => Sale::generateInvoiceNo(),
            'customer_id' => $request->customer_id,
            'customer_name' => $request->customer_name,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax_type' => 'percentage',
            'tax_value' => 0,
            'tax_amount' => 0,
            'total_price' => $totalPrice,
            'paid_amount' => $paidAmount,
            'due_amount' => $dueAmount,
            'sale_date' => now()->toDateString(),
        ]);

        foreach ($request->items as $item) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'sell_price' => $item['sell_price'],
                'total' => $item['quantity'] * $item['sell_price'],
            ]);
            Product::find($item['product_id'])->decrement('quantity', $item['quantity']);
        }

        return response()->json(['success' => true, 'sale_id' => $sale->id, 'invoice_no' => $sale->invoice_no]);
    }
}
