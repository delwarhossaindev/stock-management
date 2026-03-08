<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->latest();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role_badge', function ($row) {
                    $roleName = $row->roles->first()->name ?? 'user';
                    $class = $roleName === 'admin' ? 'bg-danger' : 'bg-secondary';
                    return '<span class="badge ' . $class . '">' . __(e($roleName)) . '</span>';
                })
                ->addColumn('joined', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('users.edit')) {
                        $edit = route('users.edit', $row);
                        $btn .= '<a href="' . $edit . '" class="btn btn-sm btn-warning" title="' . __('Edit') . '" data-bs-toggle="tooltip"><i class="bi bi-pencil"></i></a>';
                    }
                    if (auth()->user()->can('users.delete') && $row->id !== auth()->id()) {
                        $delete = route('users.destroy', $row);
                        $btn .= ' <form action="' . $delete . '" method="POST" class="d-inline" onsubmit="return confirm(\'' . __('Are you sure?') . '\')">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger" title="' . __('Delete') . '" data-bs-toggle="tooltip"><i class="bi bi-trash"></i></button>
                        </form>';
                    }
                    return $btn;
                })
                ->rawColumns(['role_badge', 'action'])
                ->make(true);
        }
        return view('users.index');
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        return view('users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($request->permissions) {
            $user->syncPermissions(Permission::whereIn('id', $request->permissions)->get());
        }

        return redirect()->route('users.index')->with('success', __('User created successfully.'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        $userPermissionIds = $user->getDirectPermissions()->pluck('id')->toArray();
        return view('users.edit', compact('user', 'roles', 'permissions', 'userPermissionIds'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        $user->syncRoles($request->role);
        $user->syncPermissions(Permission::whereIn('id', $request->permissions ?? [])->get());

        return redirect()->route('users.index')->with('success', __('User updated successfully.'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', __('You cannot delete yourself.'));
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
    }
}
