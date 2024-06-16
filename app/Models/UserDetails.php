<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'bio',
        'time_zone',
        'language',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
