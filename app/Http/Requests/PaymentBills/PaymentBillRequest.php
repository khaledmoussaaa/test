<?php

namespace App\Http\Requests\PaymentBills;

use Illuminate\Foundation\Http\FormRequest;

class PaymentBillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $payment_bill_id = $this->route('payemntbill.id');
        return [
            //
            'title' => 'required|string',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'status' => 'required|string|in:mandatory,optional',
            'branch_id' => 'required|integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id',
            'kids' => $payment_bill_id ? 'nullable|array' : 'required|array',
            'kids.*.id' => 'required|integer|exists:kids,id',
        ];
    }
}
