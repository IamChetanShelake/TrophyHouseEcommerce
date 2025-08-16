<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cartItem extends Model
{
    protected $guarded = [];


public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
public function variant()
{
    return $this->belongsTo(ProductVariant::class, 'variant_id');
}
public function paymentItems()
{
    return $this->hasMany(PaymentItem::class, 'product_id', 'product_id')
                ->whereColumn('variant_id', 'variant_id')
                ->whereColumn('user_id', 'user_id');
}

}