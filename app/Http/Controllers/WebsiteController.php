<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\About;
use App\Models\Client;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\cartItem;
use App\Models\SubCategory;
use App\Models\Testimonial;
use App\Mail\GetintouchMail;
use App\Models\WishlistItem;
use App\Models\ProductionTask;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\ProductVariant;
use App\Models\OccasionProduct;
use App\Models\Occasion;
use App\Models\CustomizationRequest;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Updated to lowercase 'cartItem'

class WebsiteController extends Controller
{
    private function getSizeLabels()
    {
        return [
            'below 5 inch',
            '5-8 inch',
            '8-10 inch',
            '10-12 inch',
            '12-15 inch',
            '15-18 inch',
            '18-24 inch',
            '24-36 inch',
            '36 inch and above',
        ];
    }
    public function filterProducts(Request $req)
{
    $min = $req->min_price ?? 0;
    $max = $req->max_price ?? 100000;

    $products = Product::with('variants')
        ->whereHas('variants', function($q) use ($min, $max) {
            $q->where(function ($query) use ($min, $max) {
                $query->whereBetween('discounted_price', [$min, $max])
                      ->orWhereBetween('price', [$min, $max]);
            });
        })
        ->get();

    return response()->json(['products' => $products]);
}


    public function Websiteindex()
    {
        $products = Product::with('variants')->get();
        $occProducts = OccasionProduct::with('variants')->get();
        $occasions = Occasion::all();
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_product_ids = Auth::check() ? WishlistItem::where('user_id', Auth::id())->pluck('product_id')->toArray() : [];
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $testimonials = Testimonial::all();
        $clients = Client::all();
        $aboutus = About::all();
        $pages = Page::all();
        
        $minPrice = ProductVariant::whereNotNull('discounted_price')->min('discounted_price') ?? 0;
$maxPrice = ProductVariant::whereNotNull('discounted_price')->max('discounted_price') ?? 5000;
        // foreach($products as $prod){
        //    echo $prod->variants->count()."<br>";
        // }
        

         return view('website.home', compact('pages', 'testimonials', 'aboutus', 'clients', 'products','occasions', 'occProducts', 'categories', 'cart_items', 'wishlist_product_ids', 'wishlist_count','minPrice','maxPrice'));
    }

    public function contact()
    {
        // $categories = AwardCategory::select('name')->get();
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $pages = Page::all();
        return view('website.contact', compact('pages', 'categories', 'cart_items', 'wishlist_count'));
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable',
            'message' => 'required|string',
        ]);

        try {

            // dd($validated);
            $contact = Contact::create($validated);
            Mail::to('mayurjawale999@gmail.com')->send(new ContactFormSubmitted($contact));
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Contact form submission error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while sending your message. Please try again.');
        }
    }
    public function sendGetintouch(Request $request)
    {
        // dd('came to mailer ');
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Send mail
        Mail::to('mayurjawale999@gmail.com')->send(new GetintouchMail($validated));

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    public function gallery()
    {
        $products = Product::with('variants')->get();
        $categories = AwardCategory::with('products')->get();
        $galleries = Gallery::select('id', 'title', 'image')->get();
        // $categories = AwardCategory::select('name')->get();
        $cart_items = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_product_ids = Auth::check() ? WishlistItem::where('user_id', Auth::id())->pluck('product_id')->toArray() : [];
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $pages = Page::all();
        return view('website.gallery', compact('pages', 'galleries', 'categories', 'cart_items', 'wishlist_product_ids', 'wishlist_count', 'products'));
    }

    public function searchLive(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->query('query');
            $products = Product::where('title', 'like', '%' . $query . '%')
                ->select('id', 'title')
                ->limit(10)
                ->get();
            return response()->json($products);
        }
        abort(403);
    }

    // public function viewProducts()
    // {
    //     $products = Product::paginate(16);
    //     $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
    //     $categories = AwardCategory::with('products')->get();
    //     $pages = Page::all();
    //     $cart_items = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
    //     $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;


        
    //     $allPrices = ProductVariant::pluck('price')->sort()->values();
       
    //     $minPrice = floor($allPrices->min() / 500) * 500;
    //     $maxPrice = ceil($allPrices->max() / 500) * 500;
    //     $priceRanges = [];
    //     $step = 500;
    //     for ($i = $minPrice; $i < $maxPrice; $i += $step) {
    //         $range = '₹' . $i . ' - ₹' . ($i + $step);
    //         $priceRanges[] = $range;
           
    //     }
       
    //     $priceRanges[] = '₹' . $maxPrice . ' & above';


    //     //for colors --------------------------------------
    //     $allColors = ProductVariant::whereNotNull('color')
    //         ->pluck('color')
    //         ->flatMap(function ($color) {
    //             // Handle JSON string or array
    //             if (is_string($color)) {
    //                 $decoded = json_decode($color, true);
    //                 return is_array($decoded) ? $decoded : [];
    //             }
    //             return is_array($color) ? $color : ($color ? [$color] : []);
    //         })
    //         ->filter()
    //         ->map(function ($color) {
    //             return ucfirst(strtolower(trim($color))); 
    //         })
    //         ->unique()
    //         ->values()
    //         ->toArray();


    //     $sizes = $this->getSizeLabels();
    //     return view('website.Product.products', compact('wishlist_count', 'cart_items', 'pages', 'products', 'wishlist_count', 'categories', 'allPrices', 'priceRanges', 'allColors', 'sizes'));
    // }
    public function viewProducts(Request $request)
    {
        $subcategoryId = $request->query('subcategory');
        // return $subcategoryId;
        //   //   $products = Product::paginate(16);
        $products = Product::get();
        // $products = Product::where('subcategory_id', $subcategoryId)
        // ->paginate(16);
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();
        $pages = Page::all();
        $cart_items = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;


        //for prices --------------------------------------
        $allPrices = ProductVariant::pluck('price')->sort()->values();
        // Optional: create dynamic price ranges (in ₹500 gaps)
        $minPrice = floor($allPrices->min() / 500) * 500;
        $maxPrice = ceil($allPrices->max() / 500) * 500;
        $priceRanges = [];
        $step = 500;
        for ($i = $minPrice; $i < $maxPrice; $i += $step) {
            $range = '₹' . $i . ' - ₹' . ($i + $step);
            $priceRanges[] = $range;
            // echo  $range;
        }
        // Add a "₹X & above" range
        $priceRanges[] = '₹' . $maxPrice . ' & above';


        //for colors --------------------------------------
        $allColors = ProductVariant::whereNotNull('color')
            ->pluck('color')
            ->flatMap(function ($color) {
                // Handle JSON string or array
                if (is_string($color)) {
                    $decoded = json_decode($color, true);
                    return is_array($decoded) ? $decoded : [];
                }
                return is_array($color) ? $color : ($color ? [$color] : []);
            })
            ->filter()
            ->map(function ($color) {
                return ucfirst(strtolower(trim($color))); // Normalize: lowercase and capitalize first letter
            })
            ->unique()
            ->values()
            ->toArray();

        $sizes = $this->getSizeLabels();
        return view('website.Product.products', compact('wishlist_count', 'cart_items', 'pages', 'products', 'wishlist_count', 'categories', 'allPrices', 'priceRanges', 'allColors', 'sizes', 'subcategoryId'));
    }

    public function cart()
    {
        if (Auth::check()) {
           $cartItems = cartItem::with('product','occasionalProduct','customizationRequest')->where('user_id', Auth::id())->get(); // Updated to cartItem
            $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
            if ($cartItems->isEmpty()) {
                $cart_items = 0;
            }
            $product = Product::with('variants')->get();
            $occasionalProduct = OccasionProduct::with('variants')->get();
            $similarProducts = Product::with('category')
                ->with('subcategory')
                ->get();
            $similarOccProducts = OccasionProduct::with(['category', 'subcategory'])->get();

$allSimilarProducts = $similarProducts->concat($similarOccProducts);

            $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
            $categories = AwardCategory::with('products')->get();
            $pages = Page::all();
         $customization_request = CustomizationRequest::where('user_id', Auth::id())->get();
         $customizationRequest = CustomizationRequest::with('designer')
    ->where('user_id', Auth::id())
    ->first();


            return view('website.cart', compact('pages','customizationRequest', 'cartItems', 'cart_items','similarProducts', 'wishlist_count', 'categories','customization_request'));
        }
        return redirect()->route('login');
    }

    public function viewCategory($id = null)
    {
        $category = AwardCategory::findOrFail($id);
        $subcategories = SubCategory::where('category_id', $id)->get();
        $products = Product::whereIn('sub_category_id', $subcategories->pluck('id'))->get();
        $cart_items = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        \Log::info('Category:', [$category->toArray()]);
        \Log::info('Subcategories:', $subcategories->toArray());
        \Log::info('Products:', $products->toArray());
        $categories = AwardCategory::with('products')->get();
        $pages = Page::all();
        return view('website.categories', compact('pages', 'category', 'subcategories', 'products', 'cart_items', 'wishlist_count', 'categories'));
    }

    public function viewProduct($id)
    {
        $products = Product::where('category_id', $id)->get();
        $categories = AwardCategory::with('products')->get();
        $pages = Page::all();
        return view('website.categories', compact('pages', 'products', 'categories'));
    }

    public function cartupdate(Request $request, $id)
    {
         $request->validate([
            'quantity' => 'required|integer|min:1|max:200',
            'variant_id' => 'required|exists:product_variants,id',
            'color'=>'nullable|string',
        ]);

        $cartItem = cartItem::where('id', $id)->where('user_id', Auth::id())->firstOrFail(); // Updated to cartItem
        $cartItem->update([
            'quantity' => $request->quantity,
            'variant_id' => $request->variant_id,
            'color' => $request->color,
        ]);

        return response()->json(['success' => true, 'message' => 'Cart updated successfully']);
    }

    public function address()
    {
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();
        $pages = Page::all();
        // Check if user has addresses
        $addresses = Address::where('user_id', Auth::id())->get();
        if ($addresses->isEmpty()) {
            return view('website.address', compact('pages', 'cart_items', 'wishlist_count', 'categories'));
        } else {

            return redirect()->route('DeliveryaddressPage');
        }
    }
    public function addnewaddress()
    {
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();

        // Check if user has addresses
        $pages = Page::all();
        return view('website.addNewAddress', compact('pages', 'cart_items', 'wishlist_count', 'categories'));
    }

    public function Deliveryaddress()
    {
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();
        $addresses = Address::where('user_id', Auth::id())->get();
        $selectedAddress = Address::where('user_id', Auth::id())->where('is_default', true)->first();
        $cartItems = cartItem::with('product.variants')->where('user_id', Auth::id())->get(); // Updated to cartItem
        $pages = Page::all();
        return view('website.deliveryaddress', compact('pages', 'cart_items', 'wishlist_count', 'categories', 'addresses', 'selectedAddress', 'cartItems'));
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pincode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:255',
        ]);

        try {
            $addressCount = Address::where('user_id', Auth::id())->count();
            $validated['user_id'] = Auth::id();
            $validated['is_default'] = $addressCount === 0; // Set as default if it's the first address

            Address::create($validated);
            return redirect()->route('DeliveryaddressPage')->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            \Log::error('Address creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving your address. Please try again.');
        }
    }

    public function editAddress($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();
        $pages = Page::all();
        return view('website.address', compact('pages', 'address', 'cart_items', 'wishlist_count', 'categories'));
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pincode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string|max:255',
        ]);

        try {
            $address->update($validated);
            return redirect()->route('DeliveryaddressPage')->with('success', 'Address updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Address update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your address. Please try again.');
        }
    }

    public function deleteAddress($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        try {
            if ($address->is_default) {
                $nextAddress = Address::where('user_id', Auth::id())->where('id', '!=', $id)->first();
                if ($nextAddress) {
                    $nextAddress->update(['is_default' => true]);
                }
            }
            $address->delete();
            return redirect()->route('addressPage')->with('success', 'Address deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Address deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the address. Please try again.');
        }
    }

    public function setDefaultAddress($id)
    {
        try {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $address->update(['is_default' => true]);
            return response()->json(['success' => true, 'message' => 'Default address set successfully']);
        } catch (\Exception $e) {
            \Log::error('Set default address error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while setting the default address']);
        }
    }

    public function pageDetail($id)
    {
        $page = Page::find($id);
        $pages = Page::all();
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        return view('website.pageDetail', compact('page', 'categories', 'cart_items', 'wishlist_count', 'pages'));
    }

    public function privacyPolicy()
    {
        return view('website.privacyPolicy');
    }

    public function termAndCond()
    {
        return view('website.termAndCond');
    }

    public function refundPolicy()
    {
        return view('website.refundPolicy');
    }

    public function payment()
    {
        $wishlist_count = Auth::check() ? WishlistItem::where('user_id', Auth::id())->count() : 0;
        $categories = AwardCategory::with('products')->get();
        $cart_items = Auth::check() ? cartItem::where('user_id', Auth::id())->count() : 0; // Updated to cartItem
        $pages = Page::all();
        return view('website.payment', compact('wishlist_count', 'categories', 'cart_items', 'pages'));
    }
}
