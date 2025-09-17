<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class PaymentDeliveryStatus extends Model
{
    protected $guarded = [];

    public $timestamps = false; // we are manually handling changed_at

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
