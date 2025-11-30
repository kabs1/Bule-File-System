@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $containerNav = $configData['contentLayout'] === 'compact' ? 'container-xxl' : 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
        @include('layouts/sections/navbar/navbar-partial')
    </nav>
@else
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
            @include('layouts/sections/navbar/navbar-partial')
            @php
                $settings = App\Models\Setting::all()->keyBy('key');
                $systemName = $settings['system_name']->value ?? config('variables.templateName');
                $systemLogo = $settings['system_logo']->value ?? asset('assets/img/logo.png'); // Default logo path
            @endphp
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                    <img src="{{ $systemLogo }}" alt="System Logo" height="25">
                </span>
                <span class="app-brand-text demo menu-text fw-bold ms-2">{{ $systemName }}</span>
            </a>
            @php
                $allBranches = App\Models\Branch::all();
                $selectedBranchId = Session::get('selected_branch_id', 'all');
            @endphp
            @include('layouts/sections/navbar/branch-selector', ['allBranches' => $allBranches, 'selectedBranchId' => $selectedBranchId])
        </div>
    </nav>
@endif
<!-- / Navbar -->
