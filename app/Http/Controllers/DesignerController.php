<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DesignerController extends Controller
{
    // Show all designers
    public function index()
    {
        $designers = User::where('role',2)->get();
       
        return view('admin.DesignerCrud.index', compact('designers'));
    }

    // Show form to add a designer
    public function create()
    {
        return view('admin.DesignerCrud.create');
    }

    // Store new designer
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|email|unique:users',
            'mobile_no'   => 'required',
            'password'    => 'required|min:6',
            'birthday'    => 'required|date',
            'designation' => 'nullable|string|max:255',
            'image'       => 'nullable'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->file('image')->extension();
            $request->file('image')->move('designer_images', $imageName);
        }

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile'   => $request->mobile_no,
            'password'    => Hash::make($request->password),
            'birthday'    => $request->birthday,
            'designation' => $request->designation,
            'role' => 2,
            'profile_img'       => $imageName,
        ]);

        return redirect()->route('Designerinfo')->with('success', 'Designer added successfully.');
    }

    // View designer details
    public function show($id)
    {
        $designer = User::findOrFail($id);
        return view('admin.DesignerCrud.show', compact('designer'));
    }

    // Show form to edit designer
    public function edit($id)
    {
        $designer = User::findOrFail($id);
        return view('admin.DesignerCrud.edit', compact('designer'));
    }

    // Update designer
    public function update(Request $request, $id)
    {
        $designer = User::findOrFail($id);

       
        // $imageName = $designer->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldPath = base_path('designer_images/' . $designer->profile_img);
            if (is_file($oldPath)) {
      
               unlink($oldPath);
            }

            $imageName = time().'.'.$request->file('image')->extension();
            $request->file('image')->move('designer_images', $imageName);
        }

        $designer->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile'   => $request->mobile_no,
            'birthday'    => $request->birthday,
            'designation' => $request->designation,
            'profile_img'       => $imageName,
        ]);

        return redirect()->route('Designerinfo')->with('success', 'Designer updated successfully.');
    }

    // Delete designer
    public function destroy($id)
    {
        $designer = User::findOrFail($id);

        // Delete image file
        $filepath = base_path('designer_images/'.$designer->profile_img);
        if (is_file($filepath)) {
            unlink($filepath);
        }

        $designer->delete();

        return redirect()->route('Designerinfo')->with('success', 'Designer deleted successfully.');
    }
}
