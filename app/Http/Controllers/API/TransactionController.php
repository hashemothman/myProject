<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Traits\TransferTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\UpdateTransactionRequest;


class TransactionController extends Controller
{
    use ApiResponseTrait,TransferTrait;

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
        DB::beginTransaction();
        try {
            // Determine if the request is made by an admin or a user based on the guard
            $isUserAdmin = Auth::guard('admin-api')->check();

            // Optionally, add logic specific to admins or users
            if ($isUserAdmin) {
                $admin =  Auth::guard('admin-api')->user();
                $transactionAdminData = [
                    'transactionable_id'    => $admin->id,
                    'transactionable_type'  => 'App\\Models\\Admin',
                    'coin_id'               => $request->coin_id,
                    'reciever_account'      => $request->reciever_account,
                    'amount'                => $request->amount,
                    'type'                  => $request->type,
                ];
                $transaction = Transaction::create($transactionAdminData);
                $this->rechargeForUser($transaction->sender, $transaction->coin_id , $transaction->reciever_account, $transaction->amount);
                Log::info('Transaction created by an admin');
            } else {
                $transactionData = [
                    'transactionable_id'    => Auth::user()->id, 
                    'transactionable_type'  => 'App\\Models\\User', 
                    'coin_id'               => $request->coin_id,
                    'reciever_account'      => $request->reciever_account,
                    'amount'                => $request->amount,
                    'type'                  => $request->type,
                ];
                $transaction = Transaction::create($transactionData);
                $this->transferAmount($transaction->sender, $transaction->coin_id , $transaction->reciever_account, $transaction->amount);
                Log::info('Transaction created by a user');
            }
    
            DB::commit();
            return $this->customeResponse(new TransactionResource($transaction), "Done", 200);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return $this->customeResponse(null, "Error, There something wrong here", 500);
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

}
