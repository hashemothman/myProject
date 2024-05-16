<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;

class TransactionController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $transactions = Transaction::all();
            return $this->customeResponse(TransactionResource::collection($transactions),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        try {
            $transaction = Transaction::create([
                'coin_id'             => $request->coin_id,
                'reciever_account'    => $request->reciever_account,
                'amount'              => $request->amount,
                'date'                => $request->date,
            ]);
            return $this->customeResponse(TransactionResource::collection($transaction),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        try {
            return $this->customeResponse(new TransactionResource($transaction),"Done",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null,"Error, There somthing Rong here",500);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Transaction $transaction)
    // {
    //     try {
    //         $transaction->delete();
    //         return $this->customeResponse("","Transaction deleted successfully",200);
    //     } catch (\Throwable $th) {
    //         Log::error($th);
    //         return $this->customeResponse(null,"Error, There somthing Rong here",500);
    //     }
    // }
}
