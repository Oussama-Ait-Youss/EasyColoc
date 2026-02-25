<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use App\Http\Requests\StorePaymentRequest;



class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payments::all();
        return view('payments.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        Payments::created([
            'amount' => $request->amount,

            'from_user_id' => $request->from_user_id,

            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('payments.index')->with('success','payment avec success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $payments = Payments::findOrFail($id);
        return view('payment.edit',compact('payments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePaymentRequest $request, Payments $payments)

    {
        Payments::updated([
            'amount' => $request->amount,

            'from_user_id' => $request->from_user_is,

            'colocation_id' => $request->colocation_id,
        ]);
        return redirect()->route('payments.index')->with('success','payment modifier avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
