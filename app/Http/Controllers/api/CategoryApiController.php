<?php

namespace App\Http\Controllers\api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\AwardCategory;
use App\Http\Controllers\Controller;

class CategoryApiController extends Controller
{
    public function allcat(){
        $allcat = AwardCategory::all();
        
        if($allcat){
             return response()->json([
                'status'=>true,
                'status_code'=>200,
                'message'=>'all categories fetched successfully !',
                'total'=>count($allcat),
                'categories'=>$allcat,
            ],200);
        }else{
               return response()->json([
                'status'=>false,
                'status_code'=>400,
                'message'=>' Failed to fetch all categories !',
            ],400);
        }
    }

    public function storeCategory(Request $request){
         $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if(!$validated){
              return response()->json([
                'status'=>false,
                'status_code'=>400,
            'message' => 'validation fail !',
        ],400);
    }
        $category = AwardCategory::create($validated);

        if($category)  {

            return response()->json([
                'status'=>true,
                'status_code'=>200,
                'message' => 'Category created successfully',
                'category' => $category,
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'status_code'=>400,
                'message' => 'failed to create Category ',
            ],400);
        }   
    }

    public function showCategory($id){
         $category = AwardCategory::find($id);

          if($category)  {

            return response()->json([
                'status'=>true,
                'status_code'=>200,
                'message' => 'Category fetched successfully',
                'category' => $category,
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'status_code'=>400,
                'message' => 'failed to fetch Category ',
            ],400);
        }   
    }

    public function updateCategory($id,Request $request){

    $category = AwardCategory::find($id);

    $category->name = $request->name ?? null;
    $category->description = $request->description ?? null;
      // Replace main image (optional)
    if ($request->hasFile('image')) {
        if ($category->image && file_exists(public_path('category_images/' . $category->image))) {
            unlink(public_path('category_images/' . $category->image));
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('category_images'), $imageName);
        $category->image = $imageName;
    }

    if($category->save())
    {
          return response()->json([
                'status'=>true,
                'status_code'=>200,
                'message' => 'Category updated successfully',
                'category' => $category,
            ],200);
    }else{
        return response()->json([
                'status'=>false,
                'status_code'=>400,
                'message' => 'Category update Fail !',
            ],400);
    }
    }

    public function destroyCategory($id){
         $cat = AwardCategory::findorfail($id);

         if($cat->image){

            $imagePath = public_path('category_images/'.$cat->image);
            if(File::exists($imagePath)){
                unlink($imagePath);
            } 
         }
         if($cat->delete()){
             return response()->json([
                'status'=>true,
                'status_code'=>200,
                'message' => 'Category deleted successfully',
                'category' => $category,
            ],200);
            }
            else{
                 return redirect()->route('category')->with('error', 'Category delete fail!');
            }
    }
}
