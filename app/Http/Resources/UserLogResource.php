<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $user = User::where('id',$this->user_id)->get();
        return [
            'id' =>$this->id,
            'user' => new UserResource($user),
            'title' =>$this->title,
            'description' =>$this->description,
            'file' => asset('files/userLogs' . $this->file),
        ];
    }
}
