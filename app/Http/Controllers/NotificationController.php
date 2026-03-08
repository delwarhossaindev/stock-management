<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $threshold = (int) Setting::get('low_stock_threshold', 5);

        $lowStock = Product::where('quantity', '<=', $threshold)
            ->where('quantity', '>', 0)
            ->orderBy('quantity')
            ->get();

        $outOfStock = Product::where('quantity', '<=', 0)->get();

        $duePurchases = Purchase::where('due_amount', '>', 0)
            ->with('supplier')
            ->latest('purchase_date')
            ->get();

        $dueSales = Sale::where('due_amount', '>', 0)
            ->latest('sale_date')
            ->get();

        return view('notifications.index', compact('lowStock', 'outOfStock', 'duePurchases', 'dueSales', 'threshold'));
    }
}
