<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Nursery extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'about',
        'branches_number',
        'status',
        'start_fees',
        'service_id',
        'user_id'
    ];

    // =================================== Relations ================================= //
    /**
     * The Comment
     */
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    /**
     * The Comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Comment
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    /**
     * The Comment
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    /**
     * The Comment
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    /**
     * The Comment
     */
    public function kids()
    {
        return $this->hasMany(Kid::class);
    }

    // =================================== Scopes ================================= //
    /**
     * The Comment
     */
    public function scopeStatus(Builder $query, $request): void
    {
        $query->whereIn('status', $request->status)->get();
    }

    // =================================== Spatie ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('nursery')->singleFile();
    }
}
