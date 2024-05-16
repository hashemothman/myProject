<?php

namespace App\Http\Requests\MarketerAccountInfo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketerAccountInfoRequest extends FormRequest
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
            'account_id'                => 'nullable|integer|exists:accounts,id',
            'campany_name'              => 'nullable|string|max:25',
            'commercialRegister_photo'  => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'commercialRegister_number' => 'nullable|numeric',
        ];
    }
}
