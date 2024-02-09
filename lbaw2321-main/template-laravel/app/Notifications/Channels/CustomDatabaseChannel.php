<?php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use DB;

class CustomDatabaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        // Insert data into your custom notification table
        DB::table('notification')->insert([
            'datetime' => now(),
            'notified_user' => $notifiable->id,
            'type' => 'event_notification',
            'description' => $data['message'] // Use the message from the notification data
        ]);
    }
}
