<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\AwardCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $subcat = SubCategory::all();
        return view('admin.subCategoryCrud.index',compact('subcat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = AwardCategory::all();

        return view('admin.subCategoryCrud.createSub',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcat_name' => 'required|string|max:255|unique:sub_categories,title',
            'subcat_desc' => 'nullable|string',
            'category_id'=>'required',
            'subcat_image' => 'nullable',
        ]);
        if($validated){
            $subCategory = new SubCategory();
            $subCategory->title = $request->subcat_name;
            $subCategory->description = $request->subcat_desc;
            $subCategory->category_id = $request->category_id;
            
            // Handle image upload
            if ($request->hasFile('subcat_image')) {
                // $image = $request->file('image');
                $imageName = time().'.'.$request->subcat_image->extension();
                $request->subcat_image->move('sub-category_images/',$imageName);
                $subCategory->image = $imageName;
            }

    // Create new award category
   
    if($subCategory->save())
    {
   
        return redirect()->route('subCategory')->with('success', 'sub-Category created successfully!');
    }else{
        return redirect()->route('subCategory')->with('error', 'sub-Category created fail!');

    }
}else{
    return redirect()->route('subCategory')->with('error', ' enter correct and unique values!');
}

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $subcat = SubCategory::with('category')->findorfail($id);
        //  return $subcat;
         return view('admin.subCategoryCrud.viewSubCat',compact('subcat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subcat = SubCategory::with('category')->findorfail($id);
         $categories = AwardCategory::all();


        return view('admin.subCategoryCrud.editSub',compact('subcat','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $subCategory = SubCategory::with('category')->findorfail($id);

         
           
            // dd('came');
            $subCategory->title = $request->subcat_name;
            $subCategory->description = $request->subcat_desc;
            if($request->category_id){
                $subCategory->category_id = $request->category_id;
            }
            
            $oldimg = public_path('sub-category_images/'.$subCategory->image);
            // Handle image upload
            if ($request->hasFile('subcat_image')) {
                if(is_file($oldimg)){
                unlink($oldimg);
            }
                // $image = $request->file('image');
                $imageName = time().'.'.$request->subcat_image->extension();
                $request->subcat_image->move('sub-category_images/',$imageName);
                $subCategory->image = $imageName;
            }
            // dd($oldimg);

    // Create new award category
   
    if($subCategory->save())
    {
   
        return redirect()->route('subCategory')->with('success', 'sub-Category update successfully!');
    }else{
        return redirect()->route('subCategory')->with('error', 'sub-Category update fail!');

    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subCat= SubCategory::with('category')->findorfail($id);

        $filePath = public_path('sub-category_images/'.$subCat->image);
        // dd($filePath);
        if(is_file($filePath)){
            unlink($filePath);
        }

        if($subCat->delete()){
             return redirect()->route('subCategory')->with('success', 'sub-Category deleted successfully!');
        }
        else{
             return redirect()->route('subCategory')->with('error', 'sub-Category delete fail!');
        }
    }
}
