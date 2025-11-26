<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ActivityLogController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('activity_log.view');

        $activity = Activity::with('causer')->latest()->paginate(20);

        return view('content.activity-log.index', compact('activity'));
    }

    public function list(Request $request)
    {
        $this->authorize('activity_log.view');
        $logs = Activity::with('causer')->latest()->limit(500)->get();
        $data = $logs->map(function ($log) {
            return [
                'date' => optional($log->created_at)->format('Y-m-d H:i:s'),
                'causer' => $log->causer ? ($log->causer->first_name . ' ' . $log->causer->last_name) : 'System',
                'event' => $log->event,
                'subject' => $log->subject_type ? (class_basename($log->subject_type) . ' (ID: ' . $log->subject_id . ')') : 'N/A',
                'description' => $log->description,
                'changes' => $log->changes ? json_encode($log->changes) : '',
                'actions' => ''
            ];
        });
        return response()->json(['data' => $data]);
    }
}
