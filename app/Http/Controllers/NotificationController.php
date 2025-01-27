<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        $notification = DatabaseNotification::find($request->id);
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }
}
