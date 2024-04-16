<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
            'coin_id'        => 'nullable|integer|exists:coins,id',
            'sender'         => 'nullable|string',
            'reciever_uuid'  => 'nullable|integer',
            'amount'         => 'nullable|string',
            'date'           => 'nullable|date',
        ];
    }
}
