<?php

namespace App\Http\Controllers;

use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occasions = Occasion::all();
        return view('admin.OccasionCrud.occasionList',compact('occasions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.OccasionCrud.createOccasion');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          //  Validate the request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable',
    ]);

    //  Handle the image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.'. $image->extension();
        $image->move('occasion_images', $imageName);
    }

    //  Create the occasion
    Occasion::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'image' => $imageName ?? null,
    ]);

    //  Redirect back with success
    return redirect()->route('occasion')->with('success', 'Occasion added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $oc = Occasion::find($id);

        return view('admin.OccasionCrud.viewOccasion',compact('oc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $occasion = Occasion::find($id);

        return view('admin.OccasionCrud.editOccasion',compact('occasion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
          $occasion = Occasion::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable',
    ]);

    $occasion->title = $validated['title'];
    $occasion->description = $validated['description'];

    if ($request->hasFile('image')) {
        // Delete old image
        $oldimg = public_path('occasion_images/' . $occasion->image);
        if ($occasion->image && is_file($oldimg)) {
            unlink($oldimg);
        }

        // Save new image
        $image = $request->file('image');
         $imageName = time() . '.'. $image->extension();
        $image->move('occasion_images', $imageName);
        $occasion->image = $imageName;
    }

    $occasion->save();

    return redirect()->route('occasion')->with('success', 'Occasion updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
            //  Find the occasion
    $occasion = Occasion::findOrFail($id);

    //  Delete the image file if it exists
    if ($occasion->image) {
      
       $oldimg = public_path('occasion_images/' . $occasion->image);
        if ($occasion->image && is_file($oldimg)) {
            unlink($oldimg);
        }
    }

    //  Delete the occasion record
    $occasion->delete();

    // Redirect back with success message
    return redirect()->route('occasion')->with('success', 'Occasion deleted successfully!');
    }
   
}
