<?php

namespace App\Http\Traits;

use App\Models\Wallet;
use App\Models\Account;
use App\Models\MaxAmount;
use App\Models\AdminWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiResponseTrait;

trait WalletAndAccountTrait
{
    use ApiResponseTrait;
    public function createDolarWallet(){
        try {
            DB::beginTransaction();
            $max_amount_id = $this->getMaxAmount();
            $wallet = Wallet::create([
                'amount'        => 0,
                'coin_id'       => 1,
                'max_amount_id' => $max_amount_id,
            ]);
            DB::commit();
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

    public function createAccount($account_request)
    {
            DB::beginTransaction();
        try {
            $accountCode = $this->generateAccount();
            $account = Account::create([
                'account'      => $accountCode,
                'account_type' => $account_request->account_type,
            ]);
            DB::commit();
            return $account;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            // throw $e;
            return $this->customeResponse(null, 'there is something error in the server', 500);
        }
    }

    protected function generateAccount()
    {
        $randomNumber = mt_rand(intval(10000000000000000000), intval(99999999999999999999));
        $accountCode = 'FB-' . $randomNumber;
        return $accountCode;
    }



    protected function getMaxAmount($coin_id = 1) {
        try {
            $user = optional(Auth::user())->load(['userInfo', 'account']);
    
            if (!$user) {
                return null;
            }
    
            $userInfo = $user->userInfo;
            $userAccountType = $user->account->account_type;
            $country_id = $userInfo->country->id;
            $coin_id = $coin_id;

            $maxAmountRecord = MaxAmount::where('coin_id', $coin_id)
                                        ->where('country_id', $country_id)
                                        ->where('account_type', $userAccountType)
                                        ->first();
            return $maxAmountRecord ? $maxAmountRecord->id : null;
        } catch (\Exception $e) {
            Log::error("Error getting max amount: ", ['error' => $e->getMessage()]);
            return $this->customeResponse(null, 'there is something error in the server', 500);
        }
    }
}
