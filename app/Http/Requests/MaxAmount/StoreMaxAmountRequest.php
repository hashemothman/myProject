<?php

namespace App\Http\Requests\MaxAmount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMaxAmountRequest extends FormRequest
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
            'max_amount'    => 'required|numeric',
            'coin_id'       => 'required|integer|exists:coins,id',
            'country_id'    => 'required|integer|exists:countries,id',
            'account_type' => [
                'required',
                Rule::in(['marketer','normal','agent']),
            ],
        ];
    }
}
