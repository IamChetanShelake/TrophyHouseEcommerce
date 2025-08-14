<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\WishlistItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class wishlistApiController extends Controller
{
    public function index(Request $req)
    {
          $userId = $req->input('user_id'); // Request se user id le

    if (!$userId) {
        return response()->json([
            'status' => false,
             'status_code'=>400,
            'message' => 'User ID is required',
        ], 400);
    }

    $wishlistItems = WishlistItem::where('user_id', $userId)
        ->with('product')
        ->get();

    return response()->json([
        'status' => true,
         'status_code'=>200,
        'wishlist_items' => $wishlistItems
        ],200);
        // $user = User::find($request->user_id);
        // $userId = $request->user_id;

        // return response()->json([
        //     'status' => true,
        //     'status_code'=>200,
        //     'user' => $user,
        // ], 200);
        // Assuming you have a Wishlist model related to User
        // $wishlistItems = $user->wishlistItems()->with('product')->where('user_id', $userId)->get();
        // return  response()->json([
        //     'status' => true,
        //     'status_code'=>200,
        //     'user'=>$wishlistItems,
        // ], 200);
        // if (count($wishlistItems) > 0) {

        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Wishlist fetched successfully',
        //         'wishlist' => $wishlistItems,
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'no Items in wishlist',
        //     ]);
        // }
    }

    // public function addToWishlist($product_id)
    // {

    //     $user = auth()->user();


    //     // Validate that product exists
    //     $product = Product::find($product_id);
    //     if (!$product) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Product not found.'
    //         ], 404);
    //     }

    //     // Check if already in wishlist
    //     $wishlistItem = WishlistItem::where('user_id', $user->id)
    //         ->where('product_id', $product_id)
    //         ->first();

    //     if ($wishlistItem) {
    //         // Increment quantity
    //         $wishlistItem->quantity += 1;
    //         $wishlistItem->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Product Added to wishlist again & Quantity increased in wishlist.',
    //             'wishlist' => $wishlistItem
    //         ]);
    //     }

    //     // Add to wishlist
    //     $wishlist = new WishlistItem();
    //     $wishlist->user_id = $user->id;
    //     $wishlist->product_id = $product_id;
    //     $wishlist->quantity = 1;
    //     $wishlist->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Product added to wishlist.',
    //         'wishlist' => $wishlist
    //     ]);
    // }
    public function addToWishlist(Request $req)
{
    $userId = $req->user; // Sanctum user
    $product_id = $req->product_id;

    if (!$product_id) {
        return response()->json([
            'status' => false,
            'status_code'=>400,
            'message' => 'Product ID is required',
        ], 400);
    }

    // Check if product already in wishlist
    $wishlistItem = WishlistItem::where('user_id', $userId)
        ->where('product_id', $product_id)
        ->first();

    if ($wishlistItem) {
        $wishlistItem->quantity += 1;
        $wishlistItem->save();
    } else {
        $wishlistItem = new WishlistItem();
        $wishlistItem->user_id = $userId;
        $wishlistItem->product_id = $product_id;
        $wishlistItem->quantity = 1;
        $wishlistItem->save();
    }

    // Fetch wishlist item with product details
    $wishlistWithProduct = WishlistItem::where('id', $wishlistItem->id)
        ->with('product')
        ->first();

    return response()->json([
        'status' => true,
        'status_code'=>200,
        'message' => 'Product added to wishlist successfully',
        'wishlist_item' => $wishlistWithProduct
    ],200);
}


    public function removeFromWishlist(Request $req)
    {
           $userId = $req->user; // Sanctum user
    $product_id = $req->product_id;

        // Find the wishlist item by user_id and product_id
        $wishlistItem = WishlistItem::where('user_id', $userId)
            ->where('product_id', $product_id)
            ->first();
        // return response()->json([
        //     'message' => $req->product_id,
        // ]);


        if (!$wishlistItem) {
            return response()->json([
                'status' => false,
                'status_code'=>404,
                'message' => 'Product not found in wishlist.',
            ], 404);
        }

        // Delete the wishlist item
        $wishlistItem->delete();

        return response()->json([
            'status' => true,
            'status_code'=>200,
            'message' => 'Product removed from wishlist.',
        ], 200);
    }
}
