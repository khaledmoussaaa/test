<?php

namespace App\Http\Controllers\PaymentBills;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentBills\PaymentBillRequest;
use App\Jobs\SendNotification;
use App\Models\PaymentBill;
use Illuminate\Http\Request;

class PaymentBillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentRequest = PaymentBill::branchScope($request)->get();
        return contentResponse($paymentRequest);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentBillRequest $request)
    {
        $paymentRequest = PaymentBill::create($request->validated());
        $paymentRequest->kids()->attach(collect($request->validated('kids'))->pluck('id'));
        SendNotification::dispatch($paymentRequest, $request->url(), 'Test 1', 'Body 1', 1);
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentBill $payemntbill)
    {
        return contentResponse($payemntbill->load('kids.kid_payment_bill.media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentBillRequest $request, PaymentBill $payemntbill)
    {
        $payemntbill->update($request->validated());
        $payemntbill->kids()->sync(collect($request->validated('kids'))->pluck('id'));
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentBill $payemntbill)
    {
        $payemntbill->forceDelete();
        return messageResponse();
    }
}
