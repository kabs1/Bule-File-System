<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch; // Import the Branch model
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $branches = Branch::all(); // Fetch all branches
        return view('content.pages.users', compact('branches'));
    }

    public function list(Request $request)
    {
        $users = User::with(['roles', 'creator', 'branch'])->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->profile_photo_path, // Assuming profile photo path is stored here
                'role' => $user->roles->pluck('name')->implode(', '),
                'current_plan' => 'Basic', // Placeholder, update if plans are implemented
                'billing' => 'Auto Debit', // Placeholder
                'status' => 2, // Placeholder: 1=Pending, 2=Active, 3=Inactive
                'created_by' => $user->creator ? $user->creator->name : 'N/A', // Display creator's name
                'branch' => $user->branch ? $user->branch->name : 'N/A', // Display branch name
                'action' => '' // Actions will be rendered by DataTables
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function edit(User $user)
    {
        $user->load('roles');
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $request->validate([
            'userFullname' => 'required|string|max:255',
            'userEmail' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'userRole' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->userFullname,
            'email' => $request->userEmail,
            'password' => Hash::make($request->password),
            'created_by_user_id' => auth()->id(),
            'branch_id' => $request->branchId, // Add branch_id
        ]);

        $user->assignRole($request->userRole);

        return response()->json(['message' => 'User created successfully.']);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'userFullname' => 'required|string|max:255',
            'userEmail' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'userRole' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->userFullname,
            'email' => $request->userEmail,
        ]);

        $user->syncRoles($request->userRole);

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
