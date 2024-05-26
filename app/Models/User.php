<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'profile_image',
        'email_verified_at',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userDetails(): HasOne
    {
        return $this->hasOne(UserDetails::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'user_id', 'id')->latest();
    }

    public function recipes() : HasMany
    {
        return $this->hasMany(Recipe::class, 'user_id', 'id');
    }
}
