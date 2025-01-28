<?php

namespace App\Models;

class Message extends BaseModel
{
    protected $fillable =
    [
        'chat_id',
        'sender_id',
        'sender_type',
        'message'
    ];

    // =================================== Relations ================================= //
    /**
     * The Comment
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
