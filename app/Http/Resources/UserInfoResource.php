<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        $city = $this->city;
        return [
            'user'             => new UserResource($user),
            'city'             => $city,
            'fullName'         => $this->fullName,
            'idNumber'         => $this->idNumber,
            'photo'            => asset('photos/' . $this->photo) ,
            'front_card_image' => asset('photos/' . $this->front_card_image) ,
            'back_card_image'  => asset('photos/' . $this->back_card_image) ,
        ];
    }
}
