<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('content.pages.permissions', compact('permissions'));
    }

    public function list(Request $request)
    {
        if (!auth()->user()->can('view permission')) {
            abort(403);
        }
        $permissions = Permission::all();
        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'actions' => '' // Actions will be rendered by DataTables
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create permission')) {
            abort(403);
        }
        $request->validate([
            'permissionName' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->permissionName]);

        return response()->json(['message' => 'Permission created successfully.']);
    }

    public function show(Permission $permission)
    {
        if (!auth()->user()->can('view permission')) {
            abort(403);
        }
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        if (!auth()->user()->can('update permission')) {
            abort(403);
        }
        $request->validate([
            'permissionName' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
        ]);

        $permission->update(['name' => $request->permissionName]);

        return response()->json(['message' => 'Permission updated successfully.']);
    }

    public function destroy(Permission $permission)
    {
        if (!auth()->user()->can('delete permission')) {
            abort(403);
        }
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
