<?php

namespace App\Models;


class Followup extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'napping',
        'daiper',
        'potty',
        'toilet',
        'moods',
        'comment',
        'date',
        'kid_id',
        'branch_id',
        'nursery_id',
    ];

    // =================================== Relations ================================= //
    /**
     * The Comment
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    /**
     * The Comment
     */
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'followup_meal', 'followup_id', 'meal_id')->withPivot('amount');
    }

    /**
     * The Comment
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'followup_subject', 'followup_id', 'subject_id')->withPivot('description');
    }

    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('followups')->singleFile();
    }
}
