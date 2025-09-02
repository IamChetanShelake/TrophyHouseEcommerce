<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\productImage;
use App\Models\SubCategory;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;




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
    $category_id     = $req->category_id;
    $subCategory_id  = $req->sub_category_id;

    // Build base query
    $query = Product::with([
        'category',
        'subcategory',
        'variants',
        'images'
    ]);

    // Apply category filter if provided
    if (!empty($category_id)) {
        $query->where('category_id', $category_id);
    }

    // Apply subcategory filter if provided
    if (!empty($subCategory_id)) {
        $query->where('sub_category_id', $subCategory_id);
    }

    $products = $query->get();

    if ($products->isEmpty()) {
        return response()->json([
            'success'      => false,
            'status_code'  => 404,
            'message'      => 'No products found'
        ], 404);
    }

    return response()->json([
        'success'        => true,
        'status_code'    => 200,
        'category'       => [
            'id'   => $products->first()->category->id ?? null,
            'name' => $products->first()->category->name ?? null,
        ],
        'subcategory'    => [
            'id'    => $products->first()->subcategory->id ?? null,
            'title' => $products->first()->subcategory->title ?? null,
        ],
        'total_products' => $products->count(),
        'products'       => $products->map(function ($product) {
           return response()->json([
                'success' => true,
                'message' => $product,
            ], 200);

        }),
    ], 200);
}


    public function gallery() {
        
        $gallery = Gallery::all();
        
        if($gallery){
              return response()->json([
                    'success' => true,
                    'status_code' => 200,
                    'message' => 'gallery fetched successfully',
                    'gallery'=>$gallery,
                ], 200);
        }
        
    }

    public function filterProducts(Request $req)
{
    $query = Product::query()->with(['variants' => function ($q) use ($req) {
        // also filter variants in eager load so we don’t return unrelated ones
        if ($req->has('size')) {
            $sizes = $req->input('size');
            $sizes = is_array($sizes) ? $sizes : [$sizes];
            $sizes = array_map(fn($s) => strtolower(str_replace(' ', '', trim($s))), $sizes);

            $q->whereIn(
                DB::raw("LOWER(REPLACE(size, ' ', ''))"),
                $sizes
            );
        }
    }]);

    // Category / Subcategory
    if ($req->filled('category_id')) {
        $query->where('category_id', (int) $req->input('category_id'));
    }
    if ($req->filled('sub_category_id')) {
        $query->where('sub_category_id', (int) $req->input('sub_category_id'));
    }

    // COLORS
    if ($req->has('color')) {
        $colors = $req->input('color');
        $colors = is_array($colors) ? $colors : [$colors];
        $colors = array_values(array_filter(array_map(fn($c) => mb_strtolower(trim($c)), $colors)));

        if (!empty($colors)) {
            $query->whereHas('variants', function ($vq) use ($colors) {
                $vq->where(function ($w) use ($colors) {
                    foreach ($colors as $c) {
                        $w->orWhereRaw('LOWER(color) LIKE ?', ["%{$c}%"]);
                    }
                });
            });
        }
    }

    // SIZES
    if ($req->has('size')) {
        $sizes = $req->input('size');
        $sizes = is_array($sizes) ? $sizes : [$sizes];
        $sizes = array_map(fn($s) => strtolower(str_replace(' ', '', trim($s))), $sizes);

        if (!empty($sizes)) {
            $query->whereHas('variants', function ($vq) use ($sizes) {
                $vq->whereIn(
                    DB::raw("LOWER(REPLACE(size, ' ', ''))"),
                    $sizes
                );
            });
        }
    }

    // PRICE FILTERS
    $min = $req->input('min_price');
    $max = $req->input('max_price');

    if ($min !== null || $max !== null) {
        $min = $min !== null ? (int) $min : 0;
        $max = $max !== null ? (int) $max : PHP_INT_MAX;

        $query->whereHas('variants', function ($vq) use ($min, $max) {
            $vq->whereBetween('discounted_price', [$min, $max]);
        });
    } elseif ($req->has('price_range')) {
        $ranges = (array) $req->input('price_range');
        $cleanRanges = [];

        foreach ($ranges as $range) {
            if (is_string($range) && str_contains($range, '-')) {
                [$rmin, $rmax] = array_map('trim', explode('-', $range, 2));
                $rmin = (int) $rmin;
                $rmax = (int) $rmax;
                if ($rmax >= $rmin) {
                    $cleanRanges[] = [$rmin, $rmax];
                }
            }
        }

        if (!empty($cleanRanges)) {
            $query->whereHas('variants', function ($vq) use ($cleanRanges) {
                $vq->where(function ($w) use ($cleanRanges) {
                    foreach ($cleanRanges as [$a, $b]) {
                        $w->orWhereBetween('discounted_price', [$a, $b]);
                    }
                });
            });
        }
    }

    $products = $query->get();

    if ($products->isEmpty()) {
        return response()->json([
            'status' => false,
            'status_code' => 404,
            'message' => 'Products not found',
        ], 404);
    }

    return response()->json([
        'status' => true,
        'status_code' => 200,
        'products' => $products,
    ]);
}



//     public function filterProducts(Request $req)
// {
//     $query = Product::query()->with(['variants' => function ($q) {
//         $q->select('id', 'product_id', 'color', 'size', 'price', 'discounted_price');
//     }]);

//     // Category / Subcategory
//     if ($req->filled('category_id')) {
//         $query->where('category_id', (int) $req->input('category_id'));
//     }
//     if ($req->filled('sub_category_id')) {
//         $query->where('sub_category_id', (int) $req->input('sub_category_id'));
//     }

//     // COLORS (case-insensitive, partial match, supports array or single)
//     if ($req->has('color')) {
//         $colors = $req->input('color');
//         $colors = is_array($colors) ? $colors : [$colors];
//         $colors = array_values(array_filter(array_map(fn($c) => mb_strtolower(trim($c)), $colors)));

//         if (!empty($colors)) {
//             $query->whereHas('variants', function ($vq) use ($colors) {
//                 $vq->where(function ($w) use ($colors) {
//                     foreach ($colors as $c) {
//                         // partial match, case-insensitive
//                         $w->orWhereRaw('LOWER(color) LIKE ?', ["%{$c}%"]);
//                     }
//                 });
//             });
//         }
//     }

//     // SIZES (case-insensitive, supports array or single; use exact or partial as you prefer)
//     if ($req->has('size')) {
//         $sizes = $req->input('size');
//         $sizes = is_array($sizes) ? $sizes : [$sizes];
//         $sizes = array_values(array_filter(array_map(fn($s) => mb_strtolower(trim($s)), $sizes)));

//         if (!empty($sizes)) {
//             $query->whereHas('variants', function ($vq) use ($sizes) {
//                 $vq->where(function ($w) use ($sizes) {
//                     foreach ($sizes as $s) {
//                         // exact-ish: LOWER(size) = value; switch to LIKE for partials
//                         $w->orWhereRaw('LOWER(size) = ?', [$s]);
//                         // or partial: $w->orWhereRaw('LOWER(size) LIKE ?', ["%{$s}%"]);
//                     }
//                 });
//             });
//         }
//     }

//     // PRICE (prefer min_price/max_price; else price_range[]= "min-max")
//     $min = $req->input('min_price');
//     $max = $req->input('max_price');

//     if ($min !== null || $max !== null) {
//         $min = $min !== null ? (int) $min : 0;
//         $max = $max !== null ? (int) $max : PHP_INT_MAX;

//         $query->whereHas('variants', function ($vq) use ($min, $max) {
//             $vq->whereBetween(DB::raw('COALESCE(discounted_price, price)'), [$min, $max]);
//         });
//     } elseif ($req->has('price_range')) {
//         $ranges = (array) $req->input('price_range');
//         $cleanRanges = [];

//         foreach ($ranges as $range) {
//             if (is_string($range) && str_contains($range, '-')) {
//                 [$rmin, $rmax] = array_map('trim', explode('-', $range, 2));
//                 $rmin = (int) $rmin;
//                 $rmax = (int) $rmax;
//                 if ($rmax >= $rmin) {
//                     $cleanRanges[] = [$rmin, $rmax];
//                 }
//             }
//         }

//         if (!empty($cleanRanges)) {
//             $query->whereHas('variants', function ($vq) use ($cleanRanges) {
//                 $vq->where(function ($w) use ($cleanRanges) {
//                     foreach ($cleanRanges as [$a, $b]) {
//                         $w->orWhereBetween(DB::raw('COALESCE(discounted_price, price)'), [$a, $b]);
//                     }
//                 });
//             });
//         }
//     }

//     $products = $query->get();

//     if ($products->isEmpty()) {
//         return response()->json([
//             'status' => false,
//             'status_code' => 404,
//             'message' => 'Products not found',
//         ], 404);
//     }

//     return response()->json([
//         'status' => true,
//         'status_code' => 200,
//         'products' => $products,
//     ]);
// }

}
