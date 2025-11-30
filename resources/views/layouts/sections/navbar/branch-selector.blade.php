@php
    use Illuminate\Support\Facades\Session;
@endphp

<div class="navbar-nav align-items-center ms-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <span class="d-none d-sm-inline-block">Branch: {{ $selectedBranchId === 'all' ? 'All Branches' : ($allBranches->firstWhere('branch_id', $selectedBranchId)->branch_name ?? 'Select Branch') }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}?branch_id=all">
                    All Branches
                </a>
            </li>
            @foreach ($allBranches as $branch)
                <li>
                    <a class="dropdown-item" href="{{ route('dashboard') }}?branch_id={{ $branch->branch_id }}">
                        {{ $branch->branch_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
</div>
