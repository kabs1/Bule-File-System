@extends('layouts.contentNavbarLayout')

@section('title', 'Edit Measure Unit')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Measure Unit</h4>
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

        <form action="{{ route('measure-units.update', $measureUnit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" value="{{ $measureUnit->name }}" class="form-control" placeholder="Measure Unit Name">
            </div>
            <div class="mb-3">
                <label for="short_name" class="form-label">Short Name (e.g., kg):</label>
                <input type="text" name="short_name" value="{{ $measureUnit->short_name }}" class="form-control" placeholder="Short Name" maxlength="10">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</div>
@endsection
