<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::where('id',$this->user_id)->first();
        return [
            'id' => $this->id,
            'user' => new UserResource($user),
            'complain_number' => $this->complain_number,
            'body' => $this->body,
            'status' => $this->status,
        ];
    }
}
