<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaxAmount\StoreMaxAmountRequest;
use App\Http\Requests\MaxAmount\UpdateMaxAmountRequest;
use App\Http\Resources\MaxAmountResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\MaxAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaxAmountController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_amounts = MaxAmount::all();
        $data = MaxAmountResource::collection($max_amounts);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaxAmountRequest $request)
    {
        try {
            $max_amount = MaxAmount::create([
                'max_amount'    => $request->max_amount,
                'coin_id'       => $request->coin_id,
                'country_id'    => $request->country_id,
                'account_type'  => $request->account_type
            ]);

            $data = new MaxAmountResource($max_amount);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaxAmount $max_amount)
    {
        try {
            $data = new MaxAmountResource($max_amount);
            return $this->customeResponse($data, 'Done!', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaxAmountRequest $request, MaxAmount $max_amount)
    {
        try {
            $max_amount->max_amount = $request->input('max_amount') ?? $max_amount->max_amount;
            $max_amount->country_id = $request->input('country_id') ?? $max_amount->country_id;
            $max_amount->save();

            $data = new MaxAmountResource($max_amount);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaxAmount $max_amount)
    {
        try {
            $max_amount->delete();
            return $this->customeResponse('', 'Max Amount Deleted', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }
}
