<?php

namespace App\Factories;

use App\Models\Notification;
use App\Traits\T4able;

class NotificationFactory {

    use T4able;

    public function generate($data) 
    {
        $notifications = collect([]);
        foreach ($data as $notification) 
        {
            $notificationDTO = new Notification;
            $notificationDTO = $notificationDTO->fill($notification);
            $notifications->push($notificationDTO);
        }
        return $notifications;
    }
}