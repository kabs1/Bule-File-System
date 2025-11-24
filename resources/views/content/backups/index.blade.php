@extends('layouts.contentNavbarLayout')

@section('title', 'Backup Management')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Backup /</span> Management
</h4>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Backups</h5>
        @can('create backup')
        <form action="{{ route('backups.create') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Create New Backup</button>
        </form>
        @endcan
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Size</th>
                        <th>Disk</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($backups as $backup)
                    <tr>
                        <td>{{ $backup['date'] }}</td>
                        <td>{{ $backup['size'] }}</td>
                        <td>{{ $backup['disk'] }}</td>
                        <td>
                            @can('download backup')
                           
                            <a href="{{ route('backups.download', ['disk' => base64_encode($backup['disk']), 'path' => base64_encode($backup['path'])]) }}">
                                Download
                            </a>
                            @endcan
                            @can('delete backup')
                            <form action="{{ route('backups.delete', ['disk' => base64_encode($backup['disk']), 'path' => base64_encode($backup['path'])]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this backup?')">Delete</button>
                        </form>
                               
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">No backups found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
