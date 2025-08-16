<?php

namespace App\Models;

use App\Models\Product;
use App\Models\CustomizationRequest;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
public function product()
{
    return $this->belongsTo(Product::class);
}
public function customizationRequest()
{
    return $this->belongsTo(CustomizationRequest::class, 'customization_request_id');
}


}
