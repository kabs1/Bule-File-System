@extends('layouts.contentNavbarLayout')

@section('title', 'Show Currency')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Show Currency Details</h4>
        <a href="{{ route('currencies.index') }}" class="btn btn-primary">Back to Currencies</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3">
                    <strong>Name:</strong>
                    {{ $currency->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3">
                    <strong>Symbol:</strong>
                    {{ $currency->symbol }}
                </div>
            </div>
           
            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3">
                    <strong>Default:</strong>
                    {{ $currency->is_default ? 'Yes' : 'No' }}
                </div>
            </div> -->
        </div>
    </div>
</div>
@endsection
