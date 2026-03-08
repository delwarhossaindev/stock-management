<?php
namespace App\Http\Controllers;
use App\Models\StockAdjustment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(StockAdjustment::with('product')->latest())
                ->addIndexColumn()
                ->addColumn('product_name', fn($row) => $row->product->name ?? '-')
                ->addColumn('date_fmt', fn($row) => $row->adjustment_date->format('d/m/Y'))
                ->addColumn('type_badge', function($row) {
                    $class = $row->type === 'addition' ? 'bg-success' : 'bg-danger';
                    $label = $row->type === 'addition' ? __('Addition') : __('Subtraction');
                    return '<span class="badge '.$class.'">'.$label.'</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="'.route('stock-adjustments.show', $row).'" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>';
                })
                ->rawColumns(['type_badge', 'action'])->make(true);
        }
        return view('stock-adjustments.index');
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stock-adjustments.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:addition,subtraction',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'adjustment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            StockAdjustment::create($request->only('product_id', 'type', 'quantity', 'reason', 'adjustment_date'));
            $product = Product::find($request->product_id);
            if ($request->type === 'addition') {
                $product->increment('quantity', $request->quantity);
            } else {
                $product->decrement('quantity', $request->quantity);
            }
        });

        return redirect()->route('stock-adjustments.index')->with('success', __('Stock adjusted successfully.'));
    }

    public function show(StockAdjustment $stock_adjustment)
    {
        $stock_adjustment->load('product');
        return view('stock-adjustments.show', compact('stock_adjustment'));
    }
}
