<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user_id)->get();
        return contentResponse($notifications);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        return contentResponse($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        $notification->update(['read' => 1]);
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->forceDelete();
        return messageResponse();
    }
}
