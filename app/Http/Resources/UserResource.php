<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'email'            => $this->email,
            'mobile_number'    => $this->mobile_number,
            'status'           => $this->status,
            'type'             => $this->type,
            'role_name'        => $this->role_name,

        ];
    }
}
