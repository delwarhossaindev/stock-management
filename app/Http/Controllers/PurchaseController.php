<?php

namespace App\Http\Controllers;

use App\Exports\PurchasesExport;
use App\Exports\SamplePurchasesExport;
use App\Imports\PurchasesImport;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $purchases = Purchase::with('supplier')->withCount('items')->latest();
            return DataTables::of($purchases)
                ->addIndexColumn()
                ->addColumn('date_fmt', fn($row) => $row->purchase_date->format('d/m/Y'))
                ->editColumn('purchase_no', fn($row) => '<strong>' . $row->purchase_no . '</strong>')
                ->addColumn('supplier_display', fn($row) => $row->supplier->name ?? '-')
                ->addColumn('total_price_fmt', fn($row) => '<strong>৳' . number_format($row->total_price, 2) . '</strong>')
                ->addColumn('paid_fmt', fn($row) => '৳' . number_format($row->paid_amount, 2))
                ->addColumn('due_fmt', function ($row) {
                    $color = $row->due_amount > 0 ? 'text-danger' : 'text-success';
                    return '<span class="' . $color . '">৳' . number_format($row->due_amount, 2) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $show = route('purchases.show', $row);
                    $edit = route('purchases.edit', $row);
                    $delete = route('purchases.destroy', $row);
                    return '<a href="' . $show . '" class="btn btn-sm btn-info" title="' . __('View') . '" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>
                        <a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>
                        <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Delete this purchase? Stock will be adjusted.') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['purchase_no', 'total_price_fmt', 'due_fmt', 'action'])
                ->make(true);
        }
        return view('purchases.index');
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::orderBy('name')->get();
        $purchaseNo = Purchase::generatePurchaseNo();
        return view('purchases.create', compact('products', 'suppliers', 'purchaseNo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.buy_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['buy_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'buy_price' => $item['buy_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subtotal - $discount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalPrice - $paidAmount;

            $purchase = Purchase::create([
                'purchase_no' => Purchase::generatePurchaseNo(),
                'supplier_id' => $request->supplier_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_price' => $totalPrice,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'purchase_date' => $request->purchase_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $purchase->items()->create($itemData);
                $product = Product::find($itemData['product_id']);
                $product->increment('quantity', $itemData['quantity']);
                $product->update(['buy_price' => $itemData['buy_price']]);
            }
        });

        return redirect()->route('purchases.index')->with('success', __('Purchase saved successfully. Stock updated.'));
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'items.product');
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load('items');
        $products = Product::all();
        $suppliers = Supplier::orderBy('name')->get();
        return view('purchases.edit', compact('purchase', 'products', 'suppliers'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.buy_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $purchase) {
            // Reverse old stock
            foreach ($purchase->items as $oldItem) {
                Product::find($oldItem->product_id)->decrement('quantity', $oldItem->quantity);
            }
            $purchase->items()->delete();

            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['buy_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'buy_price' => $item['buy_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subtotal - $discount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalPrice - $paidAmount;

            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_price' => $totalPrice,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'purchase_date' => $request->purchase_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $purchase->items()->create($itemData);
                $product = Product::find($itemData['product_id']);
                $product->increment('quantity', $itemData['quantity']);
                $product->update(['buy_price' => $itemData['buy_price']]);
            }
        });

        return redirect()->route('purchases.index')->with('success', __('Purchase updated successfully.'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                Product::find($item->product_id)->decrement('quantity', $item->quantity);
            }
            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', __('Purchase deleted. Stock adjusted.'));
    }

    public function export()
    {
        return Excel::download(new PurchasesExport, 'purchases.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new PurchasesImport, $request->file('file'));
        return redirect()->route('purchases.index')->with('success', __('Purchases imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SamplePurchasesExport, 'sample-purchases.xlsx');
    }
}
