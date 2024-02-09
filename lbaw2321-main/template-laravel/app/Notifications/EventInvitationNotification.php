<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Invitation;
use DB;
use App\Notifications\Channels\CustomDatabaseChannel;

class EventInvitationNotification extends Notification
{
    use Queueable;

    protected $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function via($notifiable)
    {
        // Specify only the database channel
        return [CustomDatabaseChannel::class];
    }

    public function toDatabase($notifiable)
    {

        // Return an array of data for Laravel to store in the notification table
        return [
            'message' => 'You have been invited to ' . $this->invitation->event->eventname,
            'event_url' => url('/events/' . $this->invitation->event->id),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have been invited to ' . $this->invitation->event->eventname,
            'event_url' => url('/events/' . $this->invitation->event->id),
        ];
    }
}
