<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreUserRequest extends FormRequest
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
            'email'         => 'required|string|email|unique:users',
            'mobile_number' => 'required|string|unique:users',
            'password'      => 'required|min:8',
            'status' => ['required', 
                Rule::in(['Active', 'DisActive']),
            ],
            'type' =>['required', 
                Rule::in(['User']),
            ],
        ];
    }
}
