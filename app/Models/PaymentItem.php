<?php

namespace App\Models;
use App\Models\User;
use App\Models\Product; 
use App\Models\ProductVariant;
use App\Models\CustomizationRequest;
use App\Models\PaymentItem;
use App\Models\PaymentItemMessage;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;



use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    protected $guarded = [
       
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
{
    return $this->belongsTo(Payment::class);
}

public function customizationRequest()
{
    return $this->hasOne(CustomizationRequest::class);
}

public function designer()
{
    return $this->belongsTo(User::class, 'designer_id');
}


public function messages()
{
    return $this->hasManyThrough(
        CustomizationMessage::class,
        CustomizationRequest::class,
        'id',                     // CustomizationRequest PK
        'customization_request_id', // CustomizationMessage FK
        'customization_request_id', // PaymentItem FK
        'id'                       // CustomizationRequest PK
    )->orderBy('sent_at', 'asc');
}

}