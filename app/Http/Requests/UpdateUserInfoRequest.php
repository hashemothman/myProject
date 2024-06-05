<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserInfoRequest extends FormRequest
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
            'city_id'          => 'nullable|integer|exists:cities,id',
            'fullName'         => 'nullable|string',
            'idNumber'         => 'nullable|numeric',
            'photo'            => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'front_card_image' => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'back_card_image'  => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
        ];
    }
}
