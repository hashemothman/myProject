<?php

namespace App\Http\Traits;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

trait GenerateAccount
{
    public function generateAdminAccountNumber()
    {
        $minValue = '10000000000000000000';
        $maxValue = '99999999999999999999';

        $accountNumber = DB::transaction(function () use ($minValue, $maxValue) {
            $lastCreatedAdmin = Admin::orderBy('created_at', 'desc')->first();
            $currentNumber = $lastCreatedAdmin ? preg_replace('/[^0-9]/', '', $lastCreatedAdmin->account_number) : $minValue;

            // Increment and check bounds
            $newNumber = bcadd($currentNumber, '1');
            if (bccomp($newNumber, $maxValue) === 1) {
                $maxValue = bcadd($maxValue, '1'); // Reset if max value is reached
                $newNumber = $maxValue;
            }

            // Ensure the new number is unique
            while (Admin::where('account_number', 'FB-A-' . str_pad($newNumber, 16, '0', STR_PAD_LEFT))->exists()) {
                $newNumber = bcadd($newNumber, '1');
                if (bccomp($newNumber, $maxValue) === 1) {
                    $maxValue = bcadd($maxValue, '1'); // Reset if max value is reached
                    $newNumber = $maxValue;
                }
            }

            return $newNumber;
        }, 5); // Retry up to 5 times in case of deadlock

        // Format the account number
        $formattedAccountNumber = 'FB-A-' . str_pad($accountNumber, 16, '0', STR_PAD_LEFT); // Ensures the number part has at least 16 digits

        return $formattedAccountNumber;
    }
}
