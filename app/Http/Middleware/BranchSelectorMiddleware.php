<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Branch; // Import the Branch model
use Illuminate\Support\Facades\Session; // Import Session facade
use Symfony\Component\HttpFoundation\Response;

class BranchSelectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If a branch_id is passed in the request, store it in the session
        if ($request->has('branch_id')) {
            $branchId = $request->input('branch_id');
            // Validate if the branch exists
            if ($branchId === 'all' || Branch::where('branch_id', $branchId)->exists()) {
                Session::put('selected_branch_id', $branchId);
            } else {
                // If an invalid branch_id is provided, default to 'all'
                Session::put('selected_branch_id', 'all');
            }
        }

        // If no branch is selected in the session, default to 'all'
        if (!Session::has('selected_branch_id')) {
            Session::put('selected_branch_id', 'all');
        }

        return $next($request);
    }
}
