@extends('layouts.contentNavbarLayout')

@section('title', 'Measure Units')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Measure Units</h4>
        <a href="{{ route('measure-units.create') }}" class="btn btn-primary">Add New Measure Unit</a>
    </div>
    <div class="card-body">
        @if ($message = session('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($measureUnits as $measureUnit)
                    <tr>
                        <td>{{ $measureUnit->id }}</td>
                        <td>{{ $measureUnit->name }}</td>
                        <td>{{ $measureUnit->short_name }}</td>
                        <td>
                            <form action="{{ route('measure-units.destroy', $measureUnit->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('measure-units.show', $measureUnit->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('measure-units.edit', $measureUnit->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
