<?php

namespace App\Http\Controllers\api;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class galleryApicontroller extends Controller
{
   public function gallery() {
        
        $gallery = Gallery::all();
        
        if($gallery){
              return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'gallery fetched successfully',
                    'gallery'=>$gallery,
                     'image' => $gallery->image 
                ? asset('gallery_images/' .  $gallery->image )
                : null
                ], 200);
        }
        
    }
}
