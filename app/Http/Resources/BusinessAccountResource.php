<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAccountResource extends JsonResource
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
            'user'                  => new UserResource($user),
            'company_name'          =>$this->company_name,
            'logo'                  =>asset('photos/' . $this->logo) ,
            'commercial_record'     =>$this->commercial_record,
            'validity_period'       =>$this->validity_period,
        ];
    }
}
