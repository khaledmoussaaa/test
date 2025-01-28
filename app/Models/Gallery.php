<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'media_counts',
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

    // =================================== Spatie Media ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('galleries');
    }
}
