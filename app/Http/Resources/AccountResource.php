<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $user = User::where('id',$this->user_id)->first();
        return [
            'id'           => $this->id,
            'account'      => $this->account,
            'account_type' => $this->account_type,
            'user'          => new UserResource($this->user),
        ];
    }
}
