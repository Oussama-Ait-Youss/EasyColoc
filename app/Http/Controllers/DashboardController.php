<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expenses;
use App\Models\Payments; 
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $colocation = $user->activeColocation();

    // Redirect if user has no colocation
    if (!$colocation) {
        return redirect()->route('colocation.create');
    }

    // Active members only
    $members = $colocation->users()
        ->wherePivot('left_at', null)
        ->get();

    $memberCount = $members->count();

    // Total expenses
    $totalExpenses = Expenses::where('colocation_id', $colocation->id)
        ->sum('amount');

    $sharePerPerson = $memberCount > 0
        ? $totalExpenses / $memberCount
        : 0;

    // Calculate balances
    $memberBalances = $members->map(function ($member) use ($colocation, $sharePerPerson) {

        // Total paid directly (expenses created by member)
        $paidByMember = Expenses::where('colocation_id', $colocation->id)
            ->where('user_id', $member->id)
            ->sum('amount');

        // Payments sent (member reimbursed others)
        $paymentsSent = Payments::where('colocation_id', $colocation->id)
            ->where('from_user_id', $member->id)
            ->sum('amount');

        // Payments received (others reimbursed this member)
        $paymentsReceived = Payments::where('colocation_id', $colocation->id)
            ->where('to_user_id', $member->id)
            ->sum('amount');

        /*
         * FINAL BALANCE FORMULA
         *
         * Balance = (Paid + PaymentsReceived)
         *         - (SharePerPerson + PaymentsSent)
         *
         * > 0  → member should receive money
         * < 0  → member owes money
         * = 0  → perfectly balanced
         */

        $currentBalance = ($paidByMember + $paymentsReceived)
                        - ($sharePerPerson + $paymentsSent);

        return [
            'name'    => $member->name,
            'paid'    => $paidByMember,
            'balance' => $currentBalance,
        ];
    });

    // Doughnut chart data
    $categoriesData = Expenses::where('expenses.colocation_id', $colocation->id)
        ->join('categories', 'expenses.category_id', '=', 'categories.id')
        ->selectRaw('categories.name as label, SUM(expenses.amount) as total')
        ->groupBy('categories.name')
        ->get();

    return view('dashboard', compact(
        'colocation',
        'totalExpenses',
        'sharePerPerson',
        'memberBalances',
        'memberCount',
        'categoriesData'
    ));
}
}
