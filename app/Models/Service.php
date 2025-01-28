<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'content',
        'nursery_id',
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function nursery()
    {
        return $this->belongsTo(Nursery::class);
    }
}
