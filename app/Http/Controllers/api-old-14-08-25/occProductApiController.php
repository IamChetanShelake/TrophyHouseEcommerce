<?php

namespace App\Http\Controllers\api;

use App\Models\productImage;
use Illuminate\Http\Request;
use App\Models\OccasionProduct;
use App\Http\Controllers\Controller;

class occProductApiController extends Controller
{
    public function allproducts()
    {
        $allproducts = OccasionProduct::with('occasion')->get();
        if ($allproducts) {

            return response()->json([
                'status' => true,
                'message' => 'all Occasional products fetched successfully !',
                'products' => $allproducts,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Failed to fetch all Occasional products !',
            ], 400);
        }
    }


    public function showOccproduct($id)
    {
        // Fetch the product with its variants and images
        $occproduct = OccasionProduct::with(['variants', 'images'])->find($id);

        if (!$occproduct) {
            return response()->json([
                'status' => false,
                'message' => 'Occasional product not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Occasional product retrieved successfully.',
            'product' => $occproduct,
        ]);
    }

    public function storeproduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'product_cat_id' => 'required',
            'subcategory_id' => 'required',
            'rating' => 'required|numeric|min:0|max:5',
            'variants.*.size' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $occproduct = new OccasionProduct();
        $occproduct->title = $request->title;
        $occproduct->description = $request->description;
        $occproduct->category_id = $request->product_cat_id;
        $occproduct->sub_category_id = $request->subcategory_id;
        $occproduct->rating = $request->rating;

        // Image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('OccasionalProduct_images/', $imageName);
            $occproduct->image = $imageName;
        }

        if ($occproduct->save()) {
            $colors = $request->colors ?? []; // array of global colors
            // $variant = new ProductVariant();
            foreach ($request->variants as $variant) {
                // Save product variants

                $price = $variant['price'];
                $discount = $variant['discount_percentage'] ?? 0;
                $discounted = $price - ($price * $discount / 100);

                $created =  $occproduct->variants()->create([
                    'size' => $variant['size'],
                    'color' => json_encode($colors), // assign global colors
                    'price' => $price,
                    'discount_percentage' => $discount,
                    'discounted_price' => $discounted,
                ]);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique image name to avoid overwriting
                    $imageName = time() . rand(1, 1000) . '.' . $image->extension();

                    // Move the file to the public directory
                    $image->move('OccasionalProduct_images', $imageName);

                    // Save image record in DB
                    $prod_image = new productImage();
                    $prod_image->occasion_product_id = $occproduct->id;
                    $prod_image->images = $imageName;
                    $prod_image->save();
                }
            }
            return response()->json([
                'status' => true,
                'message' => ' Occasional product saved successfully !',
                'occasionalProduct' => $occproduct,
                'variants' => $occproduct->variants(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Occasional products save Fail !',
            ], 400);
        }
    }

    public function updateproduct($id, Request $request)
    {

        $occproduct = OccasionProduct::with('images', 'variants')->find($id);
        $occproduct->title = $request->title;
        $occproduct->description = $request->description;
        $occproduct->category_id = $request->product_cat_id;
        $occproduct->sub_category_id = $request->subcategory_id;
        $occproduct->rating = $request->rating;


        if ($request->hasFile('image')) {
            $imgPath = public_path('OccasionalProduct_images/' . $occproduct->image);
            if (is_file($imgPath)) {
                // Image upload
                unlink($imgPath);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('OccasionalProduct_images/', $imageName);
            $occproduct->image = $imageName;
        }


        // Delete old extra images from folder + DB
        // return response()->json([
        //     'image'=>$occproduct->images,
        // ]);
        if ($request->hasFile('images')) {

            foreach ($occproduct->images as $img) {
                $imgPath = public_path('OccasionalProduct_images/' . $img->images);
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
            }
        }

        if ($occproduct->save()) {
            if ($request->variants) {


                $colors = $request->colors ?? []; // array of global colors
                // $variant = new ProductVariant();
                foreach ($request->variants as $variant) {
                    // Save product variants

                    $price = $variant['price'];
                    $discount = $variant['discount_percentage'] ?? 0;
                    $discounted = $price - ($price * $discount / 100);

                    $created =  $occproduct->variants()->create([
                        'size' => $variant['size'],
                        'color' => json_encode($colors), // assign global colors
                        'price' => $price,
                        'discount_percentage' => $discount,
                        'discounted_price' => $discounted,
                    ]);
                }
            } else {
                $occproduct->variants()->delete();
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Generate a unique image name to avoid overwriting
                    $imageName = time() . rand(1, 1000) . '.' . $image->extension();

                    // Move the file to the public directory
                    $image->move('OccasionalProduct_images', $imageName);

                    // Save image record in DB
                    $occproduct->images()->create([
                        'images' => $imageName,
                    ]);
                    // $prod_image = new productImage();
                    // $prod_image->occasion_product_id = $occproduct->id;
                    // $prod_image->images = $imageName;
                    // $prod_image->save();

                }
            }
            return response()->json([
                'status' => true,
                'message' => ' Occasional product updated successfully !',
                'occasionalProduct' => $occproduct,
                'variants' => $occproduct->variants(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => ' Occasional products save Fail !',
            ], 400);
        }
    }

    public function deleteProduct($id)
    {
        $occproduct = OccasionProduct::find($id);

        if (!$occproduct) {
            return response()->json([
                'success' => false,
                'message' => 'occasinal Product not found.',
            ], 404);
        }

        // Delete related images
        foreach ($occproduct->images as $image) {
            $imagePath = public_path('OccasionalProduct_images/' . $image->images);
            if (file_exists($imagePath)) {
                unlink($imagePath); // delete file from storage
            }
            $image->delete(); // delete from DB
        }

        // Delete related variants
        foreach ($occproduct->variants as $variant) {
            $variant->delete();
        }

        // Delete main image
        $mainImagePath = public_path('OccasionalProduct_images/' . $occproduct->image);
        if (file_exists($mainImagePath)) {
            unlink($mainImagePath);
        }

        // Finally delete the product
        if ($occproduct->delete()) {


            return response()->json([
                'success' => true,
                'message' => 'occasional Product deleted successfully.',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'occasional Product delete fail.',
            ], 400);
        }
    }
}
