<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Exports\SampleSalesExport;
use App\Imports\SalesImport;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sales = Sale::with('customer')->withCount('items')->latest();
            return DataTables::of($sales)
                ->addIndexColumn()
                ->addColumn('date_fmt', fn($row) => $row->sale_date->format('d/m/Y'))
                ->editColumn('invoice_no', fn($row) => '<strong>' . $row->invoice_no . '</strong>')
                ->addColumn('customer_display', fn($row) => $row->customer->name ?? ($row->customer_name ?? '-'))
                ->addColumn('subtotal_fmt', fn($row) => '৳' . number_format($row->subtotal, 2))
                ->addColumn('discount_fmt', fn($row) => '৳' . number_format($row->discount, 2))
                ->addColumn('total_price_fmt', fn($row) => '<strong>৳' . number_format($row->total_price, 2) . '</strong>')
                ->addColumn('paid_fmt', fn($row) => '৳' . number_format($row->paid_amount, 2))
                ->addColumn('due_fmt', function ($row) {
                    $color = $row->due_amount > 0 ? 'text-danger' : 'text-success';
                    return '<span class="' . $color . '">৳' . number_format($row->due_amount, 2) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $show = route('sales.show', $row);
                    $btn = '<a href="' . $show . '" class="btn btn-sm btn-info" title="' . __('View') . '" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>';
                    if (auth()->user()->isAdmin()) {
                        $edit = route('sales.edit', $row);
                        $delete = route('sales.destroy', $row);
                        $btn .= ' <a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>
                            <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Delete this sale? Stock will be adjusted.') . '\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['invoice_no', 'total_price_fmt', 'due_fmt', 'action'])
                ->make(true);
        }
        return view('sales.index');
    }

    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $customers = Customer::orderBy('name')->get();
        $invoiceNo = Sale::generateInvoiceNo();
        return view('sales.create', compact('products', 'customers', 'invoiceNo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'sale_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.sell_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['sell_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sell_price' => $item['sell_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subtotal - $discount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalPrice - $paidAmount;

            $sale = Sale::create([
                'invoice_no' => Sale::generateInvoiceNo(),
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_price' => $totalPrice,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'sale_date' => $request->sale_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $sale->items()->create($itemData);
                Product::find($itemData['product_id'])->decrement('quantity', $itemData['quantity']);
            }
        });

        return redirect()->route('sales.index')->with('success', __('Sale saved successfully. Stock updated.'));
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $sale->load('items');
        $products = Product::all();
        $customers = Customer::orderBy('name')->get();
        return view('sales.edit', compact('sale', 'products', 'customers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'nullable|string|max:255',
            'sale_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.sell_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $sale) {
            // Reverse old stock
            foreach ($sale->items as $oldItem) {
                Product::find($oldItem->product_id)->increment('quantity', $oldItem->quantity);
            }
            $sale->items()->delete();

            $subtotal = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $lineTotal = $item['quantity'] * $item['sell_price'];
                $subtotal += $lineTotal;
                $itemsData[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sell_price' => $item['sell_price'],
                    'total' => $lineTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $totalPrice = $subtotal - $discount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalPrice - $paidAmount;

            $sale->update([
                'customer_id' => $request->customer_id,
                'customer_name' => $request->customer_name,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_price' => $totalPrice,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'sale_date' => $request->sale_date,
                'note' => $request->note,
            ]);

            foreach ($itemsData as $itemData) {
                $sale->items()->create($itemData);
                Product::find($itemData['product_id'])->decrement('quantity', $itemData['quantity']);
            }
        });

        return redirect()->route('sales.index')->with('success', __('Sale updated successfully.'));
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                Product::find($item->product_id)->increment('quantity', $item->quantity);
            }
            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', __('Sale deleted. Stock adjusted.'));
    }

    public function export()
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new SalesImport, $request->file('file'));
        return redirect()->route('sales.index')->with('success', __('Sales imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleSalesExport, 'sample-sales.xlsx');
    }
}
