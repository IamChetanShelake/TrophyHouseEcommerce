<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = Page::all();
        return view('admin.PagesCrud.PagesTable',compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('admin.PagesCrud.CreatePages');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'=>'required',
            'description'=>'required',
        ]);
        if($validated){
            $page = new Page();
            $page->title = $request->title;
            $page->description = $request->description;

            if($page->save()){
                return redirect()->route('pages')->with('success','page Added Successfully !');
            }else{
                return redirect()->route('pages')->with('error','page Create Fail !');
            }
        }else{
            return redirect()->route('pages')->with('error','page Validation Fail !');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $page = Page::findorfail($id);

        return view('admin.PagesCrud.ViewPages',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = Page::findorfail($id);

        return view('admin.PagesCrud.EditPages',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $page = Page::findorfail($id);

         $validated = $request->validate([
            'title'=>'required',
            'description'=>'required',
        ]);
        if($validated){
            $page->title = $request->title;
            $page->description = $request->description;

            if($page->save()){
                return redirect()->route('pages')->with('success','page updated Successfully !');
            }else{
                return redirect()->route('pages')->with('error','page update Fail !');
            }
        }else{
            return redirect()->route('pages')->with('error','page Validation Fail !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $page = Page::findorfail($id);

        if($page->delete()){
            return redirect()->route('pages')->with('success','page deleted Successfully !');
        }else{
             return redirect()->route('pages')->with('error','page delete Fail !');
        }
    }
}
