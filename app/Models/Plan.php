<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'type'
    ];

    protected $casts = [
        'price' => 'array',
    ];

    public function getPriceInCurrency(string $currency)
    {
        return $this->price[$currency] ?? null;
    }
}
