<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'dateTime',
        'notified_user',
        'type',
        'description',
    ];

    public function event()
{
    return $this->belongsTo(Event::class);
}


}
