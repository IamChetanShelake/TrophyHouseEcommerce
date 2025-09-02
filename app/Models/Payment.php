<?php

namespace App\Models;

use App\Models\User;
use App\Models\PaymentItem;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

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
