@extends('layouts/layoutMaster')

@section('title', 'Permissions - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-access-permissions.js', 'resources/assets/js/modal-add-permission.js'])
@endsection

@section('content')
  <h4 class="mb-1">Permissions List</h4>
  <script>
    window.canCreatePermission = @json(auth()->check() ? auth()->user()->can('create permission') : false);
    window.canUpdatePermission = @json(auth()->check() ? auth()->user()->can('update permission') : false);
    window.canDeletePermission = @json(auth()->check() ? auth()->user()->can('delete permission') : false);
  </script>

  <p class="mb-6">Each permission controls access to specific actions within the application.</p>
  <!-- Permission cards -->
  <div class="row g-6">
    <div class="col-12">
      <!-- Permission Table -->
      <div class="card">
        <div class="card-datatable">
          <table class="datatables-permissions table border-top table-responsive">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>Name</th>
                <th>Guard Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            @can('update permission')
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                            @endcan
                            @can('delete permission')
                            <form action="#" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Permission Table -->
    </div>
  </div>
  <!--/ Permission cards -->

  <!-- Add Permission Modal -->
  @can('create permission')
  @include('_partials/_modals/modal-add-permission')
  @endcan
  <!-- / Add Permission Modal -->
@endsection
