<?php

namespace App\Http\Controllers\API;

use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Requests\CoinRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\StoreCoinRequest;
use App\Http\Requests\Coin\UpdateCoinRequest;
use App\Http\Resources\CoinResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\FileTrait;

class CoinController extends Controller
{
    use ApiResponseTrait, FileTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coins = Coin::all();
        return $this->customeResponse(CoinResource::collection($coins),"Done",200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoinRequest $request)
    {
        try {
            $country_flag_path  = $this->UploadFile($request, 'coins', 'country_flag', 'BasImage');
            $coin = Coin::create([
                'coin_name'    => $request->coin_name,
                'country_flag' => $country_flag_path
            ]);
            return $this->customeResponse(new CoinResource($coin), 'Coin Created Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coin $coin)
    {
        try {
            return $this->customeResponse(new CoinResource($coin),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoinRequest $request, Coin $coin)
    {
        try {
            $country_flag_path = $this->FileExists($request, $request->country_flag, 'country_flag','coins','BasImage', false, $coin);
            $coin->update([
                'coin_name' => $request->coin_name,
                'country_flag' => $country_flag_path
            ]);
            return $this->customeResponse(new CoinResource($coin), 'Coin Updateded Successfuly', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coin $coin)
    {
        try{
            $coin->delete();
            return $this->customeResponse("","coin deleted successfully",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }
}
