<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentsFactory> */
    use HasFactory;
    protected $fillable = ['colocation_id', 'from_user_id', 'to_user_id', 'amount', 'paid_at'];

    public function colocation() {
        return $this->belongsTo(Colocation::class);
    }

    public function debtor() {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function creditor() {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
