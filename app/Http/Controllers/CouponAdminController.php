<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponAdminController extends Controller
{
    /**
     * Display a listing of coupons
     */
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|string|max:50|unique:coupons,code',
            'type'            => 'required|in:fixed,percent',
            'value'           => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'     => 'nullable|integer|min:1',
            'start_date'      => 'nullable|date',
            'expiry_date'     => 'required|date',
            'status'          => 'required|in:active,inactive'
        ]);

        // Ensure percent value doesn't exceed 100
        if ($request->type === 'percent' && $request->value > 100) {
            return back()
                ->withErrors(['value' => 'Percentage cannot exceed 100%'])
                ->withInput();
        }

        // Create coupon using explicit model variables
        $coupon = new Coupon();
        $coupon->code             = $request->code;
        $coupon->type             = $request->type;
        $coupon->value            = $request->value;
        $coupon->min_order_amount = $request->min_order_amount ?? null;
        $coupon->usage_limit      = $request->usage_limit ?? null;
        $coupon->start_date       = $request->start_date ?? null;
        $coupon->expiry_date      = $request->expiry_date;
        $coupon->status           = $request->status;

        $coupon->save();

        return redirect()
            ->route('coupons.index')
            ->with('success', 'Coupon created successfully');
    }


    /**
     * Show the form for editing the specified coupon
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon
     */
    public function update(Request $request, $id)
    {

        $coupon = Coupon::findOrFail($id);

        // Check manually if another coupon already exists with the same code
        $exists = Coupon::where('code', $request->code)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['code' => 'This coupon code already exists. Please choose another one.'])
                ->withInput();
        }

        $request->validate([
            'code' => 'required|string|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'start_date'  => 'nullable|date|before_or_equal:expiry_date',
            'expiry_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive'
        ]);
        // Ensure percent value doesn't exceed 100
        if ($request->type === 'percent' && $request->value > 100) {
            return back()->withErrors(['value' => 'Percentage cannot exceed 100%'])->withInput();
        }

        $coupon->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully');
    }

    /**
     * Remove the specified coupon
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully');
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = $coupon->status === 'active' ? 'inactive' : 'active';
        $coupon->save();

        return redirect()->back()->with('success', 'Coupon status updated successfully');
    }
}
