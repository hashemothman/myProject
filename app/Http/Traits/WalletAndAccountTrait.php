<?php

namespace App\Http\Traits;

use App\Models\User;
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
    public function createDolarWallet($user)
    {
        try {
            DB::beginTransaction();
            $max_amount_id = $this->getMaxAmount($user);
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

    public function createAdminWallet($admin_id, $coin_id)
    {
        try {
            $wallet = new AdminWallet();
            $wallet->admin_id = $admin_id;
            $wallet->amount   = 0;
            $wallet->coin_id  = $coin_id;
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
        $minValue = '10000000000000000000';
        $maxValue = '99999999999999999999';

        $accountNumber = DB::transaction(function () use ($minValue, $maxValue) {
            $lastCreatedAccount = Account::orderBy('created_at', 'desc')->first();
            $currentNumber = $lastCreatedAccount ? preg_replace('/[^0-9]/', '', $lastCreatedAccount->account) : $minValue;
            // dd($currentNumber);
            // Increment and check bounds
            $newNumber = bcadd($currentNumber, '1');
            if (bccomp($newNumber, $maxValue) === 1) {
                $maxValue = bcadd($maxValue, '1'); // Reset if max value is reached
                $newNumber = $maxValue;
            }

            // Ensure the new number is unique
            while (Account::where('account', 'BF-' . str_pad($newNumber, 16, '0', STR_PAD_LEFT))->exists()) {
                $newNumber = bcadd($newNumber, '1');
                if (bccomp($newNumber, $maxValue) === 1) {
                    $maxValue = bcadd($maxValue, '1'); // Reset if max value is reached
                    $newNumber = $maxValue;
                }
            }

            return $newNumber;
        }, 5); // Retry up to 5 times in case of deadlock

        // Format the account number
        $formattedAccountNumber = 'BF-' . str_pad($accountNumber, 16, '0', STR_PAD_LEFT); // Ensures the number part has at least 16 digits

        return $formattedAccountNumber;
    }

    protected function getMaxAmount($user,$coin_id = 1)
    {
        try {
            // $user = optional(Auth::user())->load(['userInfo', 'account']);
            // if (!$user) {
            //     return null;
            // }
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
