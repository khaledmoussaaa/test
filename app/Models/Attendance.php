<?php

namespace App\Models;

class Attendance extends BaseModel
{
    protected $fillable = [
        'date',
        'kid_id',
        'class_room_id',
        'branch_id'
    ];

    // =================================== Relations ================================= //

    /**
     * Inverse of the one-to-many relationship with Kid
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id');
    }
    /**
     * Inverse of the one-to-many relationship with ClassRoom
     */
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }

    
}
