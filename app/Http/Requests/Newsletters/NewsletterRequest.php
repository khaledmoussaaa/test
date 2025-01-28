<?php

namespace App\Http\Requests\Newsletters;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
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
            'media' => 'nullable|image',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'class_room_id' => 'nullable|exists:class_rooms,id',
            'branch_id' => 'required||integer|exists:branches,id',
            'nursery_id' => 'required|integer|exists:nurseries,id'
        ];
    }
}
