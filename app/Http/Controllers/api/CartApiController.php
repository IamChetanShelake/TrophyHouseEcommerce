<?php

namespace App\Http\Controllers\api;

use App\Models\cartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartApiController extends Controller
{
    public function index(Request $req)
{
        $userId = $req->input('user_id'); // Request se user id le

    if (!$userId) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'User ID is required',
        ], 400);
    }

    $cartItems = cartItem::where('user_id', $userId)
        ->with('product') // Product relation load karo
        ->get();

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'Cart items fetched successfully!',
        'total_items' => count($cartItems),
        'cart' => $cartItems
    ]);

    // $user = auth()->user();

    // $cartItems = cartItem::with('product')->where('user_id', $user->id)->get();

    // return response()->json([
    //     'status' => true,
    //     'message'=>'cart items fetched successfully !',
    //     'total items'=>count($cartItems),
    //     'cart' => $cartItems
    // ]);
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
    $productId = $req->input('product_id');

    if (!$userId || !$productId) {
        return response()->json([
            'status' => false,
            'status_code' => 400,
            'message' => 'User ID and Product ID are required',
        ], 400);
    }

    // Check agar already cart me hai
    $cartItem = cartItem::where('user_id', $userId)
        ->where('product_id', $productId)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        $cartItem = new cartItem();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $productId;
        $cartItem->quantity = 1;
        $cartItem->save();
    }

    // Product details ke saath return karo
    $cartWithProduct = cartItem::where('id', $cartItem->id)
        ->with('product')
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
