<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use App\Models\Material;
use App\Models\UsagePerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MaterialType;

class UsagePersonController extends Controller
{
    public function index(Request $request)
    {
        $usagePersons = UsagePerson::withSum('usages', 'quantity')->orderBy('created_at', 'desc')->paginate(500);
        return view('admin.RawMaterial.usageperson.index', compact('usagePersons'));
    }

    public function create()
    {
        $materials = Material::select('id', 'name', 'current_stock', 'category_id')->get();
        $materialTypes = MaterialType::select('id', 'name')->get();
        return view('admin.RawMaterial.usageperson.create', compact('materials', 'materialTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'date' => 'required|date',
            'material_id.*' => 'required|exists:materials,id',
            'quantity.*' => 'required|numeric|min:0',
            'usage_date.*' => 'required|date',
        ]);

        $usagePerson = new UsagePerson();
        $usagePerson->name = $request->name;
        $usagePerson->contact = $request->contact;
        $usagePerson->date = $request->date;
        $usagePerson->save();

        foreach ($request->material_id as $key => $material_id) {
            $usage = new Usage();
            $usage->usage_person_id = $usagePerson->id;
            $usage->material_id = $material_id;
            $usage->quantity = $request->quantity[$key];
            $usage->use_person_name = $request->name; // Optional, based on your schema
            $usage->usage_date = $request->usage_date[$key];
            $usage->save();
        }

        $material = Material::find($material_id);
        if ($material) {
            $material->increment('stock_out', $request->quantity[$key]);

            // current_stock calculate & update
            $material->current_stock = $material->stock_in - $material->stock_out;
            $material->save();
        }

        return redirect()->route('admin.usage-person.index')->with('success', 'Usage person and usages added successfully!');
    }

    public function edit($id)
    {
        $usagePerson = UsagePerson::findOrFail($id);
        $usages = $usagePerson->usages;
        $materials = Material::select('id', 'name', 'current_stock', 'category_id')->get();
        $materialTypes = MaterialType::select('id', 'name')->get();
        return view('admin.RawMaterial.usageperson.edit', compact('usagePerson', 'usages', 'materials', 'materialTypes'));
    }

    // public function update(Request $request, $id)
    // {
    //     $usagePerson = UsagePerson::findOrFail($id);

    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'contact' => 'required|string|max:255',
    //         'date' => 'required|date',
    //         'material_id.*' => 'required|exists:materials,id',
    //         'quantity.*' => 'required|numeric|min:0',
    //         'usage_date.*' => 'required|date',
    //     ]);

    //     $usagePerson->name = $request->name;
    //     $usagePerson->contact = $request->contact;
    //     $usagePerson->date = $request->date;
    //     $usagePerson->save();

    //     $usagePerson->usages()->delete();

    //     foreach ($request->material_id as $key => $material_id) {
    //         $usage = new Usage();
    //         $usage->usage_person_id = $usagePerson->id;
    //         $usage->material_id = $material_id;
    //         $usage->quantity = $request->quantity[$key];
    //         $usage->use_person_name = $request->name; // Optional
    //         $usage->usage_date = $request->usage_date[$key];
    //         $usage->save();
    //     }

    //     return redirect()->route('admin.usage-person.index')->with('success', 'Usage person and usages updated successfully!');
    // }

    public function update(Request $request, $id)
    {
        $usagePerson = UsagePerson::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'date' => 'required|date',
            'material_id.*' => 'required|exists:materials,id',
            'quantity.*' => 'required|numeric|min:0',
            'usage_date.*' => 'required|date',
        ]);

        // UsagePerson update
        $usagePerson->name = $request->name;
        $usagePerson->contact = $request->contact;
        $usagePerson->date = $request->date;
        $usagePerson->save();

        foreach ($usagePerson->usages as $oldUsage) {
            $material = Material::find($oldUsage->material_id);
            if ($material) {
                $material->decrement('stock_out', $oldUsage->quantity);
                $material->current_stock = $material->stock_in - $material->stock_out;
                $material->save();
            }
        }
        $usagePerson->usages()->delete();

        foreach ($request->material_id as $key => $material_id) {
            $usage = new Usage();
            $usage->usage_person_id = $usagePerson->id;
            $usage->material_id = $material_id;
            $usage->quantity = $request->quantity[$key];
            $usage->use_person_name = $request->name;
            $usage->usage_date = $request->usage_date[$key];
            $usage->save();

            $material = Material::find($material_id);
            if ($material) {
                $material->increment('stock_out', $request->quantity[$key]);
                $material->current_stock = $material->stock_in - $material->stock_out;
                $material->save();
            }
        }

        return redirect()->route('admin.usage-person.index')->with('success', 'Usage person and usages updated successfully & stock adjusted!');
    }


    public function destroy($id)
    {
        $usagePerson = UsagePerson::findOrFail($id);
        $usagePerson->delete();

        return redirect()->route('admin.usage-person.index')->with('success', 'Usage person and related usages deleted successfully!');
    }
}
