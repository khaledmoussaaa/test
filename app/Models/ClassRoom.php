<?php

namespace App\Models;

class ClassRoom extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'from',
        'to',
        'has_meals',
        'has_subjects',
        'has_nap',
        'has_toilet',
        'branch_id',
        'nursery_id'
    ];

    // =================================== Relations ================================= //

    /**
     * The Comment
     */
    public function nurseries()
    {
        return $this->belongsTo(Nursery::class);
    }

    /**
     * The Comment
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * The Comment
     */
    public function kids()
    {
        return $this->hasMany(Kid::class);
    }

    /**
     * The Comment
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_room_subjects', 'class_room_id', 'subject_id')->withTimestamps();
    }

    /**
     * The Comment
     */
    public function schedules()
    {
        return $this->belongsToMany(Subject::class, 'schedules', 'class_room_id', 'subject_id')->withPivot('date', 'content');
    }
}
