@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss',
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection



@section('vendor-script')
@vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js',
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection



@section('content')
<div class="row g-6">
  <!-- Card Border Shadow -->
  <div class="col-lg-3 col-sm-6">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bxs-truck icon-lg"></i></span>
          </div>
          <h4 class="mb-0">42</h4>
        </div>
        <p class="mb-2">Tocal Customers</p>
        <p class="mb-0">
          <span class="text-heading fw-medium me-2">+18.2%</span>
          <span class="text-body-secondary">than last week</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded bg-label-warning"><i class="icon-base bx bx-error icon-lg"></i></span>
          </div>
          <h4 class="mb-0">8</h4>
        </div>
        <p class="mb-2">Tatol Lots</p>
        <p class="mb-0">
          <span class="text-heading fw-medium me-2">-8.7%</span>
          <span class="text-body-secondary">than last week</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded bg-label-danger"><i
                class="icon-base bx bx-git-repo-forked icon-lg"></i></span>
          </div>
          <h4 class="mb-0">27</h4>
        </div>
        <p class="mb-2">Total Inwards</p>
        <p class="mb-0">
          <span class="text-heading fw-medium me-2">+4.3%</span>
          <span class="text-body-secondary">than last week</span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-sm-6">
    <div class="card card-border-shadow-info h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <div class="avatar me-4">
            <span class="avatar-initial rounded bg-label-info"><i class="icon-base bx bx-time-five icon-lg"></i></span>
          </div>
          <h4 class="mb-0">13</h4>
        </div>
        <p class="mb-2">Open Inwards</p>
        <p class="mb-0">
          <span class="text-heading fw-medium me-2">-2.5%</span>
          <span class="text-body-secondary">than last week</span>
        </p>
      </div>
    </div>
  </div>
  <!--/ Card Border Shadow -->
  
  <!--/ Vehicles overview -->
  
  <!--/ Shipment statistics -->
  <!-- Delivery Performance -->
  <div class="col-xxl-4 col-lg-5">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1 me-2">Delivery Performance</h5>
          <p class="card-subtitle">12% increase in this month</p>
        </div>
        <div class="dropdown">
          <button class="btn text-body-secondary p-0" type="button" id="deliveryPerformance" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-cube icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Total Packages</h6>
                <p class="text-success mb-0">
                  <i class="icon-base bx bx-chevron-up icon-lg me-1"></i>
                  5038
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">5038</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-info"><i class="icon-base bx bxs-truck icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages delivered</h6>
                <p class="text-success mb-0">
                  <i class="icon-base bx bx-chevron-up icon-lg me-1"></i>
                  4000
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">4000</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-success"><i
                  class="icon-base bx bx-check-circle icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages out for delivery</h6>
                <p class="text-danger mb-0">
                  <i class="icon-base bx bx-chevron-down icon-lg me-1"></i>
                  3829
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">2829</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-warning"><i
                  class="icon-base bx bxs-offer icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages Purchased</h6>
                <p class="text-success mb-0">
                  <i class="icon-base bx bx-chevron-up icon-lg me-1"></i>
                  7009
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">7009</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-secondary"><i
                  class="icon-base bx bx-time-five icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">Packages Tested</h6>
                <p class="text-danger mb-0">
                  <i class="icon-base bx bx-chevron-down icon-lg me-1"></i>
                  80023
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">80023</h6>
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center">
            <div class="avatar flex-shrink-0 me-4">
              <span class="avatar-initial rounded bg-label-danger"><i class="icon-base bx bx-group icon-lg"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 fw-normal">PAckages Melted</h6>
                <p class="text-success mb-0">
                  <i class="icon-base bx bx-chevron-up icon-lg me-1"></i>
                  70023
                </p>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">70023</h6>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Delivery Performance -->
  <!-- Reasons for delivery exceptions -->
  <div class="col-xxl-4 col-lg-6">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
        </div>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="deliveryExceptions" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptions">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="deliveryExceptionsChart"></div>
      </div>
    </div>
  </div>
  <!--/ Reasons for delivery exceptions -->
  <!-- Orders by Countries -->
  <div class="col-xxl-4 col-lg-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-1">Purchases</h5>
          <p class="card-subtitle">62 deliveries in progress</p>
        </div>
        <div class="dropdown">
          <button class="btn text-body-secondary p-0" type="button" id="ordersCountries" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersCountries">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs nav-fill rounded-0 timeline-indicator-advanced" role="tablist">
            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                aria-selected="true">New</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-link-preparing" aria-controls="navs-justified-link-preparing"
                aria-selected="false">Preparing</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-link-shipping" aria-controls="navs-justified-link-shipping"
                aria-selected="false">Shipping</button>
            </li>
          </ul>
          <div class="tab-content border-0  mx-1">
            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Aisha Nakato</h6>
                    <p class="text-body mb-0">Plot 101, Kampala, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Musa Ssekitoleko</h6>
                    <p class="text-body mb-0">939 Entebbe Road, Wakiso, Uganda</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed my-4"></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Nalule Sarah</h6>
                    <p class="text-body mb-0">162 Gulu Road, Gulu, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Kato David</h6>
                    <p class="text-body mb-0">487 Jinja Road, Jinja, Uganda</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Musa Ssekitoleko</h6>
                    <p class="text-body mb-0">939 Entebbe Road, Wakiso, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Aisha Nakato</h6>
                    <p class="text-body mb-0">Plot 101, Kampala, Uganda</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed my-4"></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Nalule Sarah</h6>
                    <p class="text-body mb-0">162 Gulu Road, Gulu, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Kato David</h6>
                    <p class="text-body mb-0">487 Jinja Road, Jinja, Uganda</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Nalule Sarah</h6>
                    <p class="text-body mb-0">Plot 101, Kampala, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Musa Ssekitoleko</h6>
                    <p class="text-body mb-0">939 Entebbe Road, Wakiso, Uganda</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed my-4"></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-left-dashed">
                  <span class="timeline-indicator-advanced timeline-indicator-success border-0 shadow-none">
                    <i class="icon-base bx bx-check-circle"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Aisha Nakato</h6>
                    <p class="text-body mb-0">162 Gulu Road, Gulu, Uganda</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced timeline-indicator-primary border-0 shadow-none">
                    <i class="icon-base bx bx-map"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Kato David</h6>
                    <p class="text-body mb-0">487 Jinja Road, Jinja, Uganda</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Orders by Countries -->
 
  <!--/ On route vehicles Table -->
</div>

@endsection
