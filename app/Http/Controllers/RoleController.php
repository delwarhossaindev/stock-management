<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::withCount(['users', 'permissions'])->latest();
            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('name_display', function ($row) {
                    $badge = $row->name === 'admin' ? ' <span class="badge bg-danger">' . __('Protected') . '</span>' : '';
                    return '<strong>' . e($row->name) . '</strong>' . $badge;
                })
                ->addColumn('users_count_badge', function ($row) {
                    return '<span class="badge bg-primary">' . $row->users_count . '</span>';
                })
                ->addColumn('permissions_count_badge', function ($row) {
                    return '<span class="badge bg-success">' . $row->permissions_count . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('roles.edit')) {
                        $edit = route('roles.edit', $row);
                        $btn .= '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a> ';
                    }
                    if (auth()->user()->can('roles.delete') && $row->name !== 'admin') {
                        $delete = route('roles.destroy', $row);
                        $btn .= '<form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['name_display', 'users_count_badge', 'permissions_count_badge', 'action'])
                ->make(true);
        }
        return view('roles.index');
    }

    public function create()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        if ($request->permissions) {
            $role->syncPermissions(Permission::whereIn('id', $request->permissions)->get());
        }

        return redirect()->route('roles.index')->with('success', __('Role created successfully.'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);

        if ($role->name === 'admin') {
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions(Permission::whereIn('id', $request->permissions ?? [])->get());
        }

        return redirect()->route('roles.index')->with('success', __('Role updated successfully.'));
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', __('This role cannot be deleted.'));
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('error', __('Cannot delete role with assigned users.'));
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', __('Role deleted successfully.'));
    }
}
