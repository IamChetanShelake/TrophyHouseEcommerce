<?php

namespace App\Models;

use App\Models\User;
use App\Models\Payment;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'payment_id',
        'user_id',
        'total_price',
        'status'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment that owns the order.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the order products for the order.
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Get all products through order products.
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderProduct::class,
            'order_id', // Foreign key on order_products table
            'id', // Foreign key on products table
            'id', // Local key on orders table
            'variant_id' // Local key on order_products table
        )->join('product_variants', 'products.id', '=', 'product_variants.product_id');
    }

    /**
     * Calculate total quantity of all products in the order.
     */
    public function getTotalQuantityAttribute()
    {
        return $this->orderProducts->sum('quantity');
    }

    /**
     * Get order status badge class for UI.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'approved' => 'badge-info',
            'completed' => 'badge-success',
            'delivered' => 'badge-primary',
            default => 'badge-secondary'
        };
    }
}
