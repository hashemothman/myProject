<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CoinResource;
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
        return [
            'id'           => $this->id,
            'coin'        => $this->coin->coin_name,
            'country'      => $this->country->name,
            'max_amount'   => $this->max_amount,
            'account_type' => $this->account_type
        ];
    }
}
