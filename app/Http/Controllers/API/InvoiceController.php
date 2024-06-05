<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\UpdateInvoiceRequest;

class InvoiceController extends Controller
{
    use ApiResponseTrait, FileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = Invoice::all();
        return $this->customeResponse(InvoiceResource::collection($invoice), 'Data retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        $file_path = $this->FileExists($request,$request->file,'file', 'invoices', 'BasFile');

        $invoice = Invoice::create([
            'officeInfo_id'  => $request->officeInfo_id,
            'coin_id'        => $request->coin_id,
            'invoice_number' => $request->invoice_number,
            'date'           => $request->date,
            'invoices_value' => $request->invoices_value,
            'file'           => $file_path
        ]);

        if ($invoice) {
            return $this->customeResponse(new InvoiceResource($invoice), 'Created Successfully', 201);

            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        if (!$invoice) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        return $this->customeResponse(new InvoiceResource($invoice), 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if (!$invoice) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $file_path= $this->FileExists($request, $request->file, 'file','invoices', 'BasFile', false, $invoice);

        $invoice->officeInfo_id = $request->input('officeInfo_id') ?? $invoice->officeInfo_id;
        $invoice->coin_id = $request->input('coin_id') ?? $invoice->coin_id;
        $invoice->invoice_number = $request->input('invoice_number') ?? $invoice->invoice_number;
        $invoice->date = $request->input('date') ?? $invoice->date;
        $invoice->invoices_value = $request->input('invoices_value') ?? $invoice->invoices_value;
        $invoice->file = $file_path;
        $invoice->save();

        return $this->customeResponse(new InvoiceResource($invoice), 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if (!$invoice) {
            return $this->customeResponse(null, 'Not Found', 404);
        }

        $invoice->delete();
        return $this->customeResponse('', "Invoice Deleted", 200);
    }
}
