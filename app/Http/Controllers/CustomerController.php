<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\SampleCustomersExport;
use App\Imports\CustomersImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::latest();
            return DataTables::of($customers)
                ->addIndexColumn()
                ->editColumn('email', fn($row) => $row->email ?? '-')
                ->editColumn('phone', fn($row) => $row->phone ?? '-')
                ->addColumn('address_short', fn($row) => \Str::limit($row->address, 40) ?? '-')
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('customers.edit')) {
                        $edit = route('customers.edit', $row);
                        $btn .= '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->can('customers.delete')) {
                        $delete = route('customers.destroy', $row);
                        $btn .= ' <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('customers.index');
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', __('Customer created successfully.'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', __('Customer updated successfully.'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', __('Customer deleted successfully.'));
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer = Customer::create($request->only('name', 'phone'));
        return response()->json(['id' => $customer->id, 'name' => $customer->name]);
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new CustomersImport, $request->file('file'));
        return redirect()->route('customers.index')->with('success', __('Customers imported successfully.'));
    }

    public function sampleExport()
    {
        return Excel::download(new SampleCustomersExport, 'sample-customers.xlsx');
    }
}
