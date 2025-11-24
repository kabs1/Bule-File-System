@extends('layouts/layoutMaster')

@section('title', 'Branches - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-access-branches.js', 'resources/assets/js/modal-add-branch.js'])
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
                <th>Location</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($branches as $branch)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->location }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary edit-record" data-id="{{ $branch->id }}">Edit</a>
                            <form action="#" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-record" data-id="{{ $branch->id }}">Delete</button>
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

  <!-- Add Branch Modal -->
  @include('_partials/_modals/modal-add-branch')
  <!-- / Add Branch Modal -->
@endsection
