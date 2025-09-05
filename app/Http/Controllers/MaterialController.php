<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(500);

        return view('admin.RawMaterial.material.index', compact('materials'));
    }

    public function create()
    {
        $materialTypes = MaterialType::all();
        return view('admin.RawMaterial.material.create', compact('materialTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:material_types,id',
            'unit' => 'required|in:kg,piece,meter,sheet',
            'description' => 'nullable|string',
            // 'stock_in' => 'required|numeric|min:0',
            // 'stock_out' => 'required|numeric|min:0',
            // 'current_stock' => 'required|numeric|min:0',
            // 'reorder_level' => 'required|numeric|min:0',
        ]);

        $material = new Material();
        $material->name = $request->name;
        $material->category_id = $request->category_id;
        $material->unit = $request->unit;
        $material->desc = $request->description;
        // $material->stock_in = $request->stock_in;
        // $material->stock_out = $request->stock_out;
        // $material->current_stock = $request->current_stock;
        // $material->reorder_level = $request->reorder_level;
        $material->save();

        return redirect()->route('admin.material.index')->with('success', 'Material added successfully!');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $materialTypes = MaterialType::all();
        return view('admin.RawMaterial.material.edit', compact('material', 'materialTypes'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:material_types,id',
            'unit' => 'required|in:kg,piece,meter,sheet',
            'description' => 'nullable|string',
            // 'stock_in' => 'required|numeric|min:0',
            // 'stock_out' => 'required|numeric|min:0',
            // 'current_stock' => 'required|numeric|min:0',
            // 'reorder_level' => 'required|numeric|min:0',
        ]);

        $material->name = $request->name;
        $material->category_id = $request->category_id;
        $material->unit = $request->unit;
        $material->desc = $request->description;
        // $material->stock_in = $request->stock_in;
        // $material->stock_out = $request->stock_out;
        // $material->current_stock = $request->current_stock;
        // $material->reorder_level = $request->reorder_level;
        $material->save();

        return redirect()->route('admin.material.index')->with('success', 'Material updated successfully!');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('admin.material.index')->with('success', 'Material deleted successfully!');
    }
}
