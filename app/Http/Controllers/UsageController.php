<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsageController extends Controller
{
    public function index(Request $request, $id)
    {
        $query = Usage::with('material')
            ->where('material_id', $id)
            ->orderBy('created_at', 'desc');

        $usages = $query->paginate(500);
        $material = Material::find($id);

        return view('admin.RawMaterial.usage.index', compact('usages', 'material'));
    }

    public function create($id)
    {
        $material = Material::find($id);
        return view('admin.RawMaterial.usage.create', compact('material'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'material_id' => 'required|exists:materials,id',
    //         'quantity' => 'required|numeric|min:0',
    //         'use_person_name' => 'required|string|max:255',
    //         'usage_date' => 'required|date',
    //     ]);

    //     $usage = new Usage();
    //     $usage->material_id = $request->material_id;
    //     $usage->quantity = $request->quantity;
    //     $usage->use_person_name = $request->use_person_name;
    //     $usage->usage_date = $request->usage_date;
    //     $usage->save();

    //     return redirect()->route('admin.usage.index',$usage->material_id)->with('success', 'Usage added successfully!');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
            'use_person_name' => 'required|string|max:255',
            'usage_date' => 'required|date',
        ]);

        $usage = new Usage();
        $usage->material_id = $request->material_id;
        $usage->quantity = $request->quantity;
        $usage->use_person_name = $request->use_person_name;
        $usage->usage_date = $request->usage_date;
        $usage->save();

        $material = Material::find($request->material_id);
        $material->increment('stock_out', $request->quantity);

        return redirect()
            ->route('admin.usage.index', $usage->material_id)
            ->with('success', 'Usage added successfully & stock_out updated!');
    }


    public function edit($id)
    {
        $usage = Usage::findOrFail($id);
        $materials = Material::all();
        return view('admin.RawMaterial.usage.edit', compact('usage', 'materials'));
    }

    // public function update(Request $request, $id)
    // {
    //     $usage = Usage::findOrFail($id);

    //     $validated = $request->validate([
    //         'material_id' => 'required|exists:materials,id',
    //         'quantity' => 'required|numeric|min:0',
    //         'use_person_name' => 'required|string|max:255',
    //         'usage_date' => 'required|date',
    //     ]);

    //     $usage->material_id = $request->material_id;
    //     $usage->quantity = $request->quantity;
    //     $usage->use_person_name = $request->use_person_name;
    //     $usage->usage_date = $request->usage_date;
    //     $usage->save();

    //     return redirect()->route('admin.usage.index', $usage->material_id)->with('success', 'Usage updated successfully!');
    // }


    public function update(Request $request, $id)
    {
        $usage = Usage::findOrFail($id);

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
            'use_person_name' => 'required|string|max:255',
            'usage_date' => 'required|date',
        ]);

        $oldQty = $usage->quantity;

        $usage->material_id = $request->material_id;
        $usage->quantity = $request->quantity;
        $usage->use_person_name = $request->use_person_name;
        $usage->usage_date = $request->usage_date;
        $usage->save();

        $diff = $request->quantity - $oldQty;

        $material = Material::find($request->material_id);
        $material->increment('stock_out', $diff);

        return redirect()
            ->route('admin.usage.index', $usage->material_id)
            ->with('success', 'Usage updated successfully & stock_out adjusted!');
    }


    public function destroy($id)
    {
        $usage = Usage::findOrFail($id);
        $usage->delete();

        return redirect()->route('admin.usage.index')->with('success', 'Usage deleted successfully!');
    }
}
