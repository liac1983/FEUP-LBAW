<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'content',
        'owner_id',
        'event_id',
        'datetime',
    ];

    protected $dates = ['datetime'];


    // Define the owner relationship
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Define the event relationship
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Explicitamente define os nomes das colunas de timestamp
    const CREATED_AT = 'datetime';
    const UPDATED_AT = 'datetime';
    
}
