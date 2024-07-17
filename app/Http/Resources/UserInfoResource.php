<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use App\Http\Resources\WalletResource;
use App\Http\Resources\CountryResource;
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
        $country = $this->country;
        // $account = $this->user->account;
        // $wallets = $this->user->wallets;
        return [
            'user'             => new UserResource($user),
            'city'             => new CityResource($city),
            'country'          => new CountryResource($country),
            'fullName'         => $this->fullName,
            'idNumber'         => $this->idNumber,
            'photo'            => asset('photos/' . $this->photo) ,
            'front_card_image' => asset('photos/' . $this->front_card_image) ,
            'back_card_image'  => asset('photos/' . $this->back_card_image) ,
            // 'user_account'     => new AccountResource($account),
            // 'wallets'          => WalletResource::collection($wallets),
        ];
    }
}
