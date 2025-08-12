<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::all();

        return view('admin.TestimonialCrud.Testimonial_table',compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.TestimonialCrud.Create_testimonial');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'author' => 'required',
            'testimonial' => 'required',
            'role' => 'nullable|required',
            'author_image' => 'nullable',
        ]);
    if($validated){
        $test = new Testimonial();
        $test->author = $request->author;
        $test->role = $request->role;
        $test->testimonial = $request->testimonial;
        
        // Handle image upload
        if ($request->hasFile('author_image')) {
            $imageName = time().'.'.$request->author_image->extension();
            $request->author_image->move('testimonial_images/',$imageName);
            $test->image = $imageName;
        }

    // Create new award category
   
    if($test->save())
    {
   
        return redirect()->route('tests')->with('success', 'testimonial added successfully!');
    }else{
        return redirect()->route('tests')->with('error', 'testimonial add fail!');
 
    }
}
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $test = Testimonial::findorfail($id);
        return view('admin.TestimonialCrud.View_testimonial',compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $test = Testimonial::findorfail($id);

        return view('admin.TestimonialCrud.Edit_testimonial',compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $test = Testimonial::findorfail($id);

        $validated = $request->validate([
            'author' => 'required',
            'testimonial' => 'required',
            'role' => 'nullable|required',
            'author_image' => 'nullable',
        ]);
    if($validated){
        $test->author = $request->author;
        $test->role = $request->role;
        $test->testimonial = $request->testimonial;
        
        // Handle image upload
        if ($request->hasFile('author_image')) {
            $imageName = time().'.'.$request->author_image->extension();
            $oldimg = public_path('testimonial_images/'.$test->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            $request->author_image->move('testimonial_images/',$imageName);
            $test->image = $imageName;
        }

    // Create new award category
   
    if($test->save())
    {
   
        return redirect()->route('tests')->with('success', 'testimonial added successfully!');
    }else{
        return redirect()->route('tests')->with('error', 'testimonial add fail!');
 
    } 
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $test = Testimonial::findorfail($id);

        $oldimg = public_path('testimonial_images/'.$test->image);
        if(is_file($oldimg)){
            unlink($oldimg);
        }

        if($test->delete()){
            return redirect()->route('tests')->with('success', 'testimonial deleted successfully!');
        }else{
            return redirect()->route('tests')->with('error', 'testimonial delete fail !');
        }
    }
}
