<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'model_id',
      'model_type',
      'payment_method',
      'transaction_data',
      'payment_date',
      'amount',
      'currency',
      'status'
    ];
}
