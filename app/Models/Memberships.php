<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memberships extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipsFactory> */
    use HasFactory;

    protected $fillable = [
    'user_id',
    'colocation_id',
    'role',
    'joined',
    'is_banned',
    'reputation',
];


}
