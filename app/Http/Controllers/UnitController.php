<?php

namespace App\Http\Controllers;

use App\Exports\SampleUnitsExport;
use App\Exports\UnitsExport;
use App\Imports\UnitsImport;
use App\Models\Unit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::withCount('products')->latest();
            return DataTables::of($units)
                ->addIndexColumn()
                ->addColumn('products_count_badge', function ($row) {
                    $url = route('products.index', ['unit_id' => $row->id]);
                    return '<a href="' . $url . '" target="_blank"><span class="badge bg-info">' . $row->products_count . '</span></a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->hasPermission('units.edit')) {
                        $edit = route('units.edit', $row);
                        $btn .= '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->hasPermission('units.delete')) {
                        $delete = route('units.destroy', $row);
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
        return view('units.index');
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Unit::create($request->all());
        return redirect()->route('units.index')->with('success', __('Unit created successfully.'));
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $unit->update($request->all());
        return redirect()->route('units.index')->with('success', __('Unit updated successfully.'));
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', __('Unit deleted successfully.'));
    }

    public function export()
    {
        return Excel::download(new UnitsExport, 'units.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new UnitsImport, $request->file('file'));
        return redirect()->route('units.index')->with('success', __('Units imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleUnitsExport, 'sample-units.xlsx');
    }
}
