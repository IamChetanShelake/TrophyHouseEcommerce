<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function index(Request $request, $id)
    {
        $query = Purchase::with('material')
            ->where('material_id', $id)
            ->orderBy('created_at', 'desc');

        $material = Material::find($id);

        $purchases = $query->paginate(500);

        return view('admin.RawMaterial.purchase.index', compact('purchases', 'material'));
    }

    public function create($id)
    {
        $material = Material::findOrFail($id);
        // return $material;
        return view('admin.RawMaterial.purchase.create', compact('material'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'material_id' => 'required|exists:materials,id',
    //         'quantity' => 'required|numeric|min:0',
    //         'unit_price' => 'required|numeric|min:0',
    //         'total_cost' => 'required|numeric|min:0',
    //         'supplier_name' => 'required|string|max:255',
    //         'supplier_contact' => 'nullable|string|max:255',
    //         'purchase_date' => 'required|date',
    //     ]);

    //     $purchase = new Purchase();
    //     $purchase->material_id = $request->material_id;
    //     $purchase->quantity = $request->quantity;
    //     $purchase->unit_price = $request->unit_price;
    //     $purchase->total_cost = $request->total_cost;
    //     $purchase->supplier_name = $request->supplier_name;
    //     $purchase->supplier_contact = $request->supplier_contact;
    //     $purchase->purchase_date = $request->purchase_date;
    //     $purchase->save();

    //     return redirect()->route('admin.purchase.index', $purchase->material_id)->with('success', 'Purchase added successfully!');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
        ]);

        $purchase = new Purchase();
        $purchase->material_id = $request->material_id;
        $purchase->quantity = $request->quantity;
        $purchase->unit_price = $request->unit_price;
        $purchase->total_cost = $request->total_cost;
        $purchase->supplier_name = $request->supplier_name;
        $purchase->supplier_contact = $request->supplier_contact;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->save();

        // $material = Material::find($request->material_id);
        // $material->increment('stock_in', $request->quantity);

        $material = Material::find($request->material_id);
        if ($material) {
            $material->increment('stock_in', $request->quantity);
            $material->current_stock = $material->stock_in - $material->stock_out;
            $material->save();
        }

        return redirect()
            ->route('admin.purchase.index', $purchase->material_id)
            ->with('success', 'Purchase added successfully & stock updated!');
    }


    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $materials = Material::all();
        return view('admin.RawMaterial.purchase.edit', compact('purchase', 'materials'));
    }

    // public function update(Request $request, $id)
    // {
    //     $purchase = Purchase::findOrFail($id);

    //     $validated = $request->validate([
    //         'material_id' => 'required|exists:materials,id',
    //         'quantity' => 'required|numeric|min:0',
    //         'unit_price' => 'required|numeric|min:0',
    //         'total_cost' => 'required|numeric|min:0',
    //         'supplier_name' => 'required|string|max:255',
    //         'supplier_contact' => 'nullable|string|max:255',
    //         'purchase_date' => 'required|date',
    //     ]);

    //     $purchase->material_id = $request->material_id;
    //     $purchase->quantity = $request->quantity;
    //     $purchase->unit_price = $request->unit_price;
    //     $purchase->total_cost = $request->total_cost;
    //     $purchase->supplier_name = $request->supplier_name;
    //     $purchase->supplier_contact = $request->supplier_contact;
    //     $purchase->purchase_date = $request->purchase_date;
    //     $purchase->save();

    //     return redirect()->route('admin.purchase.index', $purchase->material_id)->with('success', 'Purchase updated successfully!');
    // }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'purchase_date' => 'required|date',
        ]);

        // जुनी quantity लक्षात ठेव
        $oldQty = $purchase->quantity;

        // Purchase update कर
        $purchase->material_id = $request->material_id;
        $purchase->quantity = $request->quantity;
        $purchase->unit_price = $request->unit_price;
        $purchase->total_cost = $request->total_cost;
        $purchase->supplier_name = $request->supplier_name;
        $purchase->supplier_contact = $request->supplier_contact;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->save();

        $diff = $request->quantity - $oldQty;

        // $material = Material::find($request->material_id);
        // $material->increment('stock_in', $diff);

        $diff = $request->quantity - $oldQty;

        $material = Material::find($request->material_id);
        if ($material) {
            $material->increment('stock_in', $diff);
            $material->current_stock = $material->stock_in - $material->stock_out;
            $material->save();
        }


        return redirect()
            ->route('admin.purchase.index', $purchase->material_id)
            ->with('success', 'Purchase updated successfully & stock adjusted!');
    }


    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return redirect()->route('admin.purchase.index')->with('success', 'Purchase deleted successfully!');
    }
}
