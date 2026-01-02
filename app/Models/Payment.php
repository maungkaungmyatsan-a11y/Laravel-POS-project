<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     protected $fillable = [
        'account_type',
        'account_name',
        'account_number',
    ];
}
