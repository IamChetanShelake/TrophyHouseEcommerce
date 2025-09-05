<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::withSum('purchases', 'total_cost')->orderBy('created_at', 'desc')->paginate(500);
        return view('admin.RawMaterial.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        // $materials = Material::select('id', 'name', 'current_stock')->get();
        // return view('admin.RawMaterial.supplier.create', compact('materials'));
        $materials = Material::select('id', 'name', 'current_stock', 'category_id')->get();
        $materialTypes = MaterialType::select('id', 'name')->get();
        return view('admin.RawMaterial.supplier.create', compact('materials', 'materialTypes'));
    }

    // public function store(Request $request)
    // {
    //     //return $request->all();
    //     $validated = $request->validate([
    //         'bill_no' => 'required|string|max:255',
    //         'supplier_name' => 'required|string|max:255',
    //         'supplier_contact' => 'nullable|string|max:255',
    //         'supplier_address' => 'nullable|string',
    //         'purchase_date' => 'required|date',
    //         'material_id.*' => 'required|exists:materials,id',
    //         'quantity.*' => 'required|numeric|min:0',
    //         'unit_price.*' => 'required|numeric|min:0',
    //         'total_cost.*' => 'required|numeric|min:0',
    //     ]);

    //     $supplier = new Supplier();
    //     $supplier->bill_no = $request->bill_no;
    //     $supplier->supplier_name = $request->supplier_name;
    //     $supplier->supplier_contact = $request->supplier_contact;
    //     $supplier->supplier_address = $request->supplier_address;
    //     $supplier->purchase_date = $request->purchase_date;
    //     $supplier->save();

    //     foreach ($request->material_id as $key => $material_id) {
    //         $purchase = new Purchase();
    //         $purchase->supplier_id = $supplier->id;
    //         $purchase->material_id = $material_id;
    //         $purchase->quantity = $request->quantity[$key];
    //         $purchase->unit_price = $request->unit_price[$key];
    //         $purchase->total_cost = $request->total_cost[$key];
    //         $purchase->supplier_name = $request->supplier_name; // Optional, based on your schema
    //         $purchase->supplier_contact = $request->supplier_contact; // Optional
    //         $purchase->purchase_date = $request->purchase_date; // Optional
    //         $purchase->save();
    //     }

    //     return redirect()->route('admin.supplier.create')->with('success', 'Supplier and purchases added successfully!');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bill_no' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'supplier_address' => 'nullable|string',
            'purchase_date' => 'required|date',
            'material_id.*' => 'required|exists:materials,id',
            'quantity.*' => 'required|numeric|min:0',
            'unit_price.*' => 'required|numeric|min:0',
            'total_cost.*' => 'required|numeric|min:0',
        ]);

        // Save supplier first
        $supplier = new Supplier();
        $supplier->bill_no = $request->bill_no;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_contact = $request->supplier_contact;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->purchase_date = $request->purchase_date;
        $supplier->save();

        // Loop through purchases
        foreach ($request->material_id as $key => $material_id) {
            $purchase = new Purchase();
            $purchase->supplier_id = $supplier->id;
            $purchase->material_id = $material_id;
            $purchase->quantity = $request->quantity[$key];
            $purchase->unit_price = $request->unit_price[$key];
            $purchase->total_cost = $request->total_cost[$key];
            $purchase->supplier_name = $request->supplier_name;
            $purchase->supplier_contact = $request->supplier_contact;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->save();

            // // ✅ Stock update in material table
            // $material = Material::find($material_id);
            // if ($material) {
            //     $material->increment('stock_in', $request->quantity[$key]);
            // }

            // ✅ Stock update in material table
            $material = Material::find($material_id);
            if ($material) {
                $material->increment('stock_in', $request->quantity[$key]);

                // current_stock calculate & update
                $material->current_stock = $material->stock_in - $material->stock_out;
                $material->save();
            }
        }

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier and purchases added successfully & stock updated!');
    }


    public function edit($id)
    {
        // $supplier = Supplier::findOrFail($id);
        // $purchases = $supplier->purchases;
        // $materials = Material::select('id', 'name', 'current_stock')->get();
        // return view('admin.RawMaterial.supplier.edit', compact('supplier', 'purchases', 'materials'));

        $supplier = Supplier::findOrFail($id);
        $purchases = $supplier->purchases;
        $materials = Material::select('id', 'name', 'current_stock', 'category_id')->get();
        $materialTypes = MaterialType::select('id', 'name')->get();
        return view('admin.RawMaterial.supplier.edit', compact('supplier', 'purchases', 'materials', 'materialTypes'));
    }

    // public function update(Request $request, $id)
    // {
    //     $supplier = Supplier::findOrFail($id);

    //     $validated = $request->validate([
    //         'bill_no' => 'required|string|max:255',
    //         'supplier_name' => 'required|string|max:255',
    //         'supplier_contact' => 'nullable|string|max:255',
    //         'supplier_address' => 'nullable|string',
    //         'purchase_date' => 'required|date',
    //         'material_id.*' => 'required|exists:materials,id',
    //         'quantity.*' => 'required|numeric|min:0',
    //         'unit_price.*' => 'required|numeric|min:0',
    //         'total_cost.*' => 'required|numeric|min:0',
    //     ]);

    //     $supplier->bill_no = $request->bill_no;
    //     $supplier->supplier_name = $request->supplier_name;
    //     $supplier->supplier_contact = $request->supplier_contact;
    //     $supplier->supplier_address = $request->supplier_address;
    //     $supplier->purchase_date = $request->purchase_date;
    //     $supplier->save();

    //     // Delete old purchases
    //     $supplier->purchases()->delete();

    //     // Add new purchases
    //     foreach ($request->material_id as $key => $material_id) {
    //         $purchase = new Purchase();
    //         $purchase->supplier_id = $supplier->id;
    //         $purchase->material_id = $material_id;
    //         $purchase->quantity = $request->quantity[$key];
    //         $purchase->unit_price = $request->unit_price[$key];
    //         $purchase->total_cost = $request->total_cost[$key];
    //         $purchase->supplier_name = $request->supplier_name; // Optional
    //         $purchase->supplier_contact = $request->supplier_contact; // Optional
    //         $purchase->purchase_date = $request->purchase_date; // Optional
    //         $purchase->save();
    //     }

    //     return redirect()->route('admin.supplier.index')->with('success', 'Supplier and purchases updated successfully!');
    // }


    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'bill_no' => 'required|string|max:255',
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'supplier_address' => 'nullable|string',
            'purchase_date' => 'required|date',
            'material_id.*' => 'required|exists:materials,id',
            'quantity.*' => 'required|numeric|min:0',
            'unit_price.*' => 'required|numeric|min:0',
            'total_cost.*' => 'required|numeric|min:0',
        ]);

        // Supplier update
        $supplier->bill_no = $request->bill_no;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_contact = $request->supplier_contact;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->purchase_date = $request->purchase_date;
        $supplier->save();

        foreach ($supplier->purchases as $oldPurchase) {
            $material = Material::find($oldPurchase->material_id);
            if ($material) {
                $material->decrement('stock_in', $oldPurchase->quantity);
            }
        }
        $supplier->purchases()->delete();

        foreach ($request->material_id as $key => $material_id) {
            $purchase = new Purchase();
            $purchase->supplier_id = $supplier->id;
            $purchase->material_id = $material_id;
            $purchase->quantity = $request->quantity[$key];
            $purchase->unit_price = $request->unit_price[$key];
            $purchase->total_cost = $request->total_cost[$key];
            $purchase->supplier_name = $request->supplier_name;
            $purchase->supplier_contact = $request->supplier_contact;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->save();

            // $material = Material::find($material_id);
            // if ($material) {
            //     $material->increment('stock_in', $request->quantity[$key]);
            // }
            $material = Material::find($material_id);
            if ($material) {
                $material->increment('stock_in', $request->quantity[$key]);

                // current_stock calculate & update
                $material->current_stock = $material->stock_in - $material->stock_out;
                $material->save();
            }
        }

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier and purchases updated successfully & stock adjusted!');
    }


    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier and related purchases deleted successfully!');
    }
}
