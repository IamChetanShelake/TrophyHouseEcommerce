<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'cf_order_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'amount',
        'currency',
        'status',
        'payment_mode',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class, 'payment_order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function customer()
{
    return $this->belongsTo(User::class, 'customer_id');
}

}