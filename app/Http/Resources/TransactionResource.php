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
        $coin = Coin::where('id',$this->coin_id)->get();
        $sender = User::where('id',$this->sender)->get();
        return [
            'coin_id'        => new CoinResource($coin),
            'sender'         => $sender,
            'reciever_uuid'  => $this->reciever_uuid,
            'amount'         => $this->amount,
            'date'           => $this->date,
        ];
    }
}
