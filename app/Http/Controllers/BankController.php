<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Transaction;
use Carbon\Carbon;

class BankController extends Controller
{
    //
    public function getBalance()
    {
        $balance = Transaction::sum('amount');
        return response()->json(['balance' => $balance]);
    }

    public function deposit(Request $request)
    {
        
            // $request->validate([
            //     'amount' => 'required|numeric|max:40000' // Max deposit per transaction: KES 40,000
            // ]);
        
            $amount = $request->amount;

            if($request->amount > 40000){
                return response()->json(['message' => 'Deposit amount exceeds limit']);
            }
            $today = Carbon::today();
        
            // Calculate today's total deposits
            $todaysDeposits = Transaction::where('type', 'deposit')
                                        ->whereDate('created_at', $today)
                                        ->sum('amount');
        
            // Calculate today's total deposit transactions
            $todaysDepositCount = Transaction::where('type', 'deposit')
                                            ->whereDate('created_at', $today)
                                            ->count();
        
            if ($todaysDeposits + $amount > 150000) { // Max deposit for the day: KES 150,000
                return response()->json(['error' => 'Deposit limit for the day exceeded'], 400);
            }
        
            if ($todaysDepositCount >= 4) { // Max deposit frequency: 4 transactions per day
                return response()->json(['error' => 'Deposit transaction limit for the day exceeded'], 400);
            }
        
            Transaction::create([
                'type' => 'deposit',
                'amount' => $amount,
            ]);
        
            return response()->json(['message' => 'Deposit successful']);
        
    }
    public function withdrawal(Request $request)
    {
    
        $amount = $request->amount;
        if($request->amount > 40000){
            return response()->json(['message' => 'Withdrawal amount exceeds limit']);
        }
        $today = Carbon::today();
    
        // Calculate today's total withdrawals
        $todaysWithdrawals = Transaction::where('type', 'withdrawal')
                                        ->whereDate('created_at', $today)
                                        ->sum('amount');
    
        // Calculate today's total withdrawal transactions
        $todaysWithdrawalCount = Transaction::where('type', 'withdrawal')
                                            ->whereDate('created_at', $today)
                                            ->count();
    
        // Ensure the account has enough balance
        $currentBalance = Transaction::sum('amount'); // Deposits are positive, withdrawals are negative
        if ($currentBalance - $amount < 0) {
            return response()->json(['error' => 'Insufficient balance'], 400);
        }
    
        if ($todaysWithdrawals - $amount < -50000) { // Max withdrawal for the day: KES 50,000
            return response()->json(['error' => 'Withdrawal limit for the day exceeded'], 400);
        }
    
        if ($todaysWithdrawalCount >= 3) { // Max withdrawal frequency: 3 transactions per day
            return response()->json(['error' => 'Withdrawal transaction limit for the day exceeded'], 400);
        }
    
        Transaction::create([
            'type' => 'withdrawal',
            'amount' => -$amount, // Store withdrawal as a negative amount
        ]);
    
        return response()->json(['message' => 'Withdrawal successful']);
    }

}
