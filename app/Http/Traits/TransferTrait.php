<?php
namespace App\Http\Traits;

use App\Models\Wallet;
use App\Models\Account;
use App\Models\Percent;
use App\Models\AdminWallet;
use Illuminate\Support\Facades\Auth;

trait TransferTrait
{
    public function transferAmount($senderId, $senderCoinId, $reciever_account, $amount)
    {
        // Fetch the sender type from Auth
        $senderType = Auth::user()->type;

        // Deduct the amount from the sender's wallet
        $senderWallet = Wallet::where('user_id', $senderId)
            ->where('coin_id', $senderCoinId)
            ->firstOrFail();
        $senderWallet->decrement('amount', $amount);

        // Increase the amount in the receiver's wallet
        $receiver_account = Account::where('user_id', $reciever_account)->get();
        $receiver_id = $receiver_account->user_id;
        $receiverWallet = Wallet::where('user_id', $receiver_id)
            ->where('coin_id', $senderCoinId)
            ->firstOrFail();
        $receiverWallet->increment('balance', $amount);

        // If the sender is not an agent, get the percent value based on operation type and coin_id
        if ($senderType !== 'agent') {
            $percent = Percent::where('operation_type', 'internal') // Assuming it's internal operation
                ->where('coin_id', $senderCoinId)
                ->value('value');

                // TODO: uncomment the following line
                
            // Add percent value to the admin's wallet for the same coin_id
            // if ($percent !== null) {
            //     $adminWallet = AdminWallet::firstOrCreate([
            //         'admin_id' => 1, // Assuming admin ID is 1
            //         'coin_id' => $senderCoinId // Assuming the admin wallet also has the same coin_id
            //     ]);
            //     $adminWallet->increment('balance', $percent);
            // }
        }
    }
}
