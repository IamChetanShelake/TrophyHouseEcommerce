<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'variant_id',
        'unit_price',
        'quantity',
        'status'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the order that owns the order product.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the payment that owns the order product.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the product variant for this order product.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the product through the variant.
     */
    public function product()
    {
        return $this->hasOneThrough(Product::class, ProductVariant::class, 'id', 'id', 'variant_id', 'product_id');
    }

    /**
     * Calculate total price for this order product.
     */
    public function getTotalPriceAttribute()
    {
        return $this->unit_price * $this->quantity;
    }
}