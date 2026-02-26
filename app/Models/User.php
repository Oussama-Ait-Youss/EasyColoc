<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Payments;
use App\Models\Expenses;
use App\Models\Colocation;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',     
        'is_banned',    
        'reputation',
    ];
    public function colocations() {
        return $this->belongsToMany(Colocation::class, 'memberships')
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }
    public function sentPayments() {
        return $this->hasMany(Payments::class, 'from_user_id');
    }

    public function receivedPayments() {
        return $this->hasMany(Payments::class, 'to_user_id');
    }
    public function expenses() {
        return $this->hasMany(Expenses::class, 'user_id');
    }
    public function activeColocation()
    {
    return $this->colocations()
        ->wherePivot('left_at', null)
        ->first(); 
    }


    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
