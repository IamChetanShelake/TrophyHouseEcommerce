<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\productImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    public function allproducts()
    {
        $allproducts = Product::with('images')->get();
         
        if ($allproducts) {

            return response()->json([
                'status' => true,
                'status_code'=>200,
                'message' => 'all products fetched successfully !',
                'products' => $allproducts,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Failed to fetch all products !',
            ], 400);
        }
    }

    public function storeproduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_cat_id' => 'required|exists:category,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:6048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:6048',
            'rating' => 'required|numeric|min:0|max:5',
            'variants.*.size' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        // Create Product
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->product_cat_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->rating = $request->rating;


        // Upload primary image
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('product_images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        // Global colors for all variants
        $colors = $request->colors ?? [];

        // Store Variants
        foreach ($request->variants as $variant) {
            $price = $variant['price'];
            $discount = $variant['discount_percentage'] ?? 0;
            $discounted = $price - ($price * $discount / 100);

            $product->variants()->create([
                'size' => $variant['size'],
                'color' => json_encode($colors),
                'price' => $price,
                'discount_percentage' => $discount,
                'discounted_price' => $discounted,
            ]);
        }

        // Store Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('product_images'), $imageName);

                // Save image record in DB
                $prod_image = new ProductImage();
                $prod_image->product_id = $product->id;
                $prod_image->images = $imageName;
                $prod_image->save();
            }
        }

        return response()->json([
            'success' => true,
             'status_code'=>200,
            'message' => 'Product created successfully!',
            'product' => $product->load('variants', 'images'),
        ],200);
    }

    public function showproduct($id)
    {
        $product = Product::find($id);
        if ($product) {

            return response()->json([
                'status' => true,
                 'status_code'=>200,
                'message' => 'single product fetched successfully !',
                'products' => $product,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                 'status_code'=>400,
                'message' => ' Failed to fetch single product !',
            ], 400);
        }
    }

    public function updateproduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_cat_id' => 'required|exists:category,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:6048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:6048',
            'rating' => 'required|numeric|min:0|max:5',
            'variants.*.size' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::findOrFail($id);

        // Update base fields
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->product_cat_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->rating = $request->rating;

        // Replace main image (optional)
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('product_images/' . $product->image))) {
                File::delete(public_path('product_images/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('product_images'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        // Delete existing variants and recreate
        $product->variants()->delete();

        $colors = $request->colors ?? [];

        foreach ($request->variants as $variant) {
            $price = $variant['price'];
            $discount = $variant['discount_percentage'] ?? 0;
            $discounted = $price - ($price * $discount / 100);

            $product->variants()->create([
                'size' => $variant['size'],
                'color' => json_encode($colors),
                'price' => $price,
                'discount_percentage' => $discount,
                'discounted_price' => $discounted,
            ]);
        }

        // Optional: remove old extra images if you want
        if ($request->hasFile('images')) {
            // Delete old images from folder + DB
            foreach ($product->images as $img) {
                $imgPath = public_path('product_images/' . $img->images);
                if (File::exists($imgPath)) {
                    File::delete($imgPath);
                }
                $img->delete();
            }

            // Save new images
            foreach ($request->file('images') as $image) {
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move(public_path('product_images'), $imageName);

                $product->images()->create([
                    'images' => $imageName
                ]);
            }
        }

        return response()->json([
            'success' => true,
             'status_code'=>200,
            'message' => 'Product updated successfully!',
            'product' => $product->load('variants', 'images')
        ],200);
    }


    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                 'status_code'=>404,
                'message' => 'Product not found.',
            ], 404);
        }

        // Delete related images
        foreach ($product->images as $image) {
            $imagePath = public_path('product_images/' . $image->images);
            if (file_exists($imagePath)) {
                unlink($imagePath); // delete file from storage
            }
            $image->delete(); // delete from DB
        }

        // Delete related variants
        foreach ($product->variants as $variant) {
            $variant->delete();
        }

        // Delete main image
        $mainImagePath = public_path('product_images/' . $product->image);
        if (file_exists($mainImagePath)) {
            unlink($mainImagePath);
        }

        // Finally delete the product
        $product->delete();

        return response()->json([
            'success' => true,
             'status_code'=>200,
            'message' => 'Product deleted successfully.',
        ],200);
    }

    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->has('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('subcategory_id')) {
            $query->where('sub_category_id', $request->subcategory_id);
        }

        return response()->json([
            'success' => true,
            'products' => $query->with(['variants', 'images'])->get()
        ]);
    }
    
     public function getProductsByCategoryAndSubcategory(Request $req)
    {

        // Check if category_id is provided
        if (!$req->has('category_id') || is_null($req->category_id)) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'message' => 'Category ID is required'
            ], 400);
        }


        // Validate inputs
        $req->validate([
            'category_id' => 'required|exists:category,id',
            'subCategory_id' => 'nullable|exists:sub_categories,id',
        ]);

        
            

        $category_id = $req->category_id;
        $subCategory_id = $req->sub_category_id ?? null;


        if ($subCategory_id) {

            $subcategory = SubCategory::where('id', $subCategory_id)
                ->where('category_id', $category_id)
                ->first();
       

            if (!$subcategory) {
                return response()->json([
                    'success' => false,
                    'status_code' => 400,
                    'message' => 'Subcategory does not belong to the specified category'
                ], 400);
            }
        }

        // Query products by category_id
        $categoryProducts = Product::where('category_id', $category_id)->where('sub_category_id', $subcategory->id)
            ->with(['category', 'subcategory', 'variants','images'])
            ->get();



        if (!$subCategory_id) {
            if ($categoryProducts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'No products found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'category' => [
                    'id' => $categoryProducts->first()->category->id,
                    'name' => $categoryProducts->first()->category->name,
                ],
                'sub_category' => [
                    'id' => $categoryProducts->first()->subcategory->id,
                    'title' => $categoryProducts->first()->subcategory->title,
                ],

                'products' => $categoryProducts->map(function ($product) {

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->variants,
                        'discount_percentage' => $product->variants->first()->discount_percentage,
                        'discounted_price' => $product->variants->first()->discounted_price,
                        'color' => $product->variants->first()->color,
                        'size' => $product->variants->first()->size,
                        'category_id' => $product->category->id,
                        'subcategory_id' => $product->subcategory ? $product->subcategory->id : null,
                    ];
                }),
            ], 200);
        }

        // Query products by category_id and subCategory_id
        $subcategoryProducts = Product::where('category_id', $category_id)
            ->where('sub_category_id', $subcategory->id)
            ->with(['category', 'subcategory','variants','images'])
            ->get();

        if ($subcategoryProducts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found'
            ], 404);
        }

//   return response()->json([
//                 'success' => true,
//                 'message' => $subcategoryProducts,
//             ], 200);

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $subcategoryProducts->first()->category->id,
                'name' => $subcategoryProducts->first()->category->name,
            ],
            'subcategory' => [
                'id' => $subcategoryProducts->first()->subcategory->id,
                'title' => $subcategoryProducts->first()->subcategory->title,

            ],
            'total_products'=>$subcategoryProducts->count(),
            'products' => $subcategoryProducts->map(function ($product) {
                  return response()->json([
                'success' => true,
                'message' => $product,
            ], 200);

                // return [
                //     'id' => $product->id,
                //     'name' => $product->title,
                //     'description'=>$product->description,
                //     'rating'=>$product->rating,
                //     'is_top_pick'=>$product->is_top_pick,
                //     'is_best_seller'=>$product->is_best_seller,
                //     'is_new_arrival'=>$product->is_new_arrival,
                //     'price' => $product->variants->first()->price ?? null,
                //     'discount_percentage' => $product->variants->first()->discount_percentage ?? null,
                //     'discounted_price' => $product->variants->first()->discounted_price ?? null,
                //     'color' => $product->variants->first()->color ?? null,
                //     'size' => $product->variants->first()->size ?? null,
                //     'category_id' => $product->category->id ?? null,
                //     'subcategory_id' => $product->subcategory ? $product->subcategory->id : null,
                //       // Add more product fields if needed
                // 'image_url' => $product->images->map(function ($img) {
                //     return $img;
                // }),
                // ];
            }),
        ], 200);
        // Query products by category_id
        $query = Product::where('category_id', $category_id)
            ->with(['category', 'subcategory','images']);

        // Filter by subcategory_id if provided
        if ($subCategory_id) {
            $query->where('sub_category_id', $subCategory_id);
        }

        $products = $query->get();

        // Return response
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'No products found'
            ], 404);
        }
    }

    public function allcat() {}
}
