@extends('layouts.contentNavbarLayout')

@section('title', 'Activity Log')

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Activity Log /</span> Overview
</h4>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">System Activity</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Causer</th>
                        <th>Event</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Changes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activity as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $log->causer ? $log->causer->name : 'System' }}</td>
                        <td>{{ $log->event }}</td>
                        <td>{{ $log->subject_type ? class_basename($log->subject_type) . ' (ID: ' . $log->subject_id . ')' : 'N/A' }}</td>
                        <td>{{ $log->description }}</td>
                        <td>
                            @if ($log->changes && $log->changes->has('attributes'))
                                <ul>
                                    @foreach ($log->changes['attributes'] as $key => $value)
                                        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                No changes recorded.
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">No activity logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $activity->links() }}
        </div>
    </div>
</div>
@endsection
