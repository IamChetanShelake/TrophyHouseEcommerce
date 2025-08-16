<?php

namespace App\Http\Controllers\api;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class galleryApicontroller extends Controller
{
   public function gallery() {
    $gallery = Gallery::all();

    if ($gallery->count() > 0) {
        // Map each gallery item to include full image URL
        $galleryData = $gallery->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->title ?? null, // if you have a title column
                'image' => $item->image 
                    ? asset('gallery_images/' . $item->image)
                    : null
            ];
        });

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Gallery fetched successfully',
            'gallery' => $galleryData
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'status_code' => 404,
            'message' => 'No gallery items found'
        ], 404);
    }
}
}