<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user= new UserResource($this->user);
        return [
            'id'         => $this->id,
            'user'       => $user,
            'coin'       => new CoinResource($this->coin),
            'amount'       => $this->amount,
            'max_amount' => $this->max_amount_id,
        ];
    }
}
