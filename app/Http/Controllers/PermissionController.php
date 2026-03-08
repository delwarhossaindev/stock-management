<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::withCount('roles')->orderBy('name');
            return DataTables::of($permissions)
                ->addIndexColumn()
                ->addColumn('group_display', function ($row) {
                    $group = explode('.', $row->name)[0];
                    return '<span class="badge bg-secondary">' . e($group) . '</span>';
                })
                ->addColumn('roles_count_badge', function ($row) {
                    return '<span class="badge bg-primary">' . $row->roles_count . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('permissions.edit')) {
                        $btn .= '<a href="' . route('permissions.edit', $row) . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a> ';
                    }
                    if (auth()->user()->can('permissions.delete')) {
                        $delete = route('permissions.destroy', $row);
                        $btn .= '<form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                    }
                    return $btn ?: '-';
                })
                ->rawColumns(['group_display', 'roles_count_badge', 'action'])
                ->make(true);
        }
        return view('permissions.index');
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name, 'guard_name' => 'web']);

        return redirect()->route('permissions.index')->with('success', __('Permission created successfully.'));
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', __('Permission updated successfully.'));
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', __('Permission deleted successfully.'));
    }
}
