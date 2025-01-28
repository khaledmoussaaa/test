<?php

namespace App\Models;

class Chat extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'branch_id',
        'user_id',
    ];

    // =================================== Relations ================================= //
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Comment
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
