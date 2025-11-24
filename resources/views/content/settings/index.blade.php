@extends('layouts.contentNavbarLayout')

@section('title', 'System Settings')

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Settings /</span> System Settings
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">System Settings</h5>
      <div class="card-body">
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
          @csrf
          @method('POST') {{-- Use POST for update as per route definition --}}

          <div class="mb-3">
            <label for="system_name" class="form-label">System Name</label>
            <input type="text" class="form-control" id="system_name" name="system_name" value="{{ $settings['system_name']->value ?? '' }}">
          </div>

          <div class="mb-3">
            <label for="system_logo" class="form-label">System Logo</label>
            @if (isset($settings['system_logo']) && $settings['system_logo']->value)
              <div class="mb-2">
                <img src="{{ asset($settings['system_logo']->value) }}" alt="System Logo" class="img-thumbnail" width="150">
              </div>
            @endif
            <input type="file" class="form-control" id="system_logo" name="system_logo">
          </div>

          <hr class="my-4">

          <!-- Theming -->
          <div class="template-customizer-theming">
            <h5 class="m-0 px-6 pb-6">
              <span class="bg-label-primary rounded-1 py-1 px-3 small">Theming</span>
            </h5>

            <!-- Theme -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="myTheme" class="form-label d-block mb-2">Theme</label>
              <div class="row px-1">
                @php
                  $themes = [
                    ['name' => 'light', 'title' => 'Light', 'icon' => 'bx bx-sun'],
                    ['name' => 'dark', 'title' => 'Dark', 'icon' => 'bx bx-moon'],
                    ['name' => 'system', 'title' => 'System', 'icon' => 'bx bx-desktop'],
                  ];
                @endphp
                @foreach ($themes as $theme)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-icon mb-0">
                      <label class="form-check-label custom-option-content p-0" for="themeRadioIcon{{ $theme['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          <i class="{{ $theme['icon'] }} icon-base mb-0"></i>
                        </span>
                      </label>
                      <input
                        name="myTheme"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $theme['name'] }}"
                        id="themeRadioIcon{{ $theme['name'] }}"
                        {{ (isset($settings['myTheme']) && $settings['myTheme']->value == $theme['name']) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="themeRadioIcon{{ $theme['name'] }}">{{ $theme['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Skins -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="mySkins" class="form-label d-block mb-2">Skins</label>
              <div class="row px-1">
                @php
                  $skins = [
                    ['name' => 'default', 'title' => 'Default', 'image' => 'skin-default.svg'],
                    ['name' => 'bordered', 'title' => 'Bordered', 'image' => 'skin-border.svg'],
                  ];
                @endphp
                @foreach ($skins as $skin)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="skinRadios{{ $skin['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $skin['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="mySkins"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $skin['name'] }}"
                        id="skinRadios{{ $skin['name'] }}"
                        {{ (isset($settings['mySkins']) && $settings['mySkins']->value == $skin['name']) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="skinRadios{{ $skin['name'] }}">{{ $skin['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Semi Dark -->
            <div class="m-0 px-6 pb-6 w-100 d-flex justify-content-between pe-12">
              <span class="form-label">Semi Dark Menu</span>
              <label class="switch">
                <input type="checkbox" class="switch-input" id="hasSemiDark" name="hasSemiDark" value="1" {{ (isset($settings['hasSemiDark']) && $settings['hasSemiDark']->value == true) ? 'checked' : '' }}>
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
              </label>
            </div>

            <!-- Primary Color -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="primaryColor" class="form-label d-block mb-2">Primary Color (Hex)</label>
              <input type="text" class="form-control" id="primaryColor" name="primaryColor" value="{{ $settings['primaryColor']->value ?? '' }}">
            </div>
            <hr class="m-0 px-6 my-6" />
          </div>
          <!--/ Theming -->

          <!-- Layout -->
          <div class="template-customizer-layout">
            <h5 class="m-0 px-6 pb-6">
              <span class="bg-label-primary rounded-2 py-1 px-3 small">Layout</span>
            </h5>

            <!-- Layout(Menu) -->
            <div class="m-0 px-6 pb-6 d-block">
              <label for="menuCollapsed" class="form-label d-block mb-2">Menu (Navigation)</label>
              <div class="row px-1">
                @php
                  $menuLayouts = [
                    ['name' => 'expanded', 'title' => 'Expanded', 'image' => 'layouts-expanded.svg'],
                    ['name' => 'collapsed', 'title' => 'Collapsed', 'image' => 'layouts-collapsed.svg'],
                  ];
                @endphp
                @foreach ($menuLayouts as $layout)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="layoutsRadios{{ $layout['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $layout['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="menuCollapsed"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $layout['name'] == 'collapsed' ? '1' : '0' }}"
                        id="layoutsRadios{{ $layout['name'] }}"
                        {{ (isset($settings['menuCollapsed']) && $settings['menuCollapsed']->value == ($layout['name'] == 'collapsed')) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="layoutsRadios{{ $layout['name'] }}">{{ $layout['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Header Type -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="headerType" class="form-label d-block mb-2">Header Types</label>
              <div class="row px-1">
                @php
                  $headerTypes = [
                    ['name' => 'fixed', 'title' => 'Fixed', 'image' => 'horizontal-fixed.svg'],
                    ['name' => 'static', 'title' => 'Static', 'image' => 'horizontal-static.svg'],
                  ];
                @endphp
                @foreach ($headerTypes as $header)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="headerRadioIcon{{ $header['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $header['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="headerType"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $header['name'] }}"
                        id="headerRadioIcon{{ $header['name'] }}"
                        {{ (isset($settings['headerType']) && $settings['headerType']->value == $header['name']) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="headerRadioIcon{{ $header['name'] }}">{{ $header['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Fixed Navbar -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="navbarType" class="form-label d-block mb-2">Navbar Type</label>
              <div class="row px-1">
                @php
                  $navbarOptions = [
                    ['name' => 'sticky', 'title' => 'Sticky', 'image' => 'navbar-sticky.svg'],
                    ['name' => 'static', 'title' => 'Static', 'image' => 'navbar-static.svg'],
                    ['name' => 'hidden', 'title' => 'Hidden', 'image' => 'navbar-hidden.svg'],
                  ];
                @endphp
                @foreach ($navbarOptions as $navbar)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="navbarOptionRadios{{ $navbar['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $navbar['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="navbarType"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $navbar['name'] }}"
                        id="navbarOptionRadios{{ $navbar['name'] }}"
                        {{ (isset($settings['navbarType']) && $settings['navbarType']->value == $navbar['name']) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="navbarOptionRadios{{ $navbar['name'] }}">{{ $navbar['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Content Layout -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="contentLayout" class="form-label d-block mb-2">Content</label>
              <div class="row px-1">
                @php
                  $contentLayouts = [
                    ['name' => 'compact', 'title' => 'Compact', 'image' => 'content-compact.svg'],
                    ['name' => 'wide', 'title' => 'Wide', 'image' => 'content-wide.svg'],
                  ];
                @endphp
                @foreach ($contentLayouts as $content)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="contentRadioIcon{{ $content['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $content['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="contentLayout"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $content['name'] }}"
                        id="contentRadioIcon{{ $content['name'] }}"
                        {{ (isset($settings['contentLayout']) && $settings['contentLayout']->value == $content['name']) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="contentRadioIcon{{ $content['name'] }}">{{ $content['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Directions -->
            <div class="m-0 px-6 pb-6 w-100">
              <label for="myRTLMode" class="form-label d-block mb-2">Direction</label>
              <div class="row px-1">
                @php
                  $directions = [
                    ['name' => 'ltr', 'title' => 'Left to Right (En)', 'image' => 'direction-ltr.svg'],
                    ['name' => 'rtl', 'title' => 'Right to Left (Ar)', 'image' => 'direction-rtl.svg'],
                  ];
                @endphp
                @foreach ($directions as $direction)
                  <div class="col-4 px-2">
                    <div class="form-check custom-option custom-option-image custom-option-image-radio mb-0">
                      <label class="form-check-label custom-option-content p-0" for="directionRadioIcon{{ $direction['name'] }}">
                        <span class="custom-option-body mb-0 scaleX-n1-rtl">
                          {!! file_get_contents(public_path('assets/img/customizer/' . $direction['image'])) !!}
                        </span>
                      </label>
                      <input
                        name="myRTLMode"
                        class="form-check-input d-none"
                        type="radio"
                        value="{{ $direction['name'] == 'rtl' ? '1' : '0' }}"
                        id="directionRadioIcon{{ $direction['name'] }}"
                        {{ (isset($settings['myRTLMode']) && $settings['myRTLMode']->value == ($direction['name'] == 'rtl')) ? 'checked' : '' }}
                      />
                    </div>
                    <label class="form-check-label small text-nowrap text-body" for="directionRadioIcon{{ $direction['name'] }}">{{ $direction['title'] }}</label>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Fixed Footer -->
            <div class="m-0 px-6 pb-6 w-100 d-flex justify-content-between pe-12">
              <span class="form-label">Fixed Footer</span>
              <label class="switch">
                <input type="checkbox" class="switch-input" id="footerFixed" name="footerFixed" value="1" {{ (isset($settings['footerFixed']) && $settings['footerFixed']->value == true) ? 'checked' : '' }}>
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
              </label>
            </div>

            <!-- Fixed Menu (This is usually handled by layout options, but kept for completeness if needed) -->
            <div class="m-0 px-6 pb-6 w-100 d-flex justify-content-between pe-12">
              <span class="form-label">Fixed Menu</span>
              <label class="switch">
                <input type="checkbox" class="switch-input" id="menuFixed" name="menuFixed" value="1" {{ (isset($settings['menuFixed']) && $settings['menuFixed']->value == true) ? 'checked' : '' }}>
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
              </label>
            </div>
            <hr class="m-0 px-6 my-6" />
          </div>
          <!--/ Layout -->

          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
