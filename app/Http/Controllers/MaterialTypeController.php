<?php

namespace App\Http\Controllers;

use App\Models\MaterialType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = MaterialType::query()->orderBy('created_at', 'desc');
        $materialTypes = $query->paginate(500);

        return view('admin.RowMaterial.materialtype.index', compact('materialTypes'));
    }

    public function create()
    {
        return view('admin.RowMaterial.materialtype.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $materialType = new MaterialType();
        $materialType->name = $request->name;
        $materialType->desc = $request->description;
        $materialType->save();

        return redirect()->route('admin.materialtype.index')->with('success', 'Material type added successfully!');
    }

    public function edit($id)
    {
        $materialType = MaterialType::findOrFail($id);
        return view('admin.RowMaterial.materialtype.edit', compact('materialType'));
    }

    public function update(Request $request, $id)
    {
        $materialType = MaterialType::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $materialType->name = $request->name;
        $materialType->desc = $request->description;
        $materialType->save();

        return redirect()->route('admin.materialtype.index')->with('success', 'Material type updated successfully!');
    }

    public function destroy($id)
    {
        $materialType = MaterialType::findOrFail($id);
        $materialType->delete();

        return redirect()->route('admin.materialtype.index')->with('success', 'Material type deleted successfully!');
    }
}
