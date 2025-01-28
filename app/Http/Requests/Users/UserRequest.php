<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user_id = $this->route('user.id') ?? null;
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email:filter|unique:users,email,' . $user_id,
            'phone' => 'required|string|unique:users,phone,' . $user_id,
            'role' => 'required|string|in:admin,teacher',
            'nursery_id' => 'required|integer|exists:nurseries,id',
            'branch_id' => 'required|integer|exists:branches,id',
            'managments' => 'required|array',
        ];
    }
}
