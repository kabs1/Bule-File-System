@extends('layouts/layoutMaster')

@section('title', 'Backup Management')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Backup /</span> Management
</h4>

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-backups-list.js')
@endsection

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between border-bottom">
    <h5 class="card-title mb-0">Backups</h5>
    @can('create backup')
    <form action="{{ route('backups.create') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-primary">Create New Backup</button>
    </form>
    @endcan
  </div>
  <div class="card-datatable">
    <table class="datatables-backups table border-top">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>Date</th>
          <th>Size</th>
          <th>Disk</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection
