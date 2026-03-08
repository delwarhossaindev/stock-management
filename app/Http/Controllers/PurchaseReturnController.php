<?php
namespace App\Http\Controllers;
use App\Models\PurchaseReturn;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseReturnController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PurchaseReturn::with(['purchase', 'product'])->latest())
                ->addIndexColumn()
                ->addColumn('purchase_no', fn($row) => $row->purchase->purchase_no ?? '-')
                ->addColumn('product_name', fn($row) => $row->product->name ?? '-')
                ->addColumn('date_fmt', fn($row) => $row->return_date->format('d/m/Y'))
                ->addColumn('amount_fmt', fn($row) => '৳'.number_format($row->amount, 2))
                ->addColumn('action', fn($row) => '<a href="'.route('purchase-returns.show', $row).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>')
                ->rawColumns(['action'])->make(true);
        }
        return view('purchase-returns.index');
    }

    public function create()
    {
        $purchases = Purchase::with('items.product')->latest()->get();
        return view('purchase-returns.create', compact('purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'return_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::find($request->product_id);
            $amount = $request->quantity * $product->buy_price;
            PurchaseReturn::create(array_merge($request->only('purchase_id', 'product_id', 'quantity', 'reason', 'return_date'), ['amount' => $amount]));
            $product->decrement('quantity', $request->quantity);
        });

        return redirect()->route('purchase-returns.index')->with('success', __('Purchase return created successfully.'));
    }

    public function show(PurchaseReturn $purchase_return)
    {
        $purchase_return->load('purchase', 'product');
        return view('purchase-returns.show', compact('purchase_return'));
    }
}
