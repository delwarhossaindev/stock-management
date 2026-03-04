<?php

namespace App\Http\Controllers;

use App\Exports\SampleSuppliersExport;
use App\Exports\SuppliersExport;
use App\Imports\SuppliersImport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = Supplier::latest();
            return DataTables::of($suppliers)
                ->addIndexColumn()
                ->editColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                ->editColumn('phone', function ($row) {
                    return $row->phone ?? '-';
                })
                ->addColumn('address_short', function ($row) {
                    return \Str::limit($row->address, 40) ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $edit = route('suppliers.edit', $row);
                    $delete = route('suppliers.destroy', $row);
                    return '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>
                        <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('suppliers.index');
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', __('Supplier created successfully.'));
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('purchases.items.product');
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', __('Supplier updated successfully.'));
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', __('Supplier deleted successfully.'));
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $supplier = Supplier::create($request->only('name', 'phone'));
        return response()->json(['id' => $supplier->id, 'name' => $supplier->name]);
    }

    public function export()
    {
        return Excel::download(new SuppliersExport, 'suppliers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new SuppliersImport, $request->file('file'));
        return redirect()->route('suppliers.index')->with('success', __('Suppliers imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleSuppliersExport, 'sample-suppliers.xlsx');
    }
}
