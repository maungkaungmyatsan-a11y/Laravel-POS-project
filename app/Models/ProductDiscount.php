<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $fillable = [
        'product_id',
        'discount_type',
        'discount_value',
        'discount_amount',
        'is_active',
        'start_at',
        'end_at',

    ];

}
