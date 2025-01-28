<?php

// Add Media

use App\Models\Notification;
use App\Services\FirebaseNotificationService;

if (!function_exists('add_media')) {
    function add_media($model, $request, $collection)
    {
        if ($request->hasFile('media')) {
            $model->addMediaFromRequest('media')->toMediaCollection($collection);
        }
    }
}

// Send Notification
if (!function_exists('send_notification')) {
    function send_notification($url, $model, $title, $body, $user_id, $device_token)
    {
        $data = [
            'model_id' => $model->id,
            'model_type' => $url,
            'title' => $title,
            'body' => $body,
            'user_id' => $user_id,
        ];
        $data['device_token'] = $device_token;
        $notification = Notification::create($data);
        $firebaseService = new FirebaseNotificationService();
        $sendNotification = $firebaseService->sendNotification($data);
    }
    // substr($url, strpos($url, '/api/') + 5) ??
}
