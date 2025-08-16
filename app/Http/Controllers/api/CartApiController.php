<?php

namespace App\Http\Controllers\api;

use App\Models\cartItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartApiController extends Controller
{
    // Get cart items for a specific user
    public function index(Request $request)
    {
    $user = User::find($request->user_id);

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
    // Add a product to the cart
    public function addToCart(Request $request, $id)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $cartItem = cartItem::where('user_id', $userId)->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Product quantity increased in cart.',
                'cart_product' => $cartItem
            ], 200);
        } else {
            $saved = cartItem::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => 1
            ]);

            if ($saved) {
                return response()->json(['status' => true, 'message' => 'Product added to cart.'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed! Product not added to cart.'], 400);
            }
        }
    }

    // Remove product from cart
    public function removeFromCart(Request $request, $id)
    {
        $userId = $request->user_id;

        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $cartItem = cartItem::where('user_id', $userId)->where('product_id', $id)->first();

        if (!$cartItem) {
            return response()->json(['status' => false, 'message' => 'Item not found.']);
        }

        if ($cartItem->delete()) {
            return response()->json(['status' => true, 'message' => 'Removed item from cart.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Fail! Cannot remove item from cart.']);
        }
    }
}
