<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PercentRequest extends FormRequest
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
            'coin_id'       =>'required|integer|exists:coins,id',
            'value'         => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value < 0 || $value > 100) {
                        $fail($attribute.' must be a valid percentage.');
                    }
                },
            ],            'operation_type'=>[
                'required',
                Rule::in(['internal', 'external']),
            ],
        ];
    }
}
