<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\AwardCategory;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = AwardCategory::all();
        return view('admin.CategoryCrud.categoryTable',compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.CategoryCrud.CreateCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category,name',
            'description' => 'nullable|string',
            'image' => 'nullable',
        ]);
    if($validated){
        $awardCategory = new AwardCategory();
        $awardCategory->name = $request->name;
        $awardCategory->description = $request->description;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('category_images/',$imageName);
            $awardCategory->image = $imageName;
        }

    // Create new award category
   
    $awardCategory->save();
    
   
        return redirect()->route('category')->with('success', 'Category created successfully!');
   
}else{
    return redirect()->route('category')->with('error', ' enter correct and unique values!');
}

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $cat = AwardCategory::findorfail($id);
       return view('admin.CategoryCrud.ViewCategory',compact('cat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cat = AwardCategory::findorfail($id);
        return view('admin.CategoryCrud.EditCategory',compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cat = AwardCategory::findorfail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable',
        ]);
        if($validated){
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            // dd($imageName);
            $oldimg = public_path('category_images/'.$cat->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            $request->image->move('category_images/',$imageName);
            $cat->image = $imageName;
        }
        $cat->name = $request->name;
        $cat->description = $request->description;
        
        
        if($cat->save())
    {
   
        return redirect()->route('category')->with('success', 'Category update successfully!');
    }else{
        return redirect()->route('category')->with('error', 'Category update fail!');

    }
    }else{
    return redirect()->route('category')->with('error', ' enter correct and unique values!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $cat = AwardCategory::findorfail($id);

         if($cat->image){

            $imagePath = public_path('category_images/'.$cat->image);
            if(is_file($imagePath)){
                unlink($imagePath);
            } 
            
         }
         if($cat->delete()){
                  return redirect()->route('category')->with('success', 'Category deleted successfully!');
            }
            else{
                 return redirect()->route('category')->with('error', 'Category delete fail!');
            }
         
    }
}
