<?php

namespace App\Http\Requests\Followups;

use Illuminate\Foundation\Http\FormRequest;

class FollowupRequest extends FormRequest
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
            'napping' => 'required',
            'daiper' => 'nullable|integer',
            'potty' => 'nullable|integer',
            'toilet' => 'nullable|integer',
            'moods' => 'nullable|integer|in:0,1,2,3,4',
            'comment' => 'nullable|string',
            'meals' => 'nullable|array',
            'meals.*.meal_id' => 'required|integer|exists:meals,id',
            'meals.*.amount' => 'nullable|integer',
            'subjects' => 'nullable|array',
            'subjects.*.subject_id' => 'required|integer|exists:subjects,id',
            'subjects.*.description' => 'nullable|string',
            'branch_id' => 'required|integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id',
        ];
    }
}
