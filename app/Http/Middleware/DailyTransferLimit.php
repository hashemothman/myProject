<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DailyTransferLimit
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();

        // Calculate the start and end of the current day
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        // Retrieve total amount transferred by the user within the current day
        $totalTransferred = Transaction::where('sender', $userId)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->sum('amount');

        // Define the daily transfer limit
        $dailyLimit = 5000000;

        // Check if the user has exceeded the daily limit
        if (($totalTransferred + $request->amount) > $dailyLimit) {
            return response()->json(['error' => 'Daily transfer limit exceeded'], 403);
        }

        return $next($request);
    }
}
