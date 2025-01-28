<?php

namespace App\Services;

use App\Models\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('services.firebase.credentials_file'));
        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($data)
    {
        if (isset($data['user_id'])) {
            $user = User::find($data['user_id']);
            $message = CloudMessage::withTarget('token', $user->device_token)->withNotification($data);
        }
        try {
            $this->messaging->send($message);
            return ['success' => true, 'message' => 'Notification sent.'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
