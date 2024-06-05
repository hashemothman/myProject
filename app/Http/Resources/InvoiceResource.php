<?php

namespace App\Http\Resources;

use App\Models\Coin;
use App\Models\OfficeInfo;
use Illuminate\Http\Request;
use App\Http\Resources\CoinResource;
use App\Http\Resources\OfficeInfoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $officeInfo = OfficeInfo::where('id',$this->officeInfo_id)->first();
        $coin = Coin::where('id',$this->coin_id)->first();
        return [
            'officeInfo_id'  => new OfficeInfoResource($officeInfo), 
            'coin_id'        => new CoinResource($coin),
            'invoice_number' => $this->invoice_number,
            'date'           => $this->date, 
            'invoices_value' => $this->invoices_value,
            'file'           => asset('files/' . $this->file), 
        ];
    }
}
