<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $warehouses = Warehouse::withCount('products')->latest();
            return DataTables::of($warehouses)
                ->addIndexColumn()
                ->addColumn('products_count_badge', function ($row) {
                    return '<span class="badge bg-info">' . $row->products_count . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->hasPermission('warehouses.edit')) {
                        $edit = route('warehouses.edit', $row);
                        $btn .= '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->hasPermission('warehouses.delete')) {
                        $delete = route('warehouses.destroy', $row);
                        $btn .= ' <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['products_count_badge', 'action'])
                ->make(true);
        }
        return view('warehouses.index');
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('success', __('Warehouse created successfully.'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('success', __('Warehouse updated successfully.'));
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', __('Warehouse deleted successfully.'));
    }
}
