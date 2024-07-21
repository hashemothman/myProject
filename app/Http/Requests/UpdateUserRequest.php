<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email'         => 'nullable|string|email|unique:users',
            'mobile_number' => 'nullable|string|unique:users',
            'password'      => 'nullable|min:8',
            'fcm_token'      => 'nullable|min:2|string',
            'status' => ['nullable',
                Rule::in(['Active', 'DisActive']),
            ],
            'type' =>['nullable',
                Rule::in(['User']),
            ],
        ];
    }
}
