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
use App\Models\User;
use App\Models\Account;


class TransactionController extends Controller
{
    use ApiResponseTrait,TransferTrait;

    /**
     * Display a listing of the resource.
     */
   
    public function index(Request $request)
    {
        try {
            $query = Transaction::query();
            if ($request->has('sender_id')) {
                $query->where('sender', $request->sender_id);
            }
            if ($request->has('date_from') && $request->has('date_to')) {
                $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
            }
            if ($request->has('coin_id')) {
                $query->where('coin_id', $request->coin_id);
            }
            $transactions = $query->paginate(10);
            return $this->resourcePaginated(TransactionResource::collection($transactions),"Done",200);
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

      /**
     * Display a listing of the transactions for the authenticated user.
     */
    public function getUserTransactions(Request $request)
    {
        try {
        $user = Auth::user();
        $user = User::with('account')->find($user->id);

        // Ensure the user is authenticated
        if (!$user) {
            return $this->customeResponse(null, "Unauthorized", 401);
        }

        $account = $user->account;
        $account_number = $account->account;
        $query = Transaction::where(function ($query) use ($user, $account_number) {
                    $query->where('sender', $user->id)
                          ->orWhere('reciever_account', $account_number);
                })
                ->where('transactionable_type', 'App\\Models\\User')
                ->selectRaw('*');

        // Apply filters based on request
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('date', [$request->date_from, $request->date_to]);
        }
        if ($request->has('coin_id')) {
            $query->where('coin_id', $request->coin_id);
        }

        // Paginate the transactions
        $transactions = $query->paginate(10);


            return $this->resourcePaginated(TransactionResource::collection($transactions), "Done", 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, "Error, There something wrong here", 500);
        }

}

}
