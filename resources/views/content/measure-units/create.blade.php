@extends('layouts.contentLayoutMaster')

@section('title', 'Create Measure Unit')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Create New Measure Unit</h4>
        <a href="{{ route('measure-units.index') }}" class="btn btn-primary">Back to Measure Units</a>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('measure-units.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Measure Unit Name" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="short_name" class="form-label">Short Name (e.g., kg):</label>
                <input type="text" name="short_name" class="form-control" placeholder="Short Name" maxlength="10" value="{{ old('short_name') }}">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>
@endsection
