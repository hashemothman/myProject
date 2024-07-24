<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\WalletAndAccountTrait;

class AccountObserver
{
    use WalletAndAccountTrait;
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        $user = $account->user;

        // dd($user);
        if ($user->hasRole('user')) {
            $wallet = $this->createDolarWallet($user);
        }
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
