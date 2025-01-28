<?php

namespace App\Http\Controllers\KidPyamentBills;

use App\Http\Controllers\Controller;
use App\Http\Requests\KidPaymentBills\StoreKidPaymentRequest;
use App\Http\Requests\KidPaymentBills\UpdateKidPaymentRequest;
use App\Jobs\SendNotification;
use App\Models\Kid;
use App\Models\KidPaymentBill;
use Illuminate\Http\Request;

class KidPaymentBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::find($request->kid_id);
        return contentResponse($kids->load('nursery:id,name', 'kid_payment_bills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(StoreKidPaymentRequest $request)
    {
        $paymentKidBill = KidPaymentBill::findOrFail($request->kid_payment_bill_id);
        $status = $request->validated('status');
        if ($request->hasFile('media')) {
            $status = 'review';
        }
        add_media($paymentKidBill, $request, 'kid payment bills');
        $paymentKidBill->update(['status' => $status]);
        SendNotification::dispatch($paymentKidBill, $request->url(), $paymentKidBill->kid->first_name, 'Payment ' . $request->status, $paymentKidBill->kid->nursery->user_id);
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKidPaymentRequest $request, KidPaymentBill $kidpaymentbill)
    {
        $kidpaymentbill->update($request->validated());
        return messageResponse();
    }
}
