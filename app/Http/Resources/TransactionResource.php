<?php

namespace App\Http\Resources;

use App\Models\Coin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CoinResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'coin_id'        => new CoinResource($this->coin),
            'reciever_account'  => $this->reciever_account,
            'amount'         => $this->amount,
            'date'           => $this->date,
        ];
    }
}
