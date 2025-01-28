<?php

namespace App\Models;

class KidPaymentBill extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'payment_bill_id',
        'kid_id',
        'status',
    ];

    // =================================== Relations ================================= //
    /**
     * The Comment
     */
    public function paymentBill()
    {
        return $this->belongsTo(PaymentBill::class, 'payment_bill_id');
    }
    /**
     * The Comment
     */
    public function kid()
    {
        return $this->belongsTo(Kid::class, 'kid_id');
    }

    // =================================== Spatie ================================= //
    /**
     * Spatie media library register
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('kid payemnt bills')->singleFile();
    }
}
