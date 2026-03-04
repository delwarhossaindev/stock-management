<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function stock(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('quantity', '<=', 5);
            } elseif ($request->stock_status === 'out') {
                $query->where('quantity', 0);
            } elseif ($request->stock_status === 'in') {
                $query->where('quantity', '>', 0);
            }
        }

        $products = $query->orderBy('name')->get();

        $totalStockValue = $products->sum(function ($p) {
            return $p->quantity * $p->buy_price;
        });

        $totalSellValue = $products->sum(function ($p) {
            return $p->quantity * $p->sell_price;
        });

        $categories = \App\Models\Category::all();

        return view('reports.stock', compact('products', 'categories', 'totalStockValue', 'totalSellValue'));
    }

    public function purchase(Request $request)
    {
        $query = Purchase::with('supplier')->withCount('items');

        if ($request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $request->to_date);
        }
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();
        $totalAmount = $purchases->sum('total_price');
        $suppliers = \App\Models\Supplier::all();

        return view('reports.purchase', compact('purchases', 'suppliers', 'totalAmount'));
    }

    public function sale(Request $request)
    {
        $query = Sale::withCount('items');

        if ($request->filled('from_date')) {
            $query->whereDate('sale_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('sale_date', '<=', $request->to_date);
        }
        if ($request->filled('customer_name')) {
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();
        $totalAmount = $sales->sum('total_price');

        return view('reports.sale', compact('sales', 'totalAmount'));
    }

    public function profit(Request $request)
    {
        $purchaseQuery = Purchase::query();
        $saleQuery = Sale::query();

        if ($request->filled('from_date')) {
            $purchaseQuery->whereDate('purchase_date', '>=', $request->from_date);
            $saleQuery->whereDate('sale_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $purchaseQuery->whereDate('purchase_date', '<=', $request->to_date);
            $saleQuery->whereDate('sale_date', '<=', $request->to_date);
        }

        $totalPurchase = $purchaseQuery->sum('total_price');
        $totalSale = $saleQuery->sum('total_price');
        $profit = $totalSale - $totalPurchase;

        return view('reports.profit', compact('totalPurchase', 'totalSale', 'profit'));
    }
}
