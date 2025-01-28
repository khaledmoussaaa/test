<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'body',
        'model_type',
        'model_id',
        'user_id'
    ];

    // ====================== Relations For Community =================== //
    public function model()
    {
        return $this->morphTo();
    }
}
