<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = Gallery::all();
        return view('admin.OurGalleryCrud.galleryList',compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.OurGalleryCrud.createGallery');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable',
        ]);

        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('gallery_images/',$imageName);
            $gallery->image = $imageName;

        }

    // Create new award category
   
    if($gallery->save())
    {
   
        return redirect()->route('Admingallery')->with('success', 'gallery added successfully!');
    }else{
        return redirect()->route('Admingallery')->with('error', 'gallery add fail!');
 
    }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $gallery = Gallery::Find($id);

        return view('admin.OurGalleryCrud.viewGallery',compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Gallery::Find($id);

        return view('admin.OurGalleryCrud.editGallery',compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
         $gallery = Gallery::Find($id);

       
        $gallery->title = $request->title;
        $gallery->description = $request->description;


         // Handle image upload
        if ($request->hasFile('image')) {

             $oldimg = public_path('gallery_images/'.$gallery->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            // $image = $request->file('image');
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('gallery_images/',$imageName);
            $gallery->image = $imageName;
        }
         if($gallery->save())
    {
   
        return redirect()->route('Admingallery')->with('success', 'gallery added successfully!');
    }else{
        return redirect()->route('Admingallery')->with('error', 'gallery add fail!');
 
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
            $gallery = Gallery::Find($id);

            $oldimg = public_path('gallery_images/'.$gallery->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
               if($gallery->delete())
    {
   
        return redirect()->route('Admingallery')->with('success', 'gallery added successfully!');
    }else{
        return redirect()->route('Admingallery')->with('error', 'gallery add fail!');
 
    }


    }
}
