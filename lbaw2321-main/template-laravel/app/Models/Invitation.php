<?php


namespace App\Models;


use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $invitation;

    public $timestamps = false;

    public function event()
{
    return $this->belongsTo(Event::class);
}

public function invitedUser()
{
    return $this->belongsTo(User::class, 'user_invited_id');
}

public function hostUser()
{
    return $this->belongsTo(User::class, 'user_host_id');
}

    protected $table = 'eventinvitation';
    
    protected $fillable = [
        'sentdate', 'event_id', 'user_invited_id', 'user_host_id', 'decision'
    ];

    public static function createInvitation($event, $user)
    {
        return self::create([
            'sentdate' => now(),
            'event_id' => $event->id,
            'user_invited_id' => $user->id,
            'user_host_id' => auth()->user()->id,
            'decision' => null,
        ]);
    }
}
