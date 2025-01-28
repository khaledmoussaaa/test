<?php

namespace App\Http\Requests\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class GalleryMediaRequest extends FormRequest
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
            // Gallery Media Validations
            'media' => 'required|image',
            'gallery_id' => 'required|integer|exists:galleries,id'
        ];
    }
}
