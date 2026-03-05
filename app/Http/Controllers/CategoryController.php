<?php

namespace App\Http\Controllers;

use App\Exports\CategoriesExport;
use App\Exports\SampleCategoriesExport;
use App\Imports\CategoriesImport;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::withCount('products')->latest();
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('description_short', function ($row) {
                    return \Str::limit($row->description, 50);
                })
                ->addColumn('products_count_badge', function ($row) {
                    $url = route('products.index', ['category_id' => $row->id]);
                    return '<a href="' . $url . '" target="_blank"><span class="badge bg-info">' . $row->products_count . '</span></a>';
                })
                ->addColumn('action', function ($row) {
                    if (!auth()->user()->isAdmin()) {
                        return '';
                    }
                    $edit = route('categories.edit', $row);
                    $delete = route('categories.destroy', $row);
                    return '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>
                        <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['products_count_badge', 'action'])
                ->make(true);
        }
        return view('categories.index');
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', __('Category created successfully.'));
    }

    public function show(Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', __('Category deleted successfully.'));
    }

    public function export()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new CategoriesImport, $request->file('file'));
        return redirect()->route('categories.index')->with('success', __('Categories imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleCategoriesExport, 'sample-categories.xlsx');
    }
}
