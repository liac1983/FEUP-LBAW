<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log; //debug

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Invitation;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Tag;
use App\Models\Notification;



class NotificationController extends Controller{

    public function getNotifications()
{
    $userId = Auth::id();

    // Fetch notifications
    $notifications = Notification::where('notified_user', $userId)
                                  ->get(['datetime', 'type', 'description']);

    // Fetch received invitations and include event name
    $receivedInvitations = Invitation::where('user_invited_id', $userId)
                                     ->with('event') // assuming you have an 'event' relationship in your Invitation model
                                     ->get();

    // Format invitations
    $formattedInvitations = $receivedInvitations->map(function ($invitation) {
        return [
            'message' => 'You have been invited to ' . ($invitation->event->eventname ?? 'Event'), // use a fallback in case event name is not available
            'event_id' => $invitation->event_id
        ];
    });

    $combinedData = [
        'notifications' => $notifications,
        'invitations' => $formattedInvitations
    ];

    return response()->json($combinedData);
}

    
    


}