<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return view('admin.TeamCrud.TeamTable',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.TeamCrud.CreateTeam');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|required',
            'role' => 'required',
            'image' => 'nullable',
        ]);
    if($validated){
        $team = new Team();
        $team->name = $request->name;
        $team->description = $request->description;
        $team->role = $request->role;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move('team_images/',$imageName);
            $team->image = $imageName;
        }

    // Create new award category
   
    if($team->save())
    {
   
        return redirect()->route('teams')->with('success', 'team added successfully!');
    }else{
        return redirect()->route('teams')->with('error', 'team add fail!');
 
    }
}
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $team = Team::findorfail($id);
        
        return view('admin.TeamCrud.ViewTeam',compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $team = Team::findorfail($id);

        return view('admin.TeamCrud.EditTeam',compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $team = Team::findorfail($id);

         $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable|required',
            'role' => 'required',
            'image' => 'nullable',
        ]);
    if($validated){
        $team->name = $request->name;
        $team->description = $request->description;
        $team->role = $request->role;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            
            $oldimg = public_path('team_images/'.$team->image);
            if(is_file($oldimg)){
                unlink($oldimg);
            }
            $request->image->move('team_images/',$imageName);
            $team->image = $imageName;
        }

    // Create new award category
   
    if($team->save())
    {
   
        return redirect()->route('teams')->with('success', 'team updated successfully!');
    }else{
        return redirect()->route('teams')->with('error', 'team update fail!');
 
    }
}
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $team = Team::findorfail($id);

        $currentimg = public_path('team_images/'.$team->image);

        if(is_file($currentimg)){
            unlink($currentimg);
        }

        if($team->delete()){
            return redirect()->route('teams')->with('success', 'team deleted successfully!');
        }
        else{
            return redirect()->route('teams')->with('error', 'team delete fail!');
        }
        
    }
}
