@extends('layouts.contentNavbarLayout')

@section('title', 'Edit Currency')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit Currency</h4>
        <a href="{{ route('currencies.index') }}" class="btn btn-primary">Back to Currencies</a>
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

        <form action="{{ route('currencies.update', $currency->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" value="{{ $currency->name }}" class="form-control" placeholder="Currency Name">
            </div>
            <div class="mb-3">
                <label for="symbol" class="form-label">Symbol (e.g., $):</label>
                <input type="text" name="symbol" value="{{ $currency->symbol }}" class="form-control" placeholder="Currency Symbol" maxlength="5">
            </div>
           
            <!-- <div class="mb-3 form-check">
                <input type="checkbox" name="is_default" class="form-check-input" id="is_default" value="1" {{ $currency->is_default ? 'checked' : '' }}>
                <label class="form-check-label" for="is_default">Set as Default</label>
            </div> -->
            <button type="submit" class="btn btn-success">Edit</button>
        </form>
    </div>
</div>
@endsection
