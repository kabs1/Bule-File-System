<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Branch; // Import the Branch model
use App\Models\User; // Import the User model for created_by relationship
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all(); // Fetch all branches for the form
        $totalCustomers = Customer::count();
        $customerStatusCounts = [
            'Active' => Customer::where('status', 2)->count(),
            'Pending' => Customer::where('status', 1)->count(),
            'Inactive' => Customer::where('status', 3)->count(),
        ];

        return view('content.customer.list', compact('branches', 'totalCustomers', 'customerStatusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used for offcanvas forms
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'contact' => 'required|string|max:255',
            'branch_id' => 'required|integer|exists:branches,branch_id',
        ]);

        $customer = Customer::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'status' => 2,
            'user_id' => Auth::id(),
            'branch_id' => $validatedData['branch_id'],
        ]);

        return response()->json(['message' => 'Customer created successfully.', 'customer' => $customer], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'id' => $customer->customer_id,
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'contact' => $customer->contact,
            'status' => $customer->status,
            'branch_id' => $customer->branch_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        // Not used for offcanvas forms, data fetched via show method
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($customer->customer_id, 'customer_id')],
            'contact' => 'required|string|max:255',
            'branch_id' => 'required|integer|exists:branches,branch_id',
        ]);

        $customer->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'contact' => $validatedData['contact'],
            'branch_id' => $validatedData['branch_id'],
        ]);

        return response()->json(['message' => 'Customer updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully.']);
    }

    /**
     * Suspend the specified customer.
     */
    public function suspend(Customer $customer): JsonResponse
    {
        $customer->status = 3; // Assuming 3 is for Inactive/Suspended
        $customer->save();
        return response()->json(['message' => 'Customer suspended successfully.']);
    }

    /**
     * Activate the specified customer.
     */
    public function activate(Customer $customer): JsonResponse
    {
        $customer->status = 2; // Assuming 2 is for Active
        $customer->save();
        return response()->json(['message' => 'Customer activated successfully.']);
    }

    /**
     * List customers for DataTables.
     */
    public function list(Request $request): JsonResponse
    {
        $customers = Customer::with(['creator', 'branch'])->get();
        $data = [];
        foreach ($customers as $customer) {
            $fullName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));
            $data[] = [
                'id' => $customer->customer_id,
                'full_name' => $fullName,
                'email' => $customer->email,
                'contact' => $customer->contact,
                'avatar' => null, // Assuming no avatar for customers yet
                'status' => $customer->status,
                'created_by' => $customer->creator ? ($customer->creator->first_name . ' ' . $customer->creator->last_name) : 'N/A',
                'branch' => $customer->branch ? $customer->branch->branch_name : 'N/A',
        
                'action' => ''
            ];
        }
        return response()->json(['data' => $data]);
    }
}
