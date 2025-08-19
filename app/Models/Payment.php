<?php

namespace App\Models;
use App\Models\User;
use App\Models\PaymentItem;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
       
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getOrderStatusAttribute()
{
    $statuses = $this->items->pluck('customizationRequest.status')->filter()->toArray();

    if (empty($statuses)) {
        return 'N/A';
    }

    if (count(array_unique($statuses)) === 1 && $statuses[0] === 'approved') {
        return 'approved';
    }

    if (in_array('pending', $statuses)) {
        return 'Pending';
    }

    if (in_array('accepted', $statuses)) {
        return 'accepted';
    }
    if (in_array('ready_to_pickup', $statuses)) {
        return 'ready_to_pickup';
    }
    if (in_array('delivered', $statuses)) {
        return 'delivered';
    }
    if (in_array('cancelled', $statuses)) {
        return 'cancelled';
    }

    return 'N/A';
}


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
public function items()
{
    return $this->hasMany(PaymentItem::class);
}

public function allCustomizationsApproved(): bool
{
    // assume `items` are loaded; will still work if not loaded but will hit DB
    $this->loadMissing('items.customizationRequest.messages');

    foreach ($this->items as $item) {
        $cr = $item->customizationRequest;
        if ($cr) {
            // approved if any message has is_approved = 1
            if (! $cr->messages->contains('is_approved', 1)) {
                return false;
            }
        }
        // if no customization request, treat as OK; change if you want otherwise
    }
    return true;
}




}