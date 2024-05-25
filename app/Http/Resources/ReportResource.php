<?php

namespace App\Http\Resources;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $account = Account::where('id',$this->account_id)->first();
        return [
            'id' =>$this->id,
            'file' => asset('files/reports' . $this->file),
            'account' => new AccountResource($account),
        ];
    }
}
