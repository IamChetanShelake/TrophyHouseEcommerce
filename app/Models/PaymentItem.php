<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    protected $fillable = [
        'payment_order_id',
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}