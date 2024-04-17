<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaxAmountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = new UserResource($this->user);
        return [
            'id'           => $this->id,
            'user'         => $user,
            'coint'        => $this->coin,
            'country'      => $this->country->name,
            'max_amount'   => $this->max_amount,
            'account_type' => $this->account_type
        ];
    }
}
