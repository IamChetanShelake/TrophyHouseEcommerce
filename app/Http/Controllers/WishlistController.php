<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\cartItem;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $categories = AwardCategory::with('products')->get();
         $pages = Page::all();
        $wishlistItems = WishlistItem::where('user_id', Auth::id())->with('product')->get();
       $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        // $categories = AwardCategory::select('name')->get();
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        
        return view('website.wishlist', compact('pages','wishlistItems', 'cart_items', 'categories', 'wishlist_count'));
    }

    public function addToWishlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $productId = $request->input('product_id');
        
        $existing = WishlistItem::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
        
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist.',
                 'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ]);
        }

        WishlistItem::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully.',
            'count' => WishlistItem::where('user_id', Auth::id())->count(),
        ]);
    }

    public function removeFromWishlist($id)
    {
        try {
            $wishlistItem = WishlistItem::where('user_id', Auth::id())
                ->where('id', $id)
                ->first();

            if (!$wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in your wishlist.',
                    'count' => WishlistItem::where('user_id', Auth::id())->count(),
                ], 404);
            }

            $wishlistItem->delete();
            //  return redirect()->route('wishlist')->with('success', 'product removed from wishlist');
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist removal error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing the product from your wishlist.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ], 500);
        }
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'wishlist_item_id' => 'required|exists:wishlist_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $wishlistItem = WishlistItem::where('user_id', Auth::id())
                ->where('id', $request->wishlist_item_id)
                ->first();

            if (!$wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wishlist item not found.',
                    'count' => WishlistItem::where('user_id', Auth::id())->count(),
                ], 404);
            }

            $wishlistItem->update(['quantity' => $request->quantity]);

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist quantity update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the quantity.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ], 500);
        }
    }

    public function getWishlistItem($productId)
    {
        try {
            $wishlistItem = WishlistItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if (!$wishlistItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in your wishlist.',
                    'count' => WishlistItem::where('user_id', Auth::id())->count(),
                ], 404);
            }

            return response()->json([
                'success' => true,
                'wishlist_item_id' => $wishlistItem->id,
                'message' => 'Wishlist item found.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Wishlist item fetch error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the wishlist item.',
                'count' => WishlistItem::where('user_id', Auth::id())->count(),
            ], 500);
        }
    }

    public function proceedToCart(Request $request)
    {
        try {
            $wishlistItems = WishlistItem::where('user_id', Auth::id())->with('product')->get();
            
            if ($wishlistItems->isEmpty()) {
                return redirect()->route('cartPage')->with('error', 'Your wishlist is empty.');
            }

            foreach ($wishlistItems as $item) {
                $cartItem = cartItem::where('user_id', Auth::id())
                    ->where('product_id', $item->product_id)
                    ->first();

                if ($cartItem) {
                    // Update quantity if product already in cart
                    $cartItem->quantity += $item->quantity;
                    $cartItem->save();
                } else {
                    // Add new cart item
                    cartItem::create([
                        'user_id' => Auth::id(),
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                    ]);
                }
            }

            return redirect()->route('cartPage')->with('success', 'All wishlist items added to cart successfully!');
        } catch (\Exception $e) {
            \Log::error('Wishlist to cart error: ' . $e->getMessage());
            return redirect()->route('cartPage')->with('error', 'An error occurred while adding wishlist items to cart.');
        }
    }
}