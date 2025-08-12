<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::all();
        return view('admin.AboutCrud.AboutTable',compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.AboutCrud.CreateAbout');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'longdescription' => 'required|string',
            'image' => 'nullable',
        ]);
    if($validated){
        $about = new About();
        $about->title = $request->title;
        $about->description = $request->description;
        $about->long_description = $request->longdescription;
        // Handle image upload
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('about_images/',$imageName);
            $about->image = $imageName;
        }

    // Create new award category
   
    if($about->save())
    {
   
        return redirect()->route('about')->with('success', 'about added successfully!');
    }else{
        return redirect()->route('about')->with('error', 'about add fail!');
 
    }
}

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $about = About::findorfail($id);

        return view('admin.AboutCrud.ViewAbout',compact('about'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $about = About::findorfail($id);

        return view('admin.AboutCrud.EditAbout',compact('about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $about = About::findorfail($id);

         $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'longdescription' => 'required|string',
            'image' => 'nullable',
        ]);
    if($validated){
        $about->title = $request->title;
        $about->description = $request->description;
        $about->long_description = $request->longdescription;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $oldimg = public_path('about_images/'.$about->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            $request->image->move('about_images/',$imageName);
            $about->image = $imageName;
        }

    // Create new award category
   
    if($about->save())
    {
   
        return redirect()->route('about')->with('success', 'about updated successfully!');
    }else{
        return redirect()->route('about')->with('error', 'about update fail!');
 
    }
}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $about = About::findorfail($id);

        if($about->image){
            $imagePath = public_path('about_images/'.$about->image);

            if(is_file($imagePath)){
                unlink($imagePath);
            }

        }
        if($about->delete()){
            return redirect()->route('about')->with('success', 'about deleted successfully!');
        }
        else{
            return redirect()->route('about')->with('success', 'about delete faile!');
        }

    }
}