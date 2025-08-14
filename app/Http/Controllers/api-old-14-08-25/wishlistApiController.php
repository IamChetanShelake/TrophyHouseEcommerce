<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class wishlistApiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'user' => $user,
        ], 200);
        // Assuming you have a Wishlist model related to User
        $wishlistItems = $user->wishlistItems()->with('product')->get();
        if (count($wishlistItems) > 0) {

            return response()->json([
                'status' => true,
                'message' => 'Wishlist fetched successfully',
                'wishlist' => $wishlistItems,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'no Items in wishlist',
            ]);
        }
    }

    public function addToWishlist($product_id)
    {

        $user = auth()->user();


        // Validate that product exists
        $product = Product::find($product_id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Check if already in wishlist
        $wishlistItem = WishlistItem::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($wishlistItem) {
            // Increment quantity
            $wishlistItem->quantity += 1;
            $wishlistItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Product Added to wishlist again & Quantity increased in wishlist.',
                'wishlist' => $wishlistItem
            ]);
        }

        // Add to wishlist
        $wishlist = new WishlistItem();
        $wishlist->user_id = $user->id;
        $wishlist->product_id = $product_id;
        $wishlist->quantity = 1;
        $wishlist->save();

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist.',
            'wishlist' => $wishlist
        ]);
    }


    public function removeFromWishlist($id)
    {
        $user = auth()->user();

        // Find the wishlist item by user_id and product_id
        $wishlistItem = WishlistItem::where('user_id', $user->id)
            ->where('product_id', $id)
            ->first();
        return response()->json([

            'message' => $wishlistItem,
        ]);


        if (!$wishlistItem) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in wishlist.',
            ], 404);
        }

        // Delete the wishlist item
        $wishlistItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product removed from wishlist.',
        ], 200);
    }
}
