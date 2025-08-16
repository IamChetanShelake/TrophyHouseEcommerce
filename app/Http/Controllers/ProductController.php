<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Occasion;
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
        return view('admin.Orders.createOrder', compact('categories', 'subcategories', 'products'));
    }


    // Get subcategories for a category
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->select('id', 'title') // important: 'title' for dropdown
            ->get();

        return response()->json($subcategories);
    }

    // Get products for a subcategory
    // public function getProducts($subCategoryId)
    // {
    //     // dd($subCategoryId);
    //     $products = Product::where('sub_category_id', $subCategoryId)
    //         ->select('id', 'title') // important: 'title' for dropdown
    //         ->get();

    //     return response()->json($products);
    // }
    public function getProducts($subCategoryId)
    {

        $products = Product::where('sub_category_id', $subCategoryId)
            ->get();


        return response()->json($products);
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
    public function index()
    {
        $products = Product::all();
        $category = AwardCategory::all();
        return view('admin.productCrud.productsTable', compact('products', 'category'));
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

            $discounted = $price - ($price * $discount / 100);

            $product->variants()->create([
                'size' => $variant['size'],
                'color' => json_encode($colors), // assign global colors
                'price' => $price,
                'discount_percentage' => $discount,
                'discounted_price' => $discounted,
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
        if ($image->images && if_file($filepath)) {
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



}
