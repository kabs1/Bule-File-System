<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Spatie\Permission\Guard; // Import the Guard class
use Illuminate\Support\Facades\Log; // Import the Log facade

class RoleController extends Controller
{
    public function index()
    {
        // Debugging: Check what getModelForGuard returns
        // Debugging: Check what getModelForGuard returns
        // Debugging: Check what getModelForGuard returns
        $userModelClass = Guard::getModelForGuard(config('auth.defaults.guard'));
        Log::info('User Model Class resolved by Spatie Guard: ' . $userModelClass);
        Log::info('Auth Guards: ' . json_encode(config('auth.guards')));
        Log::info('Auth Providers: ' . json_encode(config('auth.providers')));
        // dd('User Model Class resolved by Spatie Guard: ' . $userModelClass); // Temporarily dump to see the value

        $roles = Role::all(); // Temporarily remove withCount('users')
        $permissions = Permission::all(); // Fetch all permissions for the modal
        return view('content.pages.roles', compact('roles', 'permissions'));
    }

    public function list(Request $request)
    {
        $roles = Role::all(); // Temporarily remove withCount('users')
        $data = [];
        foreach ($roles as $role) {
            $data[] = [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'users_count' => 0, // Placeholder since withCount is removed
                'actions' => '' // Actions will be rendered by DataTables
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->roleName]);
        $role->syncPermissions($request->permissions);

        return response()->json(['message' => 'Role created successfully.']);
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'roleName' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->update(['name' => $request->roleName]);
        $role->syncPermissions($request->permissions);

        return response()->json(['message' => 'Role updated successfully.']);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
