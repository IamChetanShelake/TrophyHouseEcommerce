<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    protected $table = 'coupons';

    protected $casts = [
        'start_date'  => 'date',
        'expiry_date' => 'date',
    ];
    
}
