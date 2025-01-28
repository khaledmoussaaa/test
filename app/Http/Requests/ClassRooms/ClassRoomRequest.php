<?php

namespace App\Http\Requests\ClassRooms;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomRequest extends FormRequest
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
        return [
            'name' => 'required|string',
            'from' => 'required|integer',
            'to' => 'required|integer',
            'has_meals' => 'required_without_all:has_subjects,has_nap,has_toilet|integer|in:0,1',
            'has_subjects' => 'required_without_all:has_meals,has_nap,has_toilet|integer|in:0,1',
            'has_nap' => 'required_without_all:has_meals,has_subjects,has_toilet|integer|in:0,1',
            'has_toilet' => 'required_without_all:has_meals,has_subjects,has_nap|integer|in:0,1',
            'branch_id' => 'required|integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id',
        ];
    }
}
