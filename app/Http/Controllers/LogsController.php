<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogsController extends Controller
{
    public function showLogs()
    {
        $activities = Activity::with('causer')->latest()->paginate(10);
        return view('logs.index', compact('activities'));
    }
}
