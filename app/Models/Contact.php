<?php

namespace App\Models;

class Contact extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'link',
        'type',
        'icon',
        'nursery_id',
    ];
}
