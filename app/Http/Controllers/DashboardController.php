<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers' => Supplier::count(),
            'totalPurchases' => Purchase::sum('total_price'),
            'totalSales' => Sale::sum('total_price'),
            'totalProfit' => Sale::sum('total_price') - Purchase::sum('total_price'),
            'lowStockProducts' => Product::where('quantity', '<=', 5)->get(),
            'recentPurchases' => Purchase::with('supplier')->latest()->take(5)->get(),
            'recentSales' => Sale::latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
