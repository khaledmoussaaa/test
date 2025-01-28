<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Newsletter extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'is_private',
        'likes_count',
        'class_room_id',
        'branch_id',
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

    /**
     * The Comment
     */
    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /**
     * The Comment
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'model');
    }

    // =================================== Scopes ================================= //
    /**
     * Scope a query to only include class.
     */
    public function scopeClassPublicScope(Builder $query, $request): void
    {
        $query->orWhere([['class_room_id', $request->class_room_id], ['is_private', 0]]);
    }

    // =================================== Spatie ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('newsletters')->singleFile();
    }
    // =================================== Observe ================================= //
    /**
     * Newsletter Observe
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($newsletter) {
            if ($newsletter->class_room_id !== null) {
                $newsletter->is_private = 1;
            }
        });
    }
}
