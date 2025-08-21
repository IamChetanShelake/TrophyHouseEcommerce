@extends('website.layout.master')
@section('content')

    <style>
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

        .address-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background-color: #fff;
            transition: 0.3s ease;
        }

        .address-card:hover {
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.2);
        }

        .address-header {
            font-weight: 600;
            color: #d32f2f;
        }

        .address-selected {
            border: 2px solid #d32f2f;
        }

        .btn-outline-red {
            border: 1px solid #d32f2f;
            color: #d32f2f;
        }

        .btn-outline-red:hover {
            background-color: #d32f2f;
            color: #fff;
        }

        .price-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .price-details .d-flex {
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .btn-continue {
            background-color: #d32f2f;
            color: white;
            width: 100%;
            font-weight: 600;
        }

        .btn-continue:hover {
            background-color: #b71c1c;
            color: white;
        }

        .icon-trophy {
            width: 25px;
            margin-right: 8px;
        }

        .custom-radio {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d32f2f;
            border-radius: 6px;
            background-color: transparent;
            display: inline-block;
            position: relative;
            margin-right: 10px;
            vertical-align: middle;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .custom-radio:checked::before {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: #ff7e6b;
            border-radius: 3px;
            top: 2px;
            left: 2px;
        }
    </style>

    <section class="container my-5">
        <div class="row g-4">
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

            <!-- Left Column: Address Section -->
            <div class="col-lg-8">
                <p class="mb-3" style="font-family:'Source Sans 3', sans-serif;font-size:20px;font-weight:600;">Select
                    Address</p>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($addresses->isEmpty())
                    <p class="text-danger">No addresses found. Please add a new address.</p>
                    <div class="text-center">
                        <a href="{{ route('addnewaddress.new') }}" class="btn btn-outline-red">
                            <i class="bi bi-plus-lg"></i> Add New Address
                        </a>
                    </div>
                @else
                    @if ($selectedAddress)
                        <p style="font-family:'Source Sans 3', sans-serif;font-size:18px;font-weight:600;">Default Address
                        </p>
                        <div class="address-card mb-3 {{ $selectedAddress->is_default ? 'address-selected' : '' }}">
                            <label class="d-flex">
                                <input type="radio" name="address" class="custom-radio" value="{{ $selectedAddress->id }}"
                                    {{ $selectedAddress->is_default ? 'checked' : '' }}
                                    onclick="selectAddress(this, {{ $selectedAddress->id }})">
                                <div>
                                    <p class="address-header mb-1">{{ $selectedAddress->name }}</p>
                                    <p class="mb-1">{{ $selectedAddress->address }}, {{ $selectedAddress->city }},
                                        {{ $selectedAddress->state }} - {{ $selectedAddress->pincode }}</p>
                                    <p class="mb-1"><strong>Mobile:</strong> {{ $selectedAddress->phone }}</p>

                                    <form action="{{ route('address.delete', $selectedAddress->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this address?')">Remove</button>
                                    </form>
                                    <a href="{{ route('address.edit', $selectedAddress->id) }}"
                                        class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                </div>
                            </label>
                        </div>
                    @endif

                    @if ($addresses->where('is_default', false)->count() > 0)
                        <p style="font-family:'Source Sans 3', sans-serif;font-size:18px;font-weight:600;">Other Addresses
                        </p>
                        @foreach ($addresses->where('is_default', false) as $address)
                            <div
                                class="address-card mb-3 {{ $address->id == ($selectedAddress->id ?? 0) ? 'address-selected' : '' }}">
                                <label class="d-flex">
                                    <input type="radio" name="address" class="custom-radio" value="{{ $address->id }}"
                                        {{ $address->id == ($selectedAddress->id ?? 0) ? 'checked' : '' }}
                                        onclick="selectAddress(this, {{ $address->id }})">
                                    <div>
                                        <p class="address-header mb-1">{{ $address->name }}</p>
                                        <p class="mb-1">{{ $address->address }}, {{ $address->city }},
                                            {{ $address->state }} - {{ $address->pincode }}</p>
                                        <p class="mb-1"><strong>Mobile:</strong> {{ $address->phone }}</p>
                                        <form action="{{ route('address.delete', $address->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this address?')">Remove</button>
                                        </form>
                                        <a href="{{ route('address.edit', $address->id) }}"
                                            class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    @endif
                @endif

                <div class="text-center">
                    <a href="{{ route('addnewaddress.new') }}" class="btn btn-outline-red">
                        <i class="bi bi-plus-lg"></i> Add New Address
                    </a>
                </div>
            </div>

            <!-- Right Column: Price Summary -->
            <div class="col-lg-4" style="padding-top: 54px;">
                <div class="price-box">
                    <p class="mb-3" style="font-family:'Source Sans 3', sans-serif;font-size:20px;font-weight:600;">PICKUP
                        ESTIMATES</p>

                    @php
                        use App\Models\CartItem;
                        $cartItems = CartItem::with('product', 'variant')
                            ->where('user_id', auth()->id())
                            ->get();

                        $totalMRP = 0;
                        $totalDiscount = 0;

                        $shippingCharges = 0;

                        foreach ($cartItems as $item) {
                            $variant = $item->variant;
                            $originalPrice = $variant ? $variant->price : 0;
                            $discountedPrice = $variant ? $variant->discounted_price ?? $originalPrice : $originalPrice;
                            $quantity = $item->quantity;
                            $totalMRP += $originalPrice * $quantity;
                            $totalDiscount += ($originalPrice - $discountedPrice) * $quantity;
                        }

                        $totalBase = $totalMRP - $totalDiscount;
                        $totalGST = $totalBase * 0.18;
                        $priceWithGST = $totalBase + $totalGST;
                        $totalAmount = $priceWithGST + $shippingCharges;
                    @endphp

                    @foreach ($cartItems as $item)
                        @php
                            $variant = $item->variant;
                            $unitPrice = $variant ? $variant->discounted_price ?? $variant->price : 0;
                            $itemTotal = $unitPrice * $item->quantity;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ asset('product_images/' . $item->product->image) }}" class="icon-trophy"
                                alt="product">
                            @php
                                $startDate = \Carbon\Carbon::now()->format('d M');
                                $endDate = \Carbon\Carbon::now()->addDays(5)->format('d M');
                            @endphp

                            <small>
                                {{ $item->product->title }}
                                @if ($variant && $variant->size)
                                    ({{ $variant->size }} - inch)
                                @endif
                                (x{{ $item->quantity }}) - ₹{{ number_format($itemTotal, 2) }}<br>
                                <!--Delivery between 16 June - 18 June-->
                            </small>
                        </div>
                    @endforeach
                    Pickup between {{ $startDate }} - {{ $endDate }}

                    <p style="font-family:'Source Sans 3', sans-serif;font-size:18px;font-weight:600;" class="mb-3">
                        Price Details ({{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'Item' : 'Items' }})
                    </p>

                    <div class="price-details">
                        <div class="d-flex">
                            <span>MRP</span>
                            <span>₹{{ number_format($totalMRP, 2) }}</span>
                        </div>
                        <div class="d-flex">
                            <span>Discount on MRP</span>
                            <span class="text-success">−₹{{ number_format($totalDiscount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total MRP</span>
                            <span id="final-mrp">₹{{ number_format($totalBase, 2) }}</span>
                        </div>

                        <div class="d-flex">
                            <span>Shipping Charges</span>
                            <span class="{{ $shippingCharges == 0 ? 'text-success' : '' }}">
                                {{ $shippingCharges == 0 ? 'FREE' : '₹' . number_format($shippingCharges, 2) }}
                            </span>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total Amount (incl. 18% GST)</strong>
                        <strong>₹{{ number_format($totalAmount, 2) }}</strong>
                    </div>

                    <form action="{{ route('pay') }}" method="POST">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $totalAmount }}">
                        <button type="submit" class="btn btn-continue">Proceed To Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        function selectAddress(radio, addressId) {
            document.querySelectorAll('.address-card').forEach(card => {
                card.classList.remove('address-selected');
            });
            radio.closest('.address-card').classList.add('address-selected');

            fetch(`/address/set-default/${addressId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to set default address.');
                    }
                })
                .catch(error => {
                    console.error('Error setting default address:', error);
                    alert('An error occurred while setting the default address.');
                });
        }
    </script>
@endsection
