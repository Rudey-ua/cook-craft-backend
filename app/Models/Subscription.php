<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'type',
        'is_active',
        'is_canceled',
        'start_date',
        'expired_date',
        'provider_name',
        'provider_subscription_id',
        'renewal_count',
        'cancel_reason',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function plan(): belongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
