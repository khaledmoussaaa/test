<?php

namespace App\Http\Requests\Parents;

use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
        $user_id = $this->route('parent.user_id');
        return [
            // User Validations
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email,' . $user_id,
            'phone' => 'required|string|unique:users,phone,' . $user_id,
            'branch_id' => 'required|integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id',

            // Parent Validations
            'job' => 'required|string',
            'emergency_phone' => 'required|string',

            // Kid Validations
            'kids' => 'nullable|array',
            'kids.*.first_name' => 'required|string',
            'kids.*.last_name' => 'required|string',
            'kids.*.birth_date' => 'required|date',
            'kids.*.gender' => 'required|string|in:boy,girl',
            'kids.*.has_medical_case' => 'nullable|integer|in:0,1',
            'kids.*.description_medical_case' => 'required_with:kids.*.has_medical_case|string',
            'kids.*.class_room_id' => 'required|integer|exists:class_rooms,id',
            'kids.*.branch_id' => 'required|integer|exists:branches,id',
            'kids.*.nursery_id' => 'required|integer|exists:nurseries,id',
            // 'kids.*.parent_id' => 'nullable|integer|exists:parents,id',
        ];
    }
}
