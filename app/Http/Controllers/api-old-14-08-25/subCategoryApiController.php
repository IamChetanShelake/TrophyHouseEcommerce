<?php

namespace App\Http\Controllers\api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class subCategoryApiController extends Controller
{
    // Get all subcategories
    public function index()
    {
        $subcategories = SubCategory::with('category')->get();
        return response()->json([
            'status' => true,
            'status_code'=>200,
            'subcategories' => $subcategories
        ],200);
    }

    // Create new subcategory
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|max:5048',
            'category_id' => 'required|exists:category,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $subcategory = new SubCategory();
            $subcategory->title = $request->title;
            $subcategory->description = $request->description;
            $subcategory->category_id = $request->category_id;

        // Upload primary image
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move('sub-category_images', $imageName);
        $subcategory->image = $imageName;
    }

    if($subcategory->save()){

        
        return response()->json([
            'status' => true,
            'status_code'=>200,
            'message' => 'Subcategory created successfully',
            'subcategory' => $subcategory,
        ],200);
    }else{
         return response()->json([
            'status' => false,
            'status_code'=>400,
            'message' => 'Subcategory save fail',
        ],400);
    }
    }

    // View a specific subcategory
    public function show($id)
    {
        $subcategory = SubCategory::with('category')->find($id);
        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

        return response()->json([
            'status' => true,
            'status_code'=>200,
            'subcategory' => $subcategory,
        ],200);
    }
    

    // Update a subcategory
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::find($id);
        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }

       

        $subcategory->title = $request->title;
        $subcategory->description = $request->description;
        $subcategory->category_id = $request->category_id;

          // Replace main image (optional)
    if ($request->hasFile('image')) {
        if ($subcategory->image && file_exists(public_path('sub-category_images/' . $subcategory->image))) {
            unlink(public_path('sub-category_images/' . $subcategory->image));
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move('sub-category_images', $imageName);
        $subcategory->image = $imageName;
    }


         if($subcategory->save()){

        
        return response()->json([
            'status' => true,
            'status_code'=>200,
            'message' => 'Subcategory updated successfully',
            'subcategory' => $subcategory,
        ],200);
    }else{
         return response()->json([
            'status' => false,
            'status_code'=>400,
            'message' => 'Subcategory update fail',
        ],400);
    }
    }

    // Delete a subcategory
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        if (!$subcategory) {
            return response()->json(['message' => 'Subcategory not found'], 404);
        }
        // Delete main image
    $ImagePath = public_path('sub-category_images/' . $subcategory->image);
    if (file_exists($ImagePath)) {
        unlink($ImagePath);
    }

        if($subcategory->delete()){

            
            return response()->json([
                'status' => true,
                'status_code'=>200,
                'message' => 'Subcategory deleted successfully',
            ],200);

        }else{
            return response()->json([
                'status' => false,
                'status_code'=>400,
                'message' => 'Subcategory delete fail',
            ],400);
        }
    }
    
    public function getsubcategories(Request $req){
        //  $subcategories = SubCategory::where('category_id',$req->category_id)->get
         
          // Optional: validate the request
    $req->validate([
        'category_id' => 'required|exists:category,id',
    ]);

    $subcategories = SubCategory::where('category_id', $req->category_id)->get();

    return response()->json([
        'status' => true,
        'status_code'=>200,
        'message' => 'Subcategories fetched successfully',
        'subcategories' => $subcategories
    ],200);
        //  return $subcategories;
         
    }
}
