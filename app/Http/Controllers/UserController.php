<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch; // Import the Branch model
use Spatie\Permission\Models\Role; // Import the Role model
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $branches = Branch::all(); // Fetch all branches

        $totalUsers = User::count();
        $roles = Role::all(); // Get all roles from the database
        $roleCounts = [];
        foreach ($roles as $role) {
            // Only count users for roles that actually exist and have users
            $roleCounts[$role->name] = User::whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role->name);
            })->count();
        }

        return view('content.pages.users', compact('branches', 'totalUsers', 'roleCounts'));
    }

    public function list(Request $request)
    {
        $users = User::with(['roles', 'creator', 'branch'])->get();
        $data = [];
        foreach ($users as $user) {
            $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            $roleName = $user->roles->first()->name ?? 'N/A';
            $data[] = [
                'id' => $user->user_id,
                'full_name' => $fullName !== '' ? $fullName : ($user->username ?? 'N/A'),
                'email' => $user->email,
                'role' => $roleName,
                'status' => $user->status,
                'created_by' => $user->creator ? ($user->creator->first_name . ' ' . $user->creator->last_name) : 'N/A',
                'branch' => $user->branch ? $user->branch->branch_name : 'N/A',
                'avatar' => $user->profile_picture,
                'action' => ''
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function edit(User $user)
    {
        $user->load(['roles', 'branch']);
        $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
        return response()->json([
            'id' => $user->user_id,
            'name' => $fullName !== '' ? $fullName : ($user->username ?? ''),
            'email' => $user->email,
            'roles' => $user->roles->map(fn($r) => ['name' => $r->name]),
            'branch_id' => $user->branch_id,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'userFullname' => 'required|string|max:255',
            'userEmail' => 'required|string|email|max:255|unique:users,email',
            'userContact' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
            'userRole' => 'required|string|exists:roles,name',
            'branchId' => 'required|integer|exists:branches,branch_id',
        ]);

        $names = preg_split('/\s+/', $request->userFullname, -1, PREG_SPLIT_NO_EMPTY);
        $first = $names[0] ?? '';
        $last = isset($names[1]) ? implode(' ', array_slice($names, 1)) : '';

        $user = User::create([
            'first_name' => $first,
            'last_name' => $last,
            'email' => $request->userEmail,
            'contact' => $request->userContact,
            'username' => $request->userEmail,
            'password' => Hash::make($request->password),
            'profile_picture' => null,
            'all_branch_access' => false,
            'role_id' => $request->userRole,
            'status' => 2,
            'created_by_user_id' => auth()->id(),
            'branch_id' => $request->branchId,
        ]);

        $user->assignRole($request->userRole);

        return response()->json(['message' => 'User created successfully.']);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'userFullname' => 'required|string|max:255',
            'userEmail' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'userContact' => 'nullable|string|max:255',
            'userRole' => 'required|string|exists:roles,name',
            'branchId' => 'required|integer|exists:branches,branch_id',
        ]);

        $names = preg_split('/\s+/', $request->userFullname, -1, PREG_SPLIT_NO_EMPTY);
        $first = $names[0] ?? '';
        $last = isset($names[1]) ? implode(' ', array_slice($names, 1)) : '';

        $user->update([
            'first_name' => $first,
            'last_name' => $last,
            'email' => $request->userEmail,
            'contact' => $request->userContact,
            'username' => $request->userEmail,
            'role_id' => $request->userRole,
            'branch_id' => $request->branchId,
        ]);

        $user->syncRoles([$request->userRole]);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 3]);
        return response()->json(['message' => 'User suspended successfully.', 'status' => $user->status]);
    }

    public function activate(User $user)
    {
        $user->update(['status' => 2]);
        return response()->json(['message' => 'User activated successfully.', 'status' => $user->status]);
    }
}
