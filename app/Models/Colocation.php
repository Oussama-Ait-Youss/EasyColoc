<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Expenses;
use App\Models\Memberships;
use App\Models\Invitations;

class Colocation extends Model
{
    /** @use HasFactory<\Database\Factories\ColocationFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'invite_token',
        'status'
    ];

    public function memberships() {
        return $this->hasMany(Memberships::class);
    }

    // Invitations liées à cette colocation
    public function invitations() {
        return $this->hasMany(Invitations::class);
    }

    public function categories() {
        return $this->hasMany(Categories::class);
    }

    public function expenses() {
        return $this->hasMany(Expenses::class);
    }

    public function payments() {
        return $this->hasMany(Payments::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withPivot('role', 'joined_at', 'left_at', 'reputation')
            ->withTimestamps();
    }
    
}
