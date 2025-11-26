@extends('layouts/layoutMaster')

@section('title', 'Branches - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/toastr/toastr.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/toastr/toastr.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-access-branches.js'])
@endsection

@section('content')
  <h4 class="mb-1">Branches List</h4>

  <p class="mb-6">Manage your organization's branches.</p>
  <!-- Branch cards -->
  <div class="row g-6">
    <div class="col-12">
      <!-- Branch Table -->
      <div class="card">
        <div class="card-datatable">
          <table class="datatables-branches table border-top table-responsive">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($branches as $branch)
                <tr data-id="{{ $branch->branch_id }}">
                  <td></td>
                  <td></td>
                  <td>{{ $branch->branch_name }}</td>
                  <td>{{ $branch->description }}</td>
                  <td>
                    <a href="#" class="btn btn-sm btn-primary edit-record" data-id="{{ $branch->branch_id }}">Edit</a>
                    <form action="#" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger delete-record"
                        data-id="{{ $branch->branch_id }}">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Branch Table -->
    </div>
  </div>
  <!--/ Branch cards -->

  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddBranch" aria-labelledby="offcanvasAddBranchLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddBranchLabel" class="offcanvas-title">Add Branch</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
      <form id="addBranchForm" class="row">
        <div class="col-12 form-control-validation mb-4">
          <label class="form-label" for="modalBranchName">Branch Name</label>
          <input type="text" id="modalBranchName" name="name" class="form-control" />
        </div>
        <div class="col-12 form-control-validation mb-4">
          <label class="form-label" for="modalBranchLocation">Description</label>
          <input type="text" id="modalBranchLocation" name="location" class="form-control" />
        </div>
        <div class="col-12 text-center demo-vertical-spacing">
          <button type="submit" class="btn btn-primary me-sm-4 me-1 data-submit">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas"
            aria-label="Close">Discard</button>
        </div>
      </form>
    </div>
  </div>
@endsection
