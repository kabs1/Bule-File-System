@extends('layouts/layoutMaster')

@section('title', 'Backup Management')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-backup-list.js')
@endsection

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Backup /</span> Management
</h4>

<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-0">Search Filters</h5>
        <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
            <div class="col-md-4 backup_disk"></div>
        </div>
    </div>
    <div class="card-datatable">
        <table class="datatables-backups table border-top">
            <thead>
                <tr>
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
