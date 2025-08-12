<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\cartItem;

class CustomizationMessage extends Model
{
    protected $guarded = [
       
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver__id');
    }

    public function customizationRequest()
    {
        return $this->belongsTo(CustomizationRequest::class);
    }
    public function cartItem()
{
    return $this->belongsTo(cartItem::class,'cart_item_id');
}
}
