<?php
namespace App\Http\Controllers;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpenseCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ExpenseCategory::withCount('expenses')->latest())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->hasPermission('expense-categories.edit')) {
                        $btn .= '<a href="'.route('expense-categories.edit', $row).'" class="btn btn-sm btn-warning" title="'.__('Edit').'"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->hasPermission('expense-categories.delete')) {
                        $btn .= ' <form action="'.route('expense-categories.destroy', $row).'" method="POST" class="d-inline" onsubmit="return confirm(\''.__('Are you sure?').'\')">
                                '.csrf_field().method_field('DELETE').'
                                <button class="btn btn-sm btn-danger" title="'.__('Delete').'"><i class="bi bi-trash"></i></button>
                            </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])->make(true);
        }
        return view('expense-categories.index');
    }

    public function create() { return view('expense-categories.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:expense_categories,name']);
        ExpenseCategory::create($request->only('name'));
        return redirect()->route('expense-categories.index')->with('success', __('Expense category created successfully.'));
    }

    public function edit(ExpenseCategory $expense_category) { return view('expense-categories.edit', compact('expense_category')); }

    public function update(Request $request, ExpenseCategory $expense_category)
    {
        $request->validate(['name' => 'required|string|max:255|unique:expense_categories,name,'.$expense_category->id]);
        $expense_category->update($request->only('name'));
        return redirect()->route('expense-categories.index')->with('success', __('Expense category updated successfully.'));
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $expense_category->delete();
        return redirect()->route('expense-categories.index')->with('success', __('Expense category deleted successfully.'));
    }
}
