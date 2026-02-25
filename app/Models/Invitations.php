<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{
    /** @use HasFactory<\Database\Factories\InvitationsFactory> */
    use HasFactory;
    protected $fillable = ['colocation_id', 'email', 'token', 'status', 'expires_at'];

    public function colocation() {
        return $this->belongsTo(Colocation::class);
    }

    public function isValid() {
        return $this->status === 'pending' && ($this->expires_at === null || $this->expires_at->isFuture());
    }
}
