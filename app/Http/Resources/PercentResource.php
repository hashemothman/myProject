<?php

namespace App\Http\Resources;

use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Resources\CoinResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PercentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $coin = Coin::where('id',$this->coin_id)->get();
        return [
            'coin_id'        => new CoinResource($coin),
            'value'          => $this->value,
            'operation_type' => $this->operation_type,
        ];
    }
}
