<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $admin= $this->admin;
        return [
            'admin'            => new AdminResource($admin),
            'name'             => $this->name,
            'idNumber'         => $this->idNumber,
            'front_card_image' => asset('photos/' . $this->front_card_image) ,
            'back_card_image'  => asset('photos/' . $this->back_card_image) ,
        ];
    }
}
