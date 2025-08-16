<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customization_image;
use App\Models\cartItem;
use App\Models\User;
use App\Models\CustomizationMessage;
use App\Models\PaymentItem;
use App\Models\Payment;
use App\Models\CustomizationRequest;


class CustomizationRequest extends Model
{
    protected $guarded = [];
    protected $table = 'customization_requests';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class, 'cart_item_id');
    }
    public function messages()
{
    return $this->hasMany(CustomizationMessage::class);
}
public function designer()
{
    return $this->belongsTo(User::class, 'designer_id');
}

public function users()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function images(){
    return $this->hasMany(Customization_image::class);
}
public function paymentItem()
{   
    return $this->belongsTo(PaymentItem::class, 'payment_item_id');
}
// public function products()
// {
//     return $this->hasMany(CustomizationRequest::class, 'order_id', 'order_id')
//                 ->where('status', 'paid');
// }




}