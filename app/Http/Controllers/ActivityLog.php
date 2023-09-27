<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Request;

class ActivityLog extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        $activity = Activity::paginate(10);
        return view('activity_log.index', compact('activity'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
