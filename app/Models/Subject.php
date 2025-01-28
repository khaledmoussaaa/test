<?php

namespace App\Models;

use PhpParser\Builder\Class_;

class Subject extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'nursery_id',
        'branch_id',
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
    public function followUps()
    {
        return $this->belongsToMany(Followup::class, 'followup_subject', 'subject_id', 'followup_id')->withTimestamps();
    }
    
    /**
     * The Comment
     */
    public function classRooms()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_room_subjects', 'subject_id', 'class_room_id')->withTimestamps();
    }

        /**
     * The Comment
     */
    public function schedules()
    {
        return $this->belongsToMany(ClassRoom::class, 'schedules', 'subject_id', 'class_room_id')->withPivot('id','date', 'content');
    }
}
