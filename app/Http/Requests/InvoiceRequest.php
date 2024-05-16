<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'officeInfo_id'    => 'required|integer|exists:office_infos,id',
            'coin_id'          => 'required|integer|exists:coins,id',
            'invoice_number'   => 'required|numeric',
            'date'             => 'required|date',
            'invoices_value'   => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
            'file'             => 'nullable|mimes:pdf,doc,docx|max:2048',
        ];
    }
}
