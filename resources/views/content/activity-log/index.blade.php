@extends('layouts/layoutMaster')

@section('title', 'Activity Log')

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Activity Log /</span> Overview
  </h4>

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-activity-log-list.js')
@endsection

<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">System Activity</h5>
    <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
      <div class="col-md-4 activity_event"></div>
      <div class="col-md-4 activity_causer"></div>
    </div>
  </div>
  <div class="card-datatable">
    <table class="datatables-activity table border-top">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>Date</th>
          <th>Causer</th>
          <th>Event</th>
          <th>Subject</th>
          <th>Description</th>
          <th>Changes</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection
