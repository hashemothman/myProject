<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
            'officeInfo_id'    => 'nullable|integer|exists:office_infos,id',
            'coin_id'          => 'nullable|integer|exists:coins,id',
            'invoice_number'   => 'nullable|integer',
            'date'             => 'nullable|date',
            'invoices_value'   => 'nullable|integer|regex:/^\d*(\.\d{1,2})?$/',
            'file'             => 'nullable|mimes:pdf,doc,docx|max:2048',
        ];
    }
}
