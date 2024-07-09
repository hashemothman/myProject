<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessAccountRequest extends FormRequest
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
            'company_name'      => 'nullable|string|max:255',
            'logo'              => 'nullable|image|mimes:png,jpg,jpeg,gif,sug|max:2048',
            'commercial_record' => 'nullable|string',
            'validity_period'   => 'nullable|date',
        ];//
    }
}
