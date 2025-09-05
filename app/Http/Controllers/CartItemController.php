<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\cartItem;
use App\Models\WishlistItem;
use App\Models\Customization_image;
use App\Models\CustomizationRequest;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentItem;


class CartItemController extends Controller
{
    public function addToCart(Request $request)
    {
        
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'occasional_product_id' => 'nullable|exists:occasional_products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'color' => 'nullable|string',
        ]);
        
        if (!$request->filled('product_id') && !$request->filled('occasional_product_id')) {
            return redirect()->back()->with('error', 'No product specified!');
        }
        
        $userId = auth()->id();
        $productId = $request->product_id ?? null;
        $occasionalProductId = $request->occasional_product_id ?? null;
        $variantId = $request->variant_id;
        $color = $request->color;
        
        // Check if the same product + variant already exists in the cart
       $cartItem = CartItem::where('user_id', $userId)
    ->when($productId, function ($q) use ($productId) {
        return $q->where('product_id', $productId);
    })
    ->when($occasionalProductId, function ($q) use ($occasionalProductId) {
        return $q->where('occasional_product_id', $occasionalProductId);
    })
    ->where('variant_id', $variantId)
    ->when($color, function ($q) use ($color) {
        return $q->where('color', $color);
    })
    ->first();

        
        if ($cartItem) {
            // If already in cart with same size, just increment quantity
            $cartItem->quantity += 1;
            if ($cartItem->save()) {
                return redirect()->back()->with('success', 'Product quantity updated in cart!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong, please try again!');
            }
        } else {
            // Create new cart item
            $addedToCart = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'occasional_product_id' => $occasionalProductId,
                'variant_id' => $variantId,
                'color' => $color,
                'quantity' => 1
            ]);
            // dd('no item with that');
            
            if ($addedToCart) {
                return redirect()->back()->with('success', 'Product added to cart!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong, please try again!');
            }
        }
    }



    public function productDetail($id)
    {
        $product = Product::with('variants')->find($id);
      // Decode colors for each variant
$product->variants->map(function ($variant) {
    $variant->color = is_string($variant->color) ? json_decode($variant->color, true) : $variant->color;
    return $variant;
});

        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('sub_category_id', $product->sub_category_id)
            ->where('id', '!=', $id)
            ->get();
             $categories = AwardCategory::with('products')->get();
         $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem  
          $pages = Page::all();  
          
        return view('website.Product.productDetails', compact('pages','product','wishlist_count','similarProducts','categories','cart_items'));

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(cartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, cartItem $cartItem)
    // {
    //     //
    // }
    public function update(Request $request, CartItem $cartItem)
{
    $request->validate([
        'variant_id' => 'required|exists:product_variants,id',
        'quantity' => 'required|integer|min:1|max:200',
    ]);

    if ($cartItem->user_id !== auth()->id()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $cartItem->variant_id = $request->variant_id;
    $cartItem->quantity = $request->quantity;

    if ($cartItem->save()) {
        return response()->json(['success' => true, 'message' => 'Cart item updated']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to update cart item']);
    }
}

    /**
     * Remove the specified resource from storage.
     */
      public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        // return $cartItem->id;
         $customizationRequest = CustomizationRequest::where('cart_item_id',$cartItem->id)->first();

         if(isset($customizationRequest)){
            $customizationImages = Customization_image::where('customization_request_id',$customizationRequest->id)->get();

            
        if ($customizationImages->isNotEmpty()) {
            foreach ($customizationImages as $image) {
                // Optional: Delete image file from storage if you're saving real files
            
               $imagePath = base_path('customization_images/' . $image->image);
            //   return $imagePath = public_path('customization_images/'.$image->image);


if (is_file($imagePath)) {
   
    unlink($imagePath);
                }

                $image->delete(); // Deletes DB record
            }
        }

        $customizationRequest->delete(); 
          
        }
        // Optional: Ensure only the owner can delete
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        if ($cartItem->delete()) {

            return redirect()->back()->with('success', 'Item removed from cart.');
        }

    }
    // public function destroy($id)
    // {
    //     $cartItem = CartItem::findOrFail($id);


    // if ($cartItem->user_id !== auth()->id()) {
    //     abort(403);
    // }

    // if($cartItem->delete()){

    //     return redirect()->back()->with('success', 'Item removed from cart.');
    // }
    // }
    
    public function createCustomizationRequest(Request $request, $cartId)
    {
        // Validation
        $request->validate([
            
            'description' => 'required|string',
            
            'images' => 'required|array',
            
            'images.*' => 'image', 
            
        ]);
        
        
        // Check if cart item exists and belongs to current user
        
        $cartItem = CartItem::where('id', $cartId)->where('user_id', Auth::id())->firstOrFail();
        
        
        
        // Store customization request using model instance
        
        $customization = new CustomizationRequest();
        
        $customization->user_id = Auth::id();
        
        $customization->cart_item_id = $cartId;
        
        $customization->designer_id = null;
        
        $customization->description = $request->description;
        
        $customization->status = 'pending';
        
        
        $customization->save();
        // Loop through images and store each
        
        foreach ($request->file('images') as $image) {
            
            $imageName = time() . rand(1, 1000) . '.' . $image->extension();
            
            // Move the file to the public directory
            $image->move('customization_images', $imageName);
            
            // Store each image using model instance
            $customization_image = new Customization_image();
            
            $customization_image->user_id = Auth::id();
            
            $customization_image->customization_request_id = $customization->id;
            
            $customization_image->image = $imageName;
            
            $customization_image->save();
            
        }
        
        // return response()->json(['success' => true, 'message' => 'Request sent to designers']);
        return redirect()->back()->with('success', 'Your Customization Request has been sent, please wait for our  response');
    }
    public function createCustomizationRequestforOfflineOrders(Request $request, $orderId)
    {
        // Validation
        $request->validate([
        
            'description' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'image', 
            
        ]);
        
        
        // Check if cart item exists and belongs to current user
        
        $orderItem = PaymentItem::where('id', $orderId)->where('user_id', Auth::id())->firstOrFail();
        
        
        
        // Store customization request using model instance
        
        $customization = new CustomizationRequest();
        
        $customization->user_id = Auth::id();
        
        $customization->cart_item_id = null;
            
         $customization->payment_item_id = $orderItem->id; // link to offline order
        
        $customization->designer_id = null;
        
        $customization->description = $request->description;
        
        $customization->status = 'pending';
        
        
        $customization->save();

        //delivery status 
        $orderItem->delivery_status = 'pending';
        // Loop through images and store each
        foreach ($request->file('images') as $image) {
            
            $imageName = time() . rand(1, 1000) . '.' . $image->extension();
            
            // Move the file to the public directory
            $image->move('customization_images', $imageName);
            
            // Store each image using model instance
            $customization_image = new Customization_image();
            
            $customization_image->user_id = Auth::id();
            
            $customization_image->customization_request_id = $customization->id;
            
            $customization_image->image = $imageName;
            
            $customization_image->save();
            
        }
        
        // return response()->json(['success' => true, 'message' => 'Request sent to designers']);
        return redirect()->back()->with('success', 'Your Customization Request has been sent, please wait for our  response');
    }
}
