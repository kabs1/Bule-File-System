@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-access-roles.js', 'resources/assets/js/modal-add-role.js'])
@endsection

@section('content')
  <h4 class="mb-1">Roles List</h4>

  <p class="mb-6">A role provided access to predefined menus and features so that depending on assigned role an
    administrator can have access to what user needs.</p>
  <!-- Role cards -->
  <div class="row g-6">
    @foreach ($roles as $role)
      <div class="col-xl-4 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h6 class="fw-normal mb-0 text-body">Total {{ $role->users->count() }} users</h6>
              <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                @foreach ($role->users->take(4) as $user)
                  <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                    title="{{ $user->name }}" class="avatar pull-up">
                    <img class="rounded-circle" src="{{ $user->profile_photo_url }}" alt="Avatar" />
                  </li>
                @endforeach
                @if ($role->users->count() > 4)
                  <li class="avatar">
                    <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip"
                      data-bs-placement="bottom" title="{{ $role->users->count() - 4 }} more">
                      +{{ $role->users->count() - 4 }}
                    </span>
                  </li>
                @endif
              </ul>
            </div>
            <div class="d-flex justify-content-between align-items-end">
              <div class="role-heading">
                <h5 class="mb-1">{{ $role->name }}</h5>
                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                  class="role-edit-modal"><span>Edit Role</span></a>
              </div>
              <a href="javascript:void(0);"><i class="icon-base bx bx-copy icon-md text-body-secondary"></i></a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card h-100">
        <div class="row h-100">
          <div class="col-sm-5">
            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4 ps-6">
              <img src="{{ asset('assets/img/illustrations/lady-with-laptop-' . $configData['theme'] . '.png') }}"
                class="img-fluid" alt="Image" width="120"
                data-app-light-img="illustrations/lady-with-laptop-light.png"
                data-app-dark-img="illustrations/lady-with-laptop-dark.png" />
            </div>
          </div>
          <div class="col-sm-7">
            <div class="card-body text-sm-end text-center ps-sm-0">
              <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Role</button>
              <p class="mb-0">
                Add new role, <br />
                if it doesn't exist.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12">
      <h4 class="mt-6 mb-1">Total users with their roles</h4>
      <p class="mb-0">Find all of your company’s administrator accounts and their associate roles.</p>
    </div>
    <div class="col-12">
      <!-- Role Table -->
      <div class="card">
        <div class="card-datatable">
          <table class="datatables-users table border-top table-responsive">
            <thead>
              <tr>
                <th></th>
                <th></th>
                <th>User</th>
                <th>Role</th>
                <th>Plan</th>
                <th>Billing</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
      <!--/ Role Table -->
    </div>
  </div>
  <!--/ Role cards -->

  <!-- Add Role Modal -->
  @include('_partials/_modals/modal-add-role')
  <!-- / Add Role Modal -->
@endsection
