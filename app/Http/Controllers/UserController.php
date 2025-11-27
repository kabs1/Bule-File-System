<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch; // Import the Branch model
use Illuminate\Http\JsonResponse;
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
            $roleName = $user->roles->pluck('name')->first() ?? '';
            $data[] = [
                'id' => $user->user_id,
                'full_name' => $fullName,
                'email' => $user->email,
                'avatar' => null,
                'role' => $roleName,
                'status' => $user->status,
                'created_by' => $user->creator ? ($user->creator->first_name . ' ' . $user->creator->last_name) : 'N/A',
                'branch' => $user->branch ? $user->branch->branch_name : 'N/A',
                'action' => ''
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function show(User $user): JsonResponse
    {
        $user->load(['roles']);
        return response()->json([
            'id' => $user->user_id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->roles->pluck('name')->first(), // Send single role name
            'branch_id' => $user->branch_id,
            'status' => $user->status,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where(function ($query) {
                    $query->where('guard_name', config('auth.defaults.guard'));
                }),
            ],
            'branch_id' => 'required|integer|exists:branches,branch_id',
        ]);

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'username' => $validatedData['email'], // Consider if username is needed
            'password' => Hash::make($validatedData['password']),
            'status' => 2, // Assuming 2 = Active
            'created_by_user_id' => auth()->id(),
            'branch_id' => $validatedData['branch_id'],
            // Do NOT set role_id here. Spatie/permission handles this.
        ]);

        $user->assignRole($validatedData['role']);

        return response()->json(['message' => 'User created successfully.', 'user' => $user], 201);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where(function ($query) {
                    $query->where('guard_name', config('auth.defaults.guard'));
                }),
            ],
            'branch_id' => 'required|integer|exists:branches,branch_id',
        ]);

        $user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'branch_id' => $validatedData['branch_id'],
        ]);

        $user->syncRoles($validatedData['role']);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function suspend(User $user): JsonResponse
    {
        $user->status = 3;
        $user->save();
        return response()->json(['message' => 'User suspended successfully.']);
    }

    public function activate(User $user): JsonResponse
    {
        $user->status = 2;
        $user->save();
        return response()->json(['message' => 'User activated successfully.']);
    }
}
