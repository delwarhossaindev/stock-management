<?php
namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $expenses = Expense::with('category')->latest();
            return DataTables::of($expenses)
                ->addIndexColumn()
                ->addColumn('category_name', fn($row) => $row->category->name ?? '-')
                ->addColumn('date_fmt', fn($row) => $row->expense_date->format('d/m/Y'))
                ->addColumn('amount_fmt', fn($row) => '৳'.number_format($row->amount, 2))
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('expenses.edit')) {
                        $btn .= '<a href="'.route('expenses.edit', $row).'" class="btn btn-sm btn-warning" title="'.__('Edit').'"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->can('expenses.delete')) {
                        $btn .= ' <form action="'.route('expenses.destroy', $row).'" method="POST" class="d-inline" onsubmit="return confirm(\''.__('Are you sure?').'\')">
                                '.csrf_field().method_field('DELETE').'
                                <button class="btn btn-sm btn-danger" title="'.__('Delete').'"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])->make(true);
        }
        return view('expenses.index');
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        Expense::create($request->only('expense_category_id', 'amount', 'expense_date', 'description'));
        return redirect()->route('expenses.index')->with('success', __('Expense created successfully.'));
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $expense->update($request->only('expense_category_id', 'amount', 'expense_date', 'description'));
        return redirect()->route('expenses.index')->with('success', __('Expense updated successfully.'));
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', __('Expense deleted successfully.'));
    }
}
