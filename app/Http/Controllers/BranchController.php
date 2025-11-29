<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Validation\Rule;
use App\Models\User; // Import the User model

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branches = Branch::all();
        if ($request->ajax() || $request->wantsJson()) {
            $data = $branches->map(function ($b) {
                return [
                    'id' => $b->branch_id,
                    'name' => $b->branch_name,
                    'location' => $b->description ?? '', // Convert null to empty string for display
                    'status' => $b->status, // Add status to the data
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('content.pages.branches', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for API-driven CRUD
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:branches,branch_name',
            'location' => 'nullable|string|max:255',
        ]);

        Branch::create([
            'branch_name' => $request->name,
            'description' => $request->location,
            'user_id' => auth()->id(),
            'status' => 1, // Default status to 1 (active)
        ]);

        return response()->json(['message' => 'Branch created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return response()->json([
            'id' => $branch->branch_id,
            'name' => $branch->branch_name,
            'location' => $branch->description,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return response()->json([
            'id' => $branch->branch_id,
            'name' => $branch->branch_name,
            'location' => $branch->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('branches', 'branch_name')->ignore($branch->branch_id, 'branch_id')],
            'location' => 'nullable|string|max:255',
        ]);

        $branch->update([
            'branch_name' => $request->name,
            'description' => $request->location,
            'user_id' => auth()->id(),
            'status' => $branch->status ?? 2,
        ]);

        return response()->json(['message' => 'Branch updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response()->json(['message' => 'Branch deleted successfully.']);
    }

    /**
     * Deactivate the specified branch and its associated users.
     */
    public function deactivate(Branch $branch): \Illuminate\Http\JsonResponse
    {
        // Deactivate the branch
        $branch->status = 3; // Assuming 3 is for Inactive/Deactivated
        $branch->save();

        // Deactivate all users associated with this branch
        $branch->users()->update(['status' => 3]);

        return response()->json(['message' => 'Branch and associated users deactivated successfully.']);
    }

    /**
     * Activate the specified branch and its associated users.
     */
    public function activate(Branch $branch): \Illuminate\Http\JsonResponse
    {
        // Activate the branch
        $branch->status = 2; // Assuming 2 is for Active
        $branch->save();

        // Activate all users associated with this branch
        $branch->users()->update(['status' => 2]);

        return response()->json(['message' => 'Branch and associated users activated successfully.']);
    }
}
