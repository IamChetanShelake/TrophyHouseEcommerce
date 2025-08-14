@extends('website.layout.master')

@section('content')
    <style>
        .orders-container {
            min-height: 80vh;
            padding: 40px 0;
            background: #f8f9fa;
        }

        .orders-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }

        .order-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .order-header {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .order-body {
            padding: 20px;
        }

        .order-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .status-shipped {
            background: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .product-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .product-price {
            color: #d32f2f;
            font-weight: 600;
        }

        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .no-orders-icon {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .btn-shop-now {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-shop-now:hover {
            background: #b71c1c;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .view-details-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-details-btn:hover {
            background: #5a6fd8;
            color: white;
            text-decoration: none;
        }
    </style>

    <div class="orders-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="fas fa-box"></i> My Orders
                    </h1>
                    <p class="mb-0 mt-2">Track and manage your orders</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('Websitehome') }}" class="btn btn-light">
                        <i class="fas fa-shopping-cart"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="orders-container">
        <div class="container">
            @if ($payments->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4>Your Orders ({{ $payments->count() }})</h4>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-filter"></i> Filter by Status
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="filterOrders('all')">All Orders</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="filterOrders('paid')">Paid</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="filterOrders('pending')">Pending</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="filterOrders('failed')">Failed</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @foreach ($payments as $payment)
                            <div class="order-card" data-status="{{ $payment->status }}">
                                <div class="order-header">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <strong>Order #{{ $payment->order_id }}</strong>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="order-status status-{{ $payment->status }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                        <div class="col-md-2">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i>
                                                {{ $payment->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                        <div class="col-md-2">
                                            <strong class="text-success">₹{{ number_format($payment->amount, 2) }}</strong>
                                        </div>

                                        <div class="col-md-3 text-end">
                                            {{-- @if ($payment->status == 'paid')
                                                <a href="{{ route('orders.bill', $payment->order_id) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="fas fa-file-pdf"></i> Download E-Bill
                                                </a>
                                            @endif --}}


                                            @if ($payment->status == 'paid')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Payment Successful
                                                </span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock"></i> Payment Pending
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Payment Failed
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="order-body">
                                    @if ($payment->paymentItems->count() > 0)
                                        @foreach ($payment->paymentItems as $item)
                                            <div class="product-item">
                                                <img src="{{ asset('product_images/' . $item->product->image) }}"
                                                    alt="{{ $item->product->title }}" class="product-image">
                                                <div class="product-details">
                                                    <div class="product-name">{{ $item->product->title }}</div>
                                                    <div class="text-muted">Quantity: {{ $item->quantity }}</div>
                                                    @if ($item->variant)
                                                        <div class="text-muted small">
                                                            Variant: {{ $item->variant->size ?? 'Standard' }}
                                                        </div>
                                                    @endif
                                                    <div class="product-price">₹{{ number_format($item->total_price, 2) }}
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    @if ($payment->status == 'paid')
                                                        <small class="text-success">
                                                            <i class="fas fa-check-circle"></i> Paid
                                                        </small>
                                                    @elseif($payment->status == 'pending')
                                                        <small class="text-warning">
                                                            <i class="fas fa-clock"></i> Pending
                                                        </small>
                                                    @else
                                                        <small class="text-danger">
                                                            <i class="fas fa-times-circle"></i> Failed
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3">
                                            <i class="fas fa-box-open text-muted" style="font-size: 48px;"></i>
                                            <p class="text-muted mt-2">No items found for this payment</p>
                                        </div>
                                    @endif

                                    <div class="mt-3 pt-3 border-top">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-credit-card"></i>
                                                    <strong>Payment Method:</strong>
                                                    {{ ucfirst($payment->payment_mode ?? 'Online Payment') }}
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                @if ($payment->transaction_id)
                                                    <small class="text-muted">
                                                        <i class="fas fa-receipt"></i>
                                                        <strong>Transaction ID:</strong> {{ $payment->transaction_id }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="no-orders">
                    <div class="no-orders-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3>No Orders Yet</h3>
                    <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders here!
                    </p>
                    <a href="{{ route('Websitehome') }}" class="btn-shop-now">
                        <i class="fas fa-shopping-cart"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function filterOrders(status) {
            const orderCards = document.querySelectorAll('.order-card');

            orderCards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
