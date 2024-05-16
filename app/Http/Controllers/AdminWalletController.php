<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\StoreWalletRequest;
use App\Http\Resources\AdminWalletResource;
use App\Models\AdminWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wallets = AdminWallet::all();
        $data = AdminWalletResource::collection($wallets);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWalletRequest $request)
    {
        try {
            $wallet = AdminWallet::create([
                'amount'        => $request->amount,
                'coin_id'       => $request->coin_id,
                'max_amount_id' => $request->max_amount_id
            ]);
            $data = new AdminWalletResource($wallet);
            return $this->customeResponse($data, 'Created Successfully', 201);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Failed To Create', 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminWallet $adminWallet)
    {
        try {
            $data = new AdminWalletResource($adminWallet);
            return $this->customeResponse($data, 'Done!', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminWallet $adminWallet)
    {
        try {
            $adminWallet->amount        = $request->input('amount') ?? $adminWallet->amount;
            $adminWallet->max_amount_id = $request->input('max_amount_id') ?? $adminWallet->max_amount_id;
            $adminWallet->save();

            $data = new AdminWalletResource($adminWallet);
            return $this->customeResponse($data, 'Successfully Updated', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return response()->json(['message' => 'Something Error !'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminWallet $adminWallet)
    {
        try {
            $adminWallet->delete();
            return $this->customeResponse('', 'Wallet Deleted', 200);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->customeResponse(null, 'Not Found', 404);
        }
    }
}
