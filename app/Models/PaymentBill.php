<?php

namespace App\Models;

class PaymentBill extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'amount',
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
    public function kid_payment_bills()
    {
        return $this->hasMany(KidPaymentBill::class, 'payment_bill_id')->with('media');
    }

    /**
     * The Comment
     */
    public function kids()
    {
        return $this->belongsToMany(Kid::class, 'kid_payment_bills')->withPivot('status');
    }
    /**
     * The Comment
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id');
    }
}
