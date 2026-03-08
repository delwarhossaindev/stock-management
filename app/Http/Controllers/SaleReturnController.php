<?php
namespace App\Http\Controllers;
use App\Models\SaleReturn;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SaleReturnController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SaleReturn::with(['sale', 'product'])->latest())
                ->addIndexColumn()
                ->addColumn('invoice_no', fn($row) => $row->sale->invoice_no ?? '-')
                ->addColumn('product_name', fn($row) => $row->product->name ?? '-')
                ->addColumn('date_fmt', fn($row) => $row->return_date->format('d/m/Y'))
                ->addColumn('amount_fmt', fn($row) => '৳'.number_format($row->amount, 2))
                ->addColumn('action', fn($row) => '<a href="'.route('sale-returns.show', $row).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>')
                ->rawColumns(['action'])->make(true);
        }
        return view('sale-returns.index');
    }

    public function create()
    {
        $sales = Sale::with('items.product')->latest()->get();
        return view('sale-returns.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'return_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);
            $amount = $request->quantity * $product->sell_price;
            SaleReturn::create(array_merge($request->only('sale_id', 'product_id', 'quantity', 'reason', 'return_date'), ['amount' => $amount]));
            $product->increment('quantity', $request->quantity);
        });

        return redirect()->route('sale-returns.index')->with('success', __('Sale return created successfully.'));
    }

    public function show(SaleReturn $sale_return)
    {
        $sale_return->load('sale', 'product');
        return view('sale-returns.show', compact('sale_return'));
    }
}
