@extends('layouts/layoutMaster')

@section('title', 'Measure Units')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-measure-units-list.js')
@endsection

@section('content')
  <div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">Measure Units</h5>
      <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
        <div class="col-md-4 measure_short"></div>
      </div>
    </div>
    <div class="card-datatable">
      <table class="datatables-measure-units table border-top">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>Name</th>
            <th>Short Name</th>
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMeasureUnit"
      aria-labelledby="offcanvasAddMeasureUnitLabel">
      <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddMeasureUnitLabel" class="offcanvas-title">Add Measure Unit</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
        <form id="addMeasureUnitForm">
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="measure-name">Name</label>
            <input type="text" class="form-control" id="measure-name" name="name" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="measure-short">Short Name</label>
            <input type="text" class="form-control" id="measure-short" name="short_name" maxlength="10" />
          </div>
          <button type="submit" class="btn btn-primary me-3 data-submit">Add</button>
          <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
      </div>
    </div>
  </div>
@endsection
