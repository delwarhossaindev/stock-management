<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Brand::withCount('products')->latest())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('brands.show', $row).'" class="btn btn-sm btn-info" title="'.__('View').'" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>';
                    if (auth()->user()->hasPermission('brands.edit')) {
                        $btn .= ' <a href="'.route('brands.edit', $row).'" class="btn btn-sm btn-warning" title="'.__('Edit').'" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->hasPermission('brands.delete')) {
                        $btn .= ' <form action="'.route('brands.destroy', $row).'" method="POST" class="d-inline" onsubmit="return confirm(\''.__('Are you sure?').'\')">
                                '.csrf_field().method_field('DELETE').'
                                <button class="btn btn-sm btn-danger" title="'.__('Delete').'" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('brands.index');
    }

    public function create() { return view('brands.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:brands,name', 'description' => 'nullable|string']);
        Brand::create($request->only('name', 'description'));
        return redirect()->route('brands.index')->with('success', __('Brand created successfully.'));
    }

    public function show(Brand $brand)
    {
        $brand->loadCount('products');
        return view('brands.show', compact('brand'));
    }

    public function edit(Brand $brand) { return view('brands.edit', compact('brand')); }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required|string|max:255|unique:brands,name,'.$brand->id, 'description' => 'nullable|string']);
        $brand->update($request->only('name', 'description'));
        return redirect()->route('brands.index')->with('success', __('Brand updated successfully.'));
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', __('Brand deleted successfully.'));
    }
}
