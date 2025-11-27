<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Spatie\Permission\Guard; // Import the Guard class
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all(); // Temporarily fetch all roles without eager loading users
        $permissions = Permission::all(); // Fetch all permissions for the modal
        return view('content.pages.roles', compact('roles', 'permissions'));
    }

    public function list(Request $request)
    {
        if (!auth()->user()->can('view role')) {
            abort(403);
        }
        $roles = Role::all();
        $authGuards = array_keys(config('auth.guards'));
        $data = [];
        foreach ($roles as $role) {
            $guard = $role->guard_name ?: config('auth.defaults.guard');
            $usersCount = 0;
            if (in_array($guard, $authGuards)) {
                $usersCount = DB::table(config('permission.table_names.model_has_roles'))
                    ->where('role_id', $role->id)
                    ->where('model_type', User::class)
                    ->count();
            }
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $guard,
                'users_count' => $usersCount,
                'actions' => ''
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->can('create role')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validator = Validator::make($request->all(), [
            'roleName' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = Role::create(['name' => $request->roleName]);
        $selected = collect($request->permissions ?? []);
        $permModels = Permission::whereIn('name', $selected)->where('guard_name', $role->guard_name)->get();
        $role->syncPermissions($permModels);

        return response()->json(['message' => 'Role created successfully.']);
    }

    public function show(Role $role)
    {
        if (!auth()->user()->can('view role')) {
            abort(403);
        }
        $role->load('permissions');
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        if (!auth()->user() || !auth()->user()->can('update role')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validator = Validator::make($request->all(), [
            'roleName' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role->update(['name' => $request->roleName]);
        $selected = collect($request->permissions ?? []);
        $permModels = Permission::whereIn('name', $selected)->where('guard_name', $role->guard_name)->get();
        $role->syncPermissions($permModels);

        return response()->json(['message' => 'Role updated successfully.']);
    }

    public function destroy(Role $role)
    {
        if (!auth()->user()->can('delete role')) {
            abort(403);
        }
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
