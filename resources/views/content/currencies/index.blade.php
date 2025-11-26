@extends('layouts/layoutMaster')

@section('title', 'Currencies')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-currencies-list.js')
@endsection

@section('content')
  <div class="card">
    <div class="card-header border-bottom">
      <h5 class="card-title mb-0">Currencies</h5>
      <div class="d-flex justify-content-between align-items-center row pt-4 gap-md-0 g-6">
        <div class="col-md-4 currency_code"></div>
        <div class="col-md-4 currency_default"></div>
      </div>
    </div>
    <div class="card-datatable">
      <table class="datatables-currencies table border-top">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>Name</th>
            <th>Code</th>
            <th>Symbol</th>

            <!-- <th>Default</th> -->
            <th>Actions</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCurrency"
      aria-labelledby="offcanvasAddCurrencyLabel">
      <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddCurrencyLabel" class="offcanvas-title">Add Currency</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
        <form id="addCurrencyForm">
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="currency-name">Name</label>
            <input type="text" class="form-control" id="currency-name" name="name" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="currency-code">Code</label>
            <input type="text" class="form-control" id="currency-code" name="code" maxlength="3" />
          </div>
          <div class="mb-6 form-control-validation">
            <label class="form-label" for="currency-symbol">Symbol</label>
            <input type="text" class="form-control" id="currency-symbol" name="symbol" maxlength="5" />
          </div>

          <!-- <div class="mb-6 form-check">
            <input type="checkbox" class="form-check-input" id="currency-default" name="is_default" value="1" />
            <label class="form-check-label" for="currency-default">Set as Default</label>
          </div> -->
          <button type="submit" class="btn btn-primary me-3 data-submit">Add</button>
          <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
      </div>
    </div>
  </div>
@endsection
