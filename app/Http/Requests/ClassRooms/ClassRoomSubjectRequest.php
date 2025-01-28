<?php

namespace App\Http\Requests\ClassRooms;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomSubjectRequest extends FormRequest
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
            //
            'subject_id' => 'required_without:subjects|integer|exists:subjects,id',
            'subjects' => 'required_without:subject_id|array',
            'subjects.*.subject_id' => 'required|integer|exists:subjects,id',
        ];
    }
}
