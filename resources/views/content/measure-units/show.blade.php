@extends('layouts.contentLayoutMaster')

@section('title', 'Show Measure Unit')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Show Measure Unit Details</h4>
        <a href="{{ route('measure-units.index') }}" class="btn btn-primary">Back to Measure Units</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3">
                    <strong>Name:</strong>
                    {{ $measureUnit->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="mb-3">
                    <strong>Short Name:</strong>
                    {{ $measureUnit->short_name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
