<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketerAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'account_id'                => $this->account_id,
            'campany_name'              => $this->campany_name,
            'commercialRegister_number' => $this->commercialRegister_number,
            'commercialRegister_photo'  => asset('photos/' . $this->commercialRegister_photo) ,
        ];
    }
}
