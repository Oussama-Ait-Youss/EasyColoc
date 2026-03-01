<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    /** @use HasFactory<\Database\Factories\ExpensesFactory> */
    use HasFactory;
    protected $fillable = [
        'colocation_id',
        'user_id',
        'category_id',
        'amount',
        'title',
        'date'
        
    ];
    

    public function payer() { return $this->belongsTo(User::class, 'user_id'); }
    public function category() { return $this->belongsTo(Categories::class); }

    // Alias for compatibility with views/controllers that expect `user` relation
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
