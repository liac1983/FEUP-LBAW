<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
     // Specify the table name if it's different from the default (optional)
     protected $table = 'attendance';
 
     // Disable auto-incrementing for the primary key
     public $incrementing = false;
 
     // Define the fillable columns
     protected $fillable = ['user_id', 'event_id', 'participation', 'wishlist'];

     protected $primaryKey = ['user_id', 'event_id'];

 
     // Disable timestamps (optional)
     public $timestamps = false;

    // Assuming that 'participation' is an ENUM type
    protected $enumCasts = [
        'participation' => 'participation_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
