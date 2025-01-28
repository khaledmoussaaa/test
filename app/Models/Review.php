<?php

namespace App\Models;

class Review extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'review',
        'rate',
        'user_id',
        'nursery_id',
    ];

    // =================================== Relations ================================= /
    /**
     * The Comment
     */
    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }
    /**
     * The Comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
