<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionTask extends Model
{
     protected $guarded = []; 
     // Each task belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Each task is linked to a payment item
    public function paymentItem()
    {
        return $this->belongsTo(PaymentItem::class);
    }

    // Each task is linked to a payment (order)
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Assigned production man
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
