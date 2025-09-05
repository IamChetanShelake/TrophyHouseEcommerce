<?php

namespace App\Http\Controllers\api;

use App\Models\cartItem;
use App\Models\Product;
use App\Models\OccasionProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CartApiController extends Controller
{
    public function index(Request $req)
{

        $user = auth()->user();

        // Eager load product, category, subcategory, and variant
        $cartItems = CartItem::with([
            'product.category',
            'product.subcategory',
            'variant'
        ])
        ->where('user_id', $user->id)
        ->get()
        ->map(function ($item) {
            return [
                'user_id' => $item->user_id,
                'quantity' => $item->quantity,
                'product' => $item->product,
                'category' => $item->product->category ?? null,
                'subcategory' => $item->product->subcategory ?? null,
                'variant' => $item->variant ?? null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Cart items fetched successfully!',
            'total_items' => count($cartItems),
            'cart' => $cartItems
        ]);
    }


// public function addToCart()
// {
//     $user = auth()->user();

//     $cartItem = cartItem::where('user_id', $user->id)->where('product_id', $id)->first();

//     if ($cartItem) {
//         $cartItem->quantity += 1;
//         $cartItem->save();
//         return response()->json(['status' => true, 'message' => 'Product quantity increased in cart.','cart product'=>$cartItem,],200);
//     } else {
//       $saved = cartItem::create([
//             'user_id' => $user->id,
//             'product_id' => $id,
//             'quantity' => 1
//         ]);

//         if($saved){

//             return response()->json(['status' => true, 'message' => 'Product added to cart.'],200);
//         }else{
//             return response()->json(['status' => false, 'message' => 'failed ! Product not added to cart.'],400);

//         }
//     }

// }
public function addToCart(Request $req)
{
    $userId = $req->input('user_id'); 
    $productId = $req->input('product_id') ?? null;
    $occasionalProductId = $req->input('occasional_product_id') ?? null;

    
    if (!$userId || !$productId) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'User ID and Product ID are required',
        ], 400);
    }
    $product = Product::with('variants')->find($productId);
    $occasionalProduct = OccasionProduct::with('variants')->find($occasionalProductId);

     if (!$product && !$occasionalProduct) {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => 'Product not found',
        ], 404);
    }

    
    if($req->filled('variant_id')){
        $variantId = $req->input('variant_id');
    }else{

        $variantId = $product->variants->first()->id ? $product->variants->first()->id :  $occasionalProduct->variants->first()->id;
    }

     $variant = $product->variants->where('id', $variantId)->first() ?? $occasionalProduct->variants->where('id', $variantId)->first();

     if (!$variant) {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => 'Variant not found',
        ], 404);
    }
    // Decode variant colors (assuming stored as JSON in DB)
    $variantColors = is_string($variant->color)
    ? json_decode($variant->color, true)
        : (is_array($variant->color) ? $variant->color : []);

    if (empty($variantColors)) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'No colors available for this variant',
        ], 400);
    }


    if ($req->filled('color')) {
        $color = $req->input('color');
    }else{
        $color = $variantColors[0];
        // $firstVariant = $product->variants->first();
        // if ($firstVariant && $firstVariant->color) {
        //     $decoded = is_string($firstVariant->color) ? json_decode($firstVariant->color, true) : $firstVariant->color;
        //     $color = is_array($decoded) ? $decoded[0] ?? null : $decoded;
        // }
    }

    // Check agar already cart me hai
    $cartItem = cartItem::where('user_id', $userId)
    ->when($productId, function($q) { return $q->where('product_id', $productId); })
    ->when($occasionalProductId, function($q) { return $q->where('occasional_product_id', $occasionalProductId);})
    ->where('variant_id', $variantId)
    ->where('color', $color)
    ->first();


    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        $cartItem = new cartItem();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $productId;
        $cartItem->occasional_product_id = $occasionalProductId;
        $cartItem->variant_id = $variantId;
        $cartItem->color = $color;
        $cartItem->quantity = 1;
        $cartItem->save();
    }

    // Product details ke saath return karo
    $cartWithProduct = cartItem::where('id', $cartItem->id)
        ->with('product')
         ->with('occasionalProduct')
        ->first();

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'Product added to cart successfully',
        'cart_item' => $cartWithProduct
    ], 200);
}

// public function removeFromCart(Request $request, $id)
// {
//     $user = auth()->user();

//     $cartItem = cartItem::where('user_id', $user->id)->where('product_id', $id)->first();
//     if (!$cartItem) {
//         return response()->json(['status' => false, 'message' => 'Item not found.']);
//     }

//     if($cartItem->delete()){
//         return response()->json(['status' => true, 'message' => 'Removed item from cart.']);
//     }else{
//         return response()->json(['status' => false, 'message' => 'Fail! cannot remove item from cart.']);
//     }
// }
public function removeFromCart(Request $req)
{
    $userId = $req->input('user_id');
    $productId = $req->input('product_id');

    if (!$userId || !$productId) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'User ID and Product ID are required',
        ], 400);
    }

    $cartItem = cartItem::where('user_id', $userId)
        ->where('product_id', $productId)
        ->first();

    if (!$cartItem) {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => 'Product not found in cart',
        ], 404);
    }

    $cartItem->delete();

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'Product removed from cart successfully',
    ]);
}


}
