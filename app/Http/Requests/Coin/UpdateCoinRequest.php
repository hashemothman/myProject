<?php

namespace App\Http\Requests\Coin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoinRequest extends FormRequest
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
            'coin_name'    => 'nullable|string|max:25',
            'country_flag' => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048'
        ];
    }
}
