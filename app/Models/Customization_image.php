<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomizationRequest;

class Customization_image extends Model
{
    protected $guarded=[];

    protected $table= 'customization_images';
    
    public function customRequest(){
    return $this->belongsTo(CustomizationRequest::class,'customization_request_id');
}
}
