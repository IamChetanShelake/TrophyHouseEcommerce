@extends('website.layout.master')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .trophy-img {
        max-width: 100px;
    }
    .card {
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
    .trash-icon {
        cursor: pointer;
    }
    .order-summary {
        padding: 20px;
        border: 1px solid #ddd;
    }
    .btn-continue {
        background-color: white;
        color: red;
        border: 2px solid red;
        font-weight: bold;
        width: 100%;
    }
    .btn-continues {
        background-color: white;
        color: red;
        border: 2px solid red;
        font-weight: bold;
        width: 100%;
    }
    .btn-continue:hover,
    .btn-continues:hover {
        background-color: red;
        color: white;
        border: 2px solid red;
    }
    .step {
        font-family: 'Source Sans 3', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: #555;
    }
    .active-step {
        color: #00b050;
        font-weight: 700;
    }
    .dashed-line {
        width: 40px;
        height: 1px;
        border-bottom: 1px dashed #888;
    }
</style>

<section>
    <div class="container my-5">
        <div class="row">
            <!-- Progress Header -->
            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                <div style="cursor: pointer;" onclick="window.history.back();">
                    <img src="{{ asset('website/assets/images/left.png') }}" alt="Back" width="20">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="step">CART</span>
                    <span class="dashed-line"></span>
                    <span class="step active-step">ADDRESS</span>
                    <span class="dashed-line"></span>
                    <span class="step">PAYMENT</span>
                </div>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('website/assets/images/secure.png') }}" alt="Secure" width="20" class="me-2">
                    <span style="font-size: 13px; letter-spacing: 0.5px; color: #666;">100% SECURE</span>
                </div>
            </div>

            <!-- Left Section -->
            <div class="col-lg-8">
                <p style="font-family: 'Source Sans 3', sans-serif; font-size:20px;padding-top: 20px;font-weight:600;">
                    {{ isset($address) ? 'Edit Shipping Address' : 'Add Shipping Address' }}
                </p>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form action="{{ isset($address) ? route('address.update', $address->id) : route('address.store') }}" method="POST">
                    @csrf
                    @if (isset($address))
                        @method('PUT')
                    @endif
                    <div class="row mb-3" style="padding-top: 24px;">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Name*" value="{{ old('name', isset($address) ? $address->name : '') }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number*" value="{{ old('phone', isset($address) ? $address->phone : '') }}" required>
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="email" class="form-control" name="email" placeholder="Email Address*" value="{{ old('email', isset($address) ? $address->email : '') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="pincode" placeholder="Pincode*" value="{{ old('pincode', isset($address) ? $address->pincode : '') }}" required>
                            @error('pincode')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="address" placeholder="Address* (House No, Building, Street, area)" value="{{ old('address', isset($address) ? $address->address : '') }}" required>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" name="city" placeholder="City*" value="{{ old('city', isset($address) ? $address->city : '') }}" required>
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="state" placeholder="State*" value="{{ old('state', isset($address) ? $address->state : '') }}" required>
                            @error('state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" name="country" placeholder="Country*" value="{{ old('country', isset($address) ? $address->country : '') }}" required>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="delivery_instructions" placeholder="Delivery Instructions" value="{{ old('delivery_instructions', isset($address) ? $address->delivery_instructions : '') }}">
                            @error('delivery_instructions')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-continues mt-3">Save and Deliver here</button>
                </form>
            </div>

            <!-- Right Section -->
            <div class="col-lg-4" style="padding-top: 66px;">
                <div class="order-summary">
                    <p class="text-danger fw-bold mb-3 text-center" style="font-size: 20px;font-weight:700;font-family: 'Source Sans 3', sans-serif">My Order</p>
                    <p class="fw-bold">Price Details ({{ $cart_items }} {{ $cart_items == 1 ? 'Item' : 'Items' }})</p>
                    @php
                        $totalMRP = 0;
                        $totalDiscount = 0;
                        $cartItems = Auth::check() ? \App\Models\cartItem::with('product.variants')->where('user_id', Auth::id())->get() : collect([]); // Updated to cartItem
                        foreach ($cartItems as $item) {
                            $variant = $item->variant ?? $item->product->variants->first();
                            $price = $variant->discounted_price ?? $variant->price;
                            $originalPrice = $variant->price;
                            $totalMRP += $originalPrice * $item->quantity;
                            $totalDiscount += ($originalPrice - $price) * $item->quantity;
                              $finalMRP = $totalMRP - $totalDiscount;
                            $priceWithGST = ($totalMRP - $totalDiscount) * 0.18;
                        }
                        $totalAmount = $totalMRP - $totalDiscount + $priceWithGST;
                    @endphp
                    <div class="d-flex justify-content-between">
                        <span>MRP</span>
                        <span>₹{{ number_format($totalMRP, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Discount on MRP</span>
                        <span>₹{{ number_format($totalDiscount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total MRP</span>
                        <span>₹{{ number_format($finalMRP, 2) }}</span>
                    </div>
                   
                    <div class="d-flex justify-content-between">
                        <span>Shipping Charges</span>
                        <span class="text-success">FREE</span>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total Amount</span>
                        <span>₹{{ number_format($totalAmount, 2) }}</span>
                    </div>
                    <a href="{{ route('DeliveryaddressPage') }}">
                        <button class="btn btn-continue mt-3">Continue</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection