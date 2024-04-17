<?php

namespace App\Http\Controllers\API;

use App\Models\Percent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\PercentRequest;
use App\Http\Resources\PercentResource;
use App\Http\Requests\UpdatePercentRequest;

class PercentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $percents = Percent::all();
        return $this->customeResponse(PercentResource::collection($percents),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PercentRequest $request)
    {
        try {
            $percent  = Percent::create([
                'coin_id'       =>$request->coin_id,
                'value'         =>$request->value,
                'operation_type'=>$request->operation_type,
            ]);
            return $this->customeResponse(new PercentResource($percent), 'Percent Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Percent $percent)
    {
        try {
            return $this->customeResponse(new PercentResource($percent), 'Done', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePercentRequest $request, Percent $percent)
    {
        try {
            $percent->coin_id = $request->input('coin_id') ?? $percent->coin_id;
            $percent->value = $request->input('value') ?? $percent->value;
            $percent->operation_type = $request->input('operation_type') ?? $percent->operation_type;
            $percent->save();
            return $this->customeResponse(new PercentResource($percent),"percent updated successfully",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Percent $percent)
    {
        try {
            $percent->delete();
            return $this->customeResponse("","UserLog deleted successfully",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
