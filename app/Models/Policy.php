<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
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
}
