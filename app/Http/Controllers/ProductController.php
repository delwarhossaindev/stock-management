<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\SampleProductsExport;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category', 'unit')->latest();
            if ($request->filled('category_id')) {
                $products->where('category_id', $request->category_id);
            }
            if ($request->filled('unit_id')) {
                $products->where('unit_id', $request->unit_id);
            }
            return DataTables::of($products)
                ->addIndexColumn()
                ->editColumn('barcode', function ($row) {
                    return $row->barcode ?? '-';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->addColumn('buy_price_fmt', function ($row) {
                    return '৳' . number_format($row->buy_price, 2);
                })
                ->addColumn('sell_price_fmt', function ($row) {
                    return '৳' . number_format($row->sell_price, 2);
                })
                ->addColumn('stock_badge', function ($row) {
                    $class = $row->quantity <= 5 ? ($row->quantity == 0 ? 'bg-danger' : 'bg-warning text-dark') : 'bg-success';
                    $unitName = $row->unit->name ?? '';
                    return '<span class="badge ' . $class . '">' . $row->quantity . ' ' . $unitName . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $show = route('products.show', $row);
                    $btn = '<a href="' . $show . '" class="btn btn-sm btn-info" title="' . __('View') . '" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>';
                    if (auth()->user()->hasPermission('products.edit')) {
                        $edit = route('products.edit', $row);
                        $btn .= ' <a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->hasPermission('products.delete')) {
                        $delete = route('products.destroy', $row);
                        $btn .= ' <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['stock_badge', 'action'])
                ->make(true);
        }
        return view('products.index');
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('products.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'description' => 'nullable|string',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['tax_rate'] = $request->tax_rate ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', __('Product created successfully.'));
    }

    public function show(Product $product)
    {
        $product->load('category', 'unit', 'purchaseItems', 'saleItems');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('products.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'description' => 'nullable|string',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'unit_id' => 'required|exists:units,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['tax_rate'] = $request->tax_rate ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', __('Product deleted successfully.'));
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->route('products.index')->with('success', __('Products imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleProductsExport, 'sample-products.xlsx');
    }

    public function barcode(Product $product)
    {
        return view('products.barcode', compact('product'));
    }
}
