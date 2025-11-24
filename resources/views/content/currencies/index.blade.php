@extends('layouts.contentNavbarLayout')

@section('title', 'Currencies')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Currencies</h4>
        <a href="{{ route('currencies.create') }}" class="btn btn-primary">Add New Currency</a>
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
                        <th>Code</th>
                        <th>Symbol</th>
                        <th>Exchange Rate</th>
                        <th>Default</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                    <tr>
                        <td>{{ $currency->id }}</td>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->code }}</td>
                        <td>{{ $currency->symbol }}</td>
                        <td>{{ $currency->exchange_rate }}</td>
                        <td>{{ $currency->is_default ? 'Yes' : 'No' }}</td>
                        <td>
                            <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST">
                                <a class="btn btn-info" href="{{ route('currencies.show', $currency->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('currencies.edit', $currency->id) }}">Edit</a>
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
