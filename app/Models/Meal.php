<?php

namespace App\Models;

class Meal extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'meal',
        'type',
        'branch_id',
        'nursery_id',
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function followUps()
    {
        return $this->belongsToMany(Followup::class, 'followup_subject', 'subject_id', 'followup_id')->withTimestamps();
    }
}
