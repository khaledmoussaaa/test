<?php

namespace App\Models;

class Schedule extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'content',
        'date',
        'class_room_id',
        'subject_id',
    ];
}
