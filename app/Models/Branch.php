<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Branch extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'country',
        'city',
        'address',
        'main',
        'manager_id',
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
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * The Comment
     */
    public function user()
    {
        return $this->hasOne(User::class, 'branch_id');
    }

    /**
     * The Comment
     */
    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
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
    public function employees()
    {
        return $this->hasMany(User::class)->whereHasRole(['admin', 'teacher']);
    }
}
