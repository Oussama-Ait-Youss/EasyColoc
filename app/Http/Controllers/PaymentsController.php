<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    
    public function index()
{
    $user = Auth::user();
    $colocation = $user->activeColocation();

    if (!$colocation) {
        return redirect()->route('colocation.create')
            ->with('error', 'Vous devez appartenir à une colocation.');
    }

    $payments = Payments::where('colocation_id', $colocation->id)
        ->with(['fromUser', 'toUser'])
        ->latest()
        ->get();

    return view('payments.index', compact('payments'));
}

    public function create()
    {
        return view('payments.create');
    }

   
    public function store(StorePaymentRequest $request)
    {
        
        Payments::create([
            'amount'        => $request->amount,
            'from_user_id'  => $request->from_user_id,
            'to_user_id'    => Auth::id(), 
            'colocation_id' => $request->colocation_id,
            'paid_at'       => now(),
        ]);

        return redirect()->route('payments.index')->with('success', 'Le remboursement a été enregistré.');
    }

    public function edit(string $id)
    { 
        $payment = Payments::findOrFail($id);
        return view('payments.edit', compact('payment'));
    }

    
    public function update(StorePaymentRequest $request, Payments $payment)
    {
        $payment->update([
            'amount'        => $request->amount,
            'from_user_id'  => $request->from_user_id,
        ]);

        return redirect()->route('payments.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy(Payments $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Paiement supprimé.');
    }
}