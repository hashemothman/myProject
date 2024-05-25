<?php

namespace App\Http\Controllers\API;

use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Models\BussinessAccount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\BusinessAccountRequest;
use App\Http\Resources\BusinessAccountResource;

class BusinessAccountController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $business_accounts = BussinessAccount::all();
        return $this->customeResponse(BusinessAccountResource::collection($business_accounts),"Done",200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BusinessAccountRequest $request)
    {
        try {
            $logo = $this->UploadFile($request, 'business_accounts', 'logo', 'BasImage');
            $business_account = BussinessAccount::create([
                'company_name'            => $request->company_name,
                'logo'                    => $request->logo,
                'commercial_record'       => $request->commercial_record,
                'validity_period'         => $request->validity_period,
            ]);
            return $this->customeResponse(new BusinessAccountResource($business_account), 'Business Account Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(BussinessAccount $business_account)
    {
        try{
            return $this->customeResponse(new BusinessAccountResource($business_account),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BussinessAccount $business_account)
    {
        try {
            $logo = $this->FileExists($request,$request->file,'logo','business_accounts','BasImage', false, $business_account);
            $business_account->company_name = $request->input('company_name') ?? $business_account->company_name;
            $business_account->commercial_record = $request->input('commercial_record') ?? $business_account->commercial_record;
            $business_account->validity_period = $request->input('validity_period') ?? $business_account->validity_period;
            $business_account->logo = $logo;
            $business_account->save();
            return $this->customeResponse(new BusinessAccountResource($business_account), 'Business Account updated Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BussinessAccount $business_account)
    {
        try{
            $business_account->delete();
            return $this->customeResponse("","Business Account deleted successfully",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
