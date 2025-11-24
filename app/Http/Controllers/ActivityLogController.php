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
}
