<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customization_image;
use App\Models\cartItem;
use App\Models\User;

class CustomizationRequest extends Model
{
    protected $fillable = ['user_id', 'cart_item_id', 'designer_id', 'description', 'image', 'final_image', 'status'];
    protected $table = 'customization_requests';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
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


}