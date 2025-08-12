<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('admin.clientCrud.clientListTable',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clientCrud.createClient');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            
            'image' => 'nullable',
        ]);
 
        $client = new Client();
        $client->name = $request->title;
        $client->description = $request->description;
        // Handle image upload
        if ($request->hasFile('image')) {
            // $image = $request->file('image');
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('client_images/',$imageName);
            $client->image = $imageName;
        }

    // Create new award category
   
    if($client->save())
    {
   
        return redirect()->route('clients')->with('success', 'client added successfully!');
    }else{
        return redirect()->route('clients')->with('error', 'client add fail!');
 
    }
    
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::find($id);

        return view('admin.clientCrud.viewClient',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = Client::find($id);

        return view('admin.clientCrud.editClient',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        // dd('came');
       
 
        $client = Client::find($id);
        $client->name = $request->title;
        $client->description = $request->description;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $oldimg = public_path('client_images/'.$client->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            $request->image->move('client_images/',$imageName);
            $client->image = $imageName;
        }

    // Create new award category
   
    if($client->save())
    {
   
        return redirect()->route('clients')->with('success', 'client added successfully!');
    }else{
        return redirect()->route('clients')->with('error', 'client add fail!');
 
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        $oldimg = public_path('client_images/'.$client->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
        
            if($client->delete()){
   
        return redirect()->route('clients')->with('success', 'client added successfully!');
    }else{
        return redirect()->route('clients')->with('error', 'client add fail!');
 
    }

    }
}
