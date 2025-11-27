@extends('layouts/layoutMaster')

@section('title', 'Customer List')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-customer-list.js')
@endsection

@section('content')
<div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span class="text-heading">Customers</span>
              <div class="d-flex align-items-center my-1">
                <h4 class="mb-0 me-2">{{ $totalCustomers ?? 0 }}</h4> {{-- Use dynamic data --}}
                <p class="text-success mb-0">(+XX%)</p> {{-- Placeholder for dynamic percentage --}}
              </div>
              <small class="mb-0">Total Customers</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-group icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    @foreach ($customerStatusCounts ?? [] as $statusName => $customerCount) {{-- Use dynamic data --}}
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span class="text-heading">{{ $statusName }} Customers</span>
              <div class="d-flex align-items-center my-1">
                <h4 class="mb-0 me-2">{{ $customerCount }}</h4>
                <p class="text-success mb-0">(+XX%)</p> {{-- Placeholder for dynamic percentage --}}
              </div>
              <small class="mb-0">Total {{ $statusName }} Customers</small>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-info">
                <i class="icon-base bx bx-user icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <!-- Customers List Table -->
  <div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">Search Filters</h5>
      <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
        <div class="col-md-4 customer_status"></div>
        <div class="col-md-4 customer_created_by"></div>
        <div class="col-md-4 customer_branch"></div>
      </div>
    </div>
    <div class="card-datatable">
      <table class="datatables-customers table border-top">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>Customer</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Branch</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- Offcanvas to add new customer -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCustomer" aria-labelledby="offcanvasAddCustomerLabel">
      <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCustomerLabel" class="offcanvas-title">Add Customer</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
        <form class="add-new-customer pt-0" id="addNewCustomerForm" onsubmit="return false">
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="add-customer-firstname">First Name</label>
            <input type="text" class="form-control" id="add-customer-firstname" placeholder="John" name="customerFirstName"
              aria-label="John" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="add-customer-lastname">Last Name</label>
            <input type="text" class="form-control" id="add-customer-lastname" placeholder="Doe" name="customerLastName"
              aria-label="Doe" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="add-customer-email">Email</label>
            <input type="text" id="add-customer-email" class="form-control" placeholder="john.doe@example.com"
              aria-label="john.doe@example.com" name="customerEmail" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="add-customer-contact">Contact</label>
            <input type="text" id="add-customer-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11"
              aria-label="john.doe@example.com" name="customerContact" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="customer-branch">Branch</label>
            <select id="customer-branch" name="branchId" class="form-select">
              <option value="">Select Branch</option>
              @foreach ($branches as $branch)
                <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary me-3 data-submit">Add</button>
          <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
      </div>
    </div>
  </div>
@endsection
