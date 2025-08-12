<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Occasion;
use App\Models\SubCategory;
use App\Models\productImage;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Models\ProductVariant;
use App\Models\OccasionProduct;
use App\Imports\occProductImport;
use Maatwebsite\Excel\Facades\Excel;

class OccasionProductController extends Controller
{
    public function import(Request $request)
    {

        $validated =  $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(
            new occProductImport($request->occasion_id, $request->product_cat_id, $request->subcategory_id),
            $request->file('excel_file')
        );

        return back()->with('success', 'Occasional Products imported successfully!');
    }

    public function products()
    {
        $allproducts = OccasionProduct::all();

        $occasion = Occasion::all();
        $category = AwardCategory::all();
        return view('admin.OccProduct.products', compact('allproducts', 'occasion', 'category'));
    }
    public function addproducts()
    {
        $category = AwardCategory::all();
        $occasion = Occasion::select('id', 'title')->get();
        return view('admin.OccProduct.createProduct', compact('occasion', 'category'));
    }
    public function storeproduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'product_cat_id' => 'required',
            'subcategory_id' => 'required',
            'occasion_id' => 'required|exists:occasions,id',
            'rating' => 'nullable|numeric|min:0|max:5',
            'variants.*.size' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|string|max:50',
            'variants.*.discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $occProduct = new OccasionProduct();
        $occProduct->title = $request->title;
        $occProduct->description = $request->description;
        $occProduct->category_id = $request->product_cat_id;
        $occProduct->sub_category_id = $request->subcategory_id;
        $occProduct->occasion_id = $request->occasion_id;
        $occProduct->rating = $request->rating ? $request->rating : 0;

        // Image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('OccasionalProduct_images/', $imageName);
            $occProduct->image = $imageName;
        }


        $occProduct->save();

            $colors = $request->colors ?? []; // array of global colors
            // $variant = new ProductVariant();
            foreach ($request->variants as $variant) {
                // Save product variants

                $price = $variant['price'];
                $discount = $variant['discount_percentage'] ?? 0;

                $discounted = $price - ($price * $discount / 100);

                $created =  $occProduct->variants()->create([
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
                    $prod_image->occasion_product_id = $occProduct->id;
                    $prod_image->image = $imageName;
                    // dd($prod_image->image);
                    $prod_image->save();
                    
                }
            }
            return redirect()->route('occproducts')->with('success', 'Product created successfully!');
        
    }

    public function editproduct($id, Request $request)
    {
        $product = OccasionProduct::with('variants')->find($id);
        $category = AwardCategory::all();
        $occasion = Occasion::all();
        $subcategories = SubCategory::all(); // or filter by category if needed
        return view('admin.OccProduct.editProduct', compact('occasion', 'product', 'category', 'subcategories'));
    }

    public function updateproduct($id, Request $request)
    {


        $product = OccasionProduct::findOrFail($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->product_cat_id;
        $product->sub_category_id = $request->subcategory_id;
        $product->occasion_id = $request->occasion_id;
        $product->rating = $request->rating;

        // Remove old variants
        $product->variants()->delete();
        $colors = $request->colors ?? []; // array of global colors
        foreach ($request->variants as $variant) {
            $price = $variant['price'];
            $discount = $variant['discount_percentage'] ?? 0;
            $discounted = $price - ($price * $discount / 100);

            $product->variants()->create([
                'size' => $variant['size'],
                'color' => json_encode($colors), // global colors
                'price' => $price,
                'discount_percentage' => $discount,
                'discounted_price' => $discounted,
            ]);
        }

        // Handle image upload if new one is provided
        if ($request->hasFile('image')) {
            // Optionally: delete old image
            $filepath = public_path('OccasionalProduct_images/' . $product->image);
            if ($product->image && is_file($filepath)) {
                unlink($filepath);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move('OccasionalProduct_images', $imageName);
            $product->image = $imageName;
        }


        //multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                
                $imageName = time() . rand(1, 1000) . '.' . $image->extension();
                $image->move('OccasionalProduct_images', $imageName);

                productImage::create([
                    'occasion_product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
        }

        $product->save();

        return redirect()->route('occproducts')->with('success', 'Occasional product updated successfully.');
    }

    public function showproduct($id)
    {
        $product = OccasionProduct::with(['variants', 'images', 'category', 'subcategory', 'occasion'])->findOrFail($id);

        return view('admin.OccProduct.viewProduct', compact('product'));
    }


    public function destroyproduct($id)
    {
        $product = OccasionProduct::find($id);
        $productimages = productImage::where('occasion_product_id', $id)->get();
        //   dd($productimages);

        // Delete image from folder if it exists
        $filePath = public_path('OccasionalProduct_images/' . $product->image);
        // dd($filePath);
        if (is_file($filePath)) {
            unlink($filePath);
        }

        // Delete multiple images from folder if it exists
        foreach ($productimages as $image) {
             $filePath = public_path('OccasionalProduct_images/' . $image->image);
            if ($image->image && is_file($filePath)) {
                unlink($filePath);
            }
        }




        // Delete the product
        if ($product->delete()) {
            return redirect()->route('occproducts')->with('success', 'Occasional product deleted successfully.');
        } else {
            return redirect()->route('occproducts')->with('error', 'Occasional product deleted Fail.');
        }
    }
    
     public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);


        // Delete from folder
        $filePath = public_path('OccasionalProduct_images/' . $image->image);
        // dd($filePath);
        if (is_file($filePath)) {
            unlink($filePath);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    // public function deleteImage($id)
    // {
    //     $image = ProductImage::findOrFail($id);

        
    //     // Delete from folder
    //               $filePath = public_path('OccasionalProduct_images/' . $image->image);
    //                 // dd($filePath);
    //     if (is_file($filePath)) {
    //         unlink($filePath);
    //     }

    //     $image->delete();

    //     return back()->with('success', 'Image deleted successfully.');
    // }
}
