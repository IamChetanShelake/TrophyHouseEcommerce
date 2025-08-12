<?php

namespace App\Http\Controllers\api;

use App\Models\cartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartApiController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $cartItems = cartItem::with('product')->where('user_id', $user->id)->get();

    return response()->json([
        'status' => true,
        'message'=>'cart items fetched successfully !',
        'total items'=>count($cartItems),
        'cart' => $cartItems
    ]);
}

public function addToCart($id)
{
    $user = auth()->user();

    $cartItem = cartItem::where('user_id', $user->id)->where('product_id', $id)->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
        return response()->json(['status' => true, 'message' => 'Product quantity increased in cart.','cart product'=>$cartItem,],200);
    } else {
       $saved = cartItem::create([
            'user_id' => $user->id,
            'product_id' => $id,
            'quantity' => 1
        ]);

        if($saved){

            return response()->json(['status' => true, 'message' => 'Product added to cart.'],200);
        }else{
            return response()->json(['status' => false, 'message' => 'failed ! Product not added to cart.'],400);

        }
    }

}

public function removeFromCart(Request $request, $id)
{
    $user = auth()->user();

    $cartItem = cartItem::where('user_id', $user->id)->where('product_id', $id)->first();
    if (!$cartItem) {
        return response()->json(['status' => false, 'message' => 'Item not found.']);
    }

    if($cartItem->delete()){
        return response()->json(['status' => true, 'message' => 'Removed item from cart.']);
    }else{
        return response()->json(['status' => false, 'message' => 'Fail! cannot remove item from cart.']);
    }
}


}
