<?php

namespace App\Http\Traits;

use App\Models\Account;
use App\Models\AdminWallet;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


trait WalletAndAccountTrait
{
    public function createDolarWallet($wallet_request){
        try {
            $wallet = new wallet();
            $wallet->amount        = $wallet_request->amount;
            $wallet->max_amount_id = $wallet_request->max_amount_id;
            $wallet->coin_id = 1; //Dolar
            $wallet->save();
            return $wallet;
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
    public function createDolarAdminWallet(){
        try {
            $wallet = new AdminWallet();
            $wallet->amount        = 0;
            $wallet->coin_id = 1; //Dolar
            $wallet->save();
            return $wallet;
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
    public function createSPAdminWallet(){
        try {
            $wallet = new AdminWallet();
            $wallet->amount        = 0;
            $wallet->coin_id = 2; //SP
            $wallet->save();
            return $wallet;
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }

    public function createAccount($user_id, $account_request)
    {
        DB::beginTransaction();
        try {
            $accountCode = $this->generateAccount();
            $account = Account::create([
                'user_id'      => $user_id,
                'account'      => $accountCode,
                'account_type' => $account_request->account_type,
            ]);
            DB::commit();
            return $account;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function generateAccount()
    {
        $randomNumber = mt_rand(10000000000000000000, 99999999999999999999);
        $accountCode = 'FB-' . $randomNumber;
        return $accountCode;
    }

}
