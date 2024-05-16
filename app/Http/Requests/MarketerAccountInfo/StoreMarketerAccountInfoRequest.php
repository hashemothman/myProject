<?php

namespace App\Http\Requests\MarketerAccountInfo;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarketerAccountInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'account_id'                => 'required|integer|exists:accounts,id',
            'campany_name'              => 'required|string|max:25',
            'commercialRegister_photo'  => 'required|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'commercialRegister_number' => 'required|numeric',
        ];
    }
}
