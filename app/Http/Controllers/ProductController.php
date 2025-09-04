<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Occasion;
use App\Models\OccasionProduct;
use App\Models\SubCategory;
use App\Models\productImage;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Imports\ProductImport;
use App\Models\ProductVariant;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    public function createorder()
    {
        $categories = AwardCategory::all();
        // $occasions = Occasion::all();
        $subcategories = SubCategory::all();
        // return $subcategories;
        $products = Product::all();
        $productsizes = ProductVariant::get();
        return view('admin.Orders.createOrder', compact('categories', 'subcategories', 'products', 'productsizes'));
    }


    // Get subcategories for a category
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->select('id', 'title') // important: 'title' for dropdown
            ->get();

        return response()->json($subcategories);
    }


    public function getProducts($subCategoryId)
    {

        $products = Product::where('sub_category_id', $subCategoryId)
            ->get();


        return response()->json($products);
    }

    public function getSizes($productId)
    {
        $sizes = ProductVariant::where('product_id', $productId)
            ->select('id', 'size', 'price', 'discounted_price', 'quantity')
            ->get();

        return response()->json($sizes);
    }


    public function import(Request $request)
    {
        $validated =  $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        //mayurs code
        Excel::import(
            new ProductImport($request->product_cat_id, $request->subcategory_id),
            $request->file('excel_file')
        );

        return back()->with('success', 'Products imported successfully!');
    }

    // public function index()
    // {
    //     $products = Product::with('variants')->get();
    //     $category = AwardCategory::all();
    //     $sizes = ProductVariant::with('product')->whereHas('product')->get();

    //     // return $products->variants;
    //     return view('admin.productCrud.productsTable', compact('products', 'category', 'sizes'));
    // }


    // public function index()
    // {
    //     $products = Product::with('variants')
    //         ->orderBy('title', 'asc')
    //         ->get();

    //     $category = AwardCategory::all();

    //     $sizes = ProductVariant::with('product')
    //         ->whereHas('product')
    //         ->get()
    //         ->sortBy(function ($variant) {
    //             return $variant->product->title;
    //         });

    //     return view('admin.productCrud.productsTable', compact('products', 'category', 'sizes'));
    // }

    public function index()
    {
        $products = Product::with(['variants', 'category', 'subcategory'])
            ->whereHas('category')
            ->whereHas('subcategory')
            ->orderBy('category_id', 'asc')        // 1st sort: Category
            ->orderBy('sub_category_id', 'asc')    // 2nd sort: SubCategory
            ->orderBy('title', 'asc')              // 3rd sort: Product
            ->get();

        $category = AwardCategory::all();

        $sizes = ProductVariant::with(['product.category', 'product.subcategory'])
            ->whereHas('product.category')
            ->whereHas('product.subcategory')
            ->get()
            ->sortBy([
                fn($a, $b) => $a->product->category_id <=> $b->product->category_id,       // Category ID sort
                fn($a, $b) => $a->product->sub_category_id <=> $b->product->sub_category_id, // SubCategory ID sort
                fn($a, $b) => strcmp($a->product->title, $b->product->title),              // Product title sort
            ]);

        return view('admin.productCrud.productsTable', compact('products', 'category', 'sizes'));
    }



    public function add()
    {
        $category = AwardCategory::all();
        return view('admin.productCrud.CreateProducts', compact('category'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_cat_id' => 'required',
            'subcategory_id' => 'required',
            'image' => 'required',
            // 'rating' => 'required|numeric|min:0|max:5',
            'variants.*.size' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;

        $product->category_id = $request->product_cat_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->rating = $request->rating;

        // Checkboxes
        $product->is_top_pick = $request->has('is_top_pick');
        $product->is_best_seller = $request->has('is_best_seller');
        $product->is_new_arrival = $request->has('is_new_arrival');

        // Image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('product_images/', $imageName);
            $product->image = $imageName;
        }
        $product->save();

        // Save product variants

        $colors = $request->colors ?? []; // array of global colors

        foreach ($request->variants as $variant) {

            $price = $variant['price'];
            $discount = $variant['discount_percentage'] ?? 0;
            $quantity = $variant['quantity'] ?? 0;

            $discounted = $price - ($price * $discount / 100);

            $product->variants()->create([
                'size' => $variant['size'],
                'color' => json_encode($colors), // assign global colors
                'price' => $price,
                'discount_percentage' => $discount,
                'discounted_price' => $discounted,
                'quantity' => $quantity,
            ]);
        }
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $imageName = time() . rand(1, 1000) . '.' . $image->extension();

                // Move the file to the public directory
                $image->move('product_images/', $imageName);

                // Save image record in DB
                $prod_image = new productImage();
                $prod_image->product_id = $product->id;
                $prod_image->image = $imageName;
                $prod_image->save();
            }
        }

        return redirect()->route('products')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'subcategory', 'images', 'variants'])->find($id);

        return view('admin.productCrud.ViewProduct', compact('product'));
    }
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id); // Load product with variants
        // Load categories and subcategories for dropdowns
        $categories = AwardCategory::all();
        $subcategories = SubCategory::all();

        return view('admin.productCrud.EditProduct', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->product_cat_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->rating = $request->rating;

        $product->is_top_pick = $request->has('is_top_pick');
        $product->is_best_seller = $request->has('is_best_seller');
        $product->is_new_arrival = $request->has('is_new_arrival');
        // dd($product);

        if ($request->hasFile('image')) {
            $oldimg = public_path('product_images/' . $product->image);
            if (is_file($oldimg)) {
                unlink($oldimg);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('product_images/', $imageName);
            $product->image = $imageName;
        }

        //multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move('product_images', $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
        }

        if ($product->save()) {
            // dd('product saved');
            $existingVariantIds = [];
            $colors = $request->colors ?? [];
            foreach ($request->variants as $variant) {
                $price = $variant['price'];
                $discount = $variant['discount_percentage'] ?? 0;
                $quantity = $variant['quantity'] ?? 0;
                $discounted = $price - ($price * $discount / 100);

                $variantModel = $product->variants()->updateOrCreate(
                    [
                        'id' => $variant['id'] ?? null,
                        'product_id' => $product->id,
                    ],
                    [
                        'size' => $variant['size'],
                        'price' => $price,
                        'color' => json_encode($colors),
                        'discount_percentage' => $discount,
                        'discounted_price' => $discounted,
                        'quantity' => $quantity,
                    ]
                );

                $existingVariantIds[] = $variantModel->id;
            }

            // Remove deleted variants
            $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

            return redirect()->route('products')->with('success', 'Product updated successfully!');
        }

        return redirect()->route('products')->with('error', 'Product update failed!');
    }


    public function destroy($id)
    {
        $product = Product::findorfail($id);
        $productimages = productImage::where('product_id', $id)->get();
        $filePath = public_path('product_images/' . $product->image);
        // dd($filePath);
        if (is_file($filePath)) {
            unlink($filePath);
        }
        // Delete multiple images from folder if it exists
        foreach ($productimages as $image) {
            $filepath = public_path('product_images/' . $image->images);
            if ($image->images && is_file($filepath)) {
                unlink($filepath);
            }
        }
        if ($product->delete()) {
            return redirect()->route('products')->with('success', 'product deleted successfully!');
        } else {
            return redirect()->route('products')->with('error', 'product deleted fail!');
        }
    }

    public function getProductsBySubcategory($id)
    {
        $products = Product::where('sub_category_id', $id)->with('variants')->get();
        return response()->json(['products' => $products]);
    }


    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // Delete from folder
        $filepath = public_path('product_images/' . $image->images);
        if ($image->images && is_file($filepath)) {
            unlink($filepath);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }




    // public function toppick(Request $request,$id){
    //        $product = Product::find($id);
    // $field = $request->field;

    // if (!in_array($field, ['is_top_pick'])) {
    //     return back()->with('error', 'Invalid field');
    // }

    // $product->$field = $request->has('value') ? 1 : 0;
    // $product->save();

    // return back();
    // }



    // public function bestseller(Request $request,$id){
    //        $product = Product::find($id);
    // $field = $request->field;

    // if (!in_array($field, ['is_best_seller'])) {
    //     return back()->with('error', 'Invalid field');
    // }

    // $product->$field = $request->has('value') ? 1 : 0;
    // $product->save();

    // return back();
    // }


    // public function newarrival(Request $request,$id){
    //        $product = Product::find($id);
    // $field = $request->field;

    // if (!in_array($field, ['is_new_arrival'])) {
    //     return back()->with('error', 'Invalid field');
    // }

    // $product->$field = $request->has('value') ? 1 : 0;
    // $product->save();

    // return back();
    // }

    public function toggleField(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $field = $request->field;

        $allowedFields = ['is_top_pick', 'is_best_seller', 'is_new_arrival'];

        if (!in_array($field, $allowedFields)) {
            return back()->with('error', 'Invalid field');
        }

        $product->$field = $request->has('value') ? 1 : 0;
        $product->save();

        return back()->with('success', ucfirst(str_replace('_', ' ', $field)) . ' updated');
    }

    public function cart()
    {
        return view('admin.Cart.index');
    }
    public function orders()
    {
        $orders = Order::latest()->paginate(100);

        return view('admin.Orders.index', compact('orders'));
    }
    public function updateStatus($id, Request $request)
    {
        // dd($id);
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully.']);
    }

    // public function liveSearch(Request $request)
    //     {
    //         $query = $request->query('query', '');

    //         if (strlen($query) < 2) {
    //             return response()->json([]);
    //         }

    //         $products = Product::where('title', 'LIKE', '%' . $query . '%')
    //             ->select('id', 'title','image')
    //             ->take(10)
    //             ->get()
    //             ->map(function ($product) {

    //                 $product->image = asset('product_images/' . $product->image);
    //                 return $product;
    //             });;

    //         return response()->json($products);
    //     }


    public function addQuantity(Request $request, $id)
    {
        $request->validate([
            'add_quantity' => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::findOrFail($id);
        $variant->quantity += $request->add_quantity; // add kela
        $variant->save();

        return redirect()->back()->with('success', 'Quantity updated successfully!');
    }

    public function filterProducts(Request $req)
{
    $query = Product::with('variants');

    if ($req->has('category_id')) {
        $query->where('category_id', $req->category_id);
    }

    if ($req->has('color')) {
        $query->whereHas('variants', function($q) use ($req) {
            $q->where('color', $req->color);
        });
    }

    if ($req->has('size')) {
        $query->whereHas('variants', function($q) use ($req) {
            $q->where('size', $req->size);
        });
    }

    if ($req->has('price_range')) {
        $ranges = (array) $req->price_range; // multiple ho to array me convert karlo
        $query->whereHas('variants', function($q) use ($ranges) {
            foreach ($ranges as $range) {
                [$min, $max] = explode('-', $range);
                $q->orWhereBetween('price', [(int) $min, (int) $max]);
            }
        });
    }

    $products = $query->get();

    if ($products->isEmpty()) {
    return response()->json([
        'status' => false,
        'status_code' => 404,
        'message' => 'Products not found'
    ], 404);
}

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'products' => $products
    ]);
}

public function filterProduct(Request $req)
{
    $query = Product::with('variants');

    // Category filter
    if ($req->filled('category_id')) {
        $query->where('category_id', $req->category_id);
    }

    // Subcategory filter
    if ($req->filled('subcategory_id')) {
        $query->where('sub_category_id', $req->subcategory_id);
    }

    // Color filter
    if ($req->filled('color')) {
        $colors = (array) $req->color;
        $query->whereHas('variants', function ($q) use ($colors) {
            foreach ($colors as $color) {
                $q->orWhere('color', 'LIKE', "%$color%");
            }
        });
    }

    // Size filter
    if ($req->filled('size')) {
        $query->whereHas('variants', function ($q) use ($req) {
            $q->where('size', $req->size);
        });
    }

    // Price range filter
    if ($req->filled('price_range')) {
        $ranges = (array) $req->price_range;
        $query->whereHas('variants', function ($q) use ($ranges) {
            foreach ($ranges as $range) {
                [$min, $max] = explode('-', $range);
                $q->orWhereBetween('price', [(int) $min, (int) $max]);
            }
        });
    }

    $products = $query->get();

    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => 'Products not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'products' => $products
    ]);
}

public function filterByPrice(Request $request)
{
    $min = (int) $request->get('min', 0);
    $max = (int) $request->get('max', 100000);

    // Saare products jinke kisi bhi variant ka discounted_price is range me hai
    $products = Product::whereHas('variants', function($q) use ($min, $max) {
            $q->whereBetween('price', [$min, $max]);
        })
        ->with(['variants' => function($q) use ($min, $max) {
            $q->whereBetween('price', [$min, $max]);
        }])
        ->get();

    $html = view('partials.top_picks_cards', compact('products'))->render();

    return response()->json(['html' => $html]);
}



}
