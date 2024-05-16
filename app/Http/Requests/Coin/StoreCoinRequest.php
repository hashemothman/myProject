<?php

namespace App\Http\Requests\Coin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoinRequest extends FormRequest
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
            'coin_name'    => 'required|string|max:25',
            'country_flag' => 'required|image|mimes:png,jpg,jpeg,gif,sug|max:2048'
        ];
    }
}
