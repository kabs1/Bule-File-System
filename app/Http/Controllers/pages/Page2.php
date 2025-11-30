<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\LotManagement;
use App\Models\InwardManagement;
use App\Models\Purchase;
use App\Models\LabResult;
use App\Models\MeltRecord;

class Page2 extends Controller
{
  public function index()
  {
    $selectedBranchId = Session::get('selected_branch_id', 'all');
    $allBranches = Branch::all();

    // Initialize query builders
    $customersQuery = Customer::query();
    $lotsQuery = LotManagement::query();
    $inwardsQuery = InwardManagement::query();
    $purchasesQuery = Purchase::query();
    $labResultsQuery = LabResult::query();
    $meltRecordsQuery = MeltRecord::query();

    // Apply branch filtering if a specific branch is selected
    if ($selectedBranchId !== 'all') {
        // Assuming these models have a 'branch_id' column
        $customersQuery->where('branch_id', $selectedBranchId);
        $lotsQuery->where('branch_id', $selectedBranchId);
        $inwardsQuery->where('branch_id', $selectedBranchId);
        $purchasesQuery->where('branch_id', $selectedBranchId);
        $labResultsQuery->where('branch_id', $selectedBranchId);
        $meltRecordsQuery->where('branch_id', $selectedBranchId);
    }

    // Fetch aggregated data
    $totalCustomers = $customersQuery->count();
    $totalLots = $lotsQuery->count();
    $totalInwards = $inwardsQuery->count();
    $openInwards = $inwardsQuery->where('status', 'open')->count(); // Assuming 'status' column and 'open' value
    $totalPurchases = $purchasesQuery->count();
    $totalTested = $labResultsQuery->count();
    $totalMelted = $meltRecordsQuery->count();


    return view('content.pages.pages-page2', compact(
        'selectedBranchId',
        'allBranches',
        'totalCustomers',
        'totalLots',
        'totalInwards',
        'openInwards',
        'totalPurchases',
        'totalTested',
        'totalMelted'
    ));
  }
}
