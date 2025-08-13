@extends('website.layout.master')

@section('content')
<style>
    .order-details-container {
        min-height: 80vh;
        padding: 40px 0;
        background: #f8f9fa;
    }
    .order-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 40px;
    }
    .details-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
    }
    .card-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
        color: #333;
    }
    .card-body {
        padding: 30px;
    }
    .order-status {
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
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
    .product-details {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-details:last-child {
        border-bottom: none;
    }
    .product-image {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 15px;
        margin-right: 20px;
    }
    .product-info {
        flex: 1;
    }
    .product-name {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }
    .product-price {
        font-size: 20px;
        color: #d32f2f;
        font-weight: 600;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #666;
    }
    .info-value {
        color: #333;
        font-weight: 500;
    }
    .back-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .back-btn:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .track-order-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .track-order-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .order-timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -35px;
        top: 8px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ddd;
    }
    .timeline-item.active::before {
        background: #28a745;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: -29px;
        top: 20px;
        width: 2px;
        height: calc(100% - 8px);
        background: #ddd;
    }
    .timeline-item:last-child::after {
        display: none;
    }
    .timeline-item.active::after {
        background: #28a745;
    }
</style>

<div class="order-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-0">
                    <i class="fas fa-receipt"></i> Order Details
                </h1>
                <p class="mb-0 mt-2">Order #{{ $order->order_number }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('my.orders') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>

<div class="order-details-container">
    <div class="container">
        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-8">
                <div class="details-card">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i> Order Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">Order Number:</span>
                                    <span class="info-value">{{ $order->order_number }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Order Date:</span>
                                    <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Payment Method:</span>
                                    <span class="info-value">{{ ucfirst($order->payment_method ?? 'Online Payment') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">Order Status:</span>
                                    <span class="order-status status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Total Amount:</span>
                                    <span class="info-value text-success">₹{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Quantity:</span>
                                    <span class="info-value">{{ $order->quantity }} item(s)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="details-card">
                    <div class="card-header">
                        <i class="fas fa-box"></i> Product Details
                    </div>
                    <div class="card-body">
                        <div class="product-details">
                            <img src="{{ asset('product_images/' . $order->product->image) }}" 
                                 alt="{{ $order->product->title }}" 
                                 class="product-image">
                            <div class="product-info">
                                <div class="product-name">{{ $order->product->title }}</div>
                                <div class="text-muted mb-2">{{ $order->product->description ?? 'Premium quality trophy' }}</div>
                                <div class="mb-2">
                                    <span class="badge bg-secondary">Quantity: {{ $order->quantity }}</span>
                                </div>
                                <div class="product-price">₹{{ number_format($order->total_amount, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                <div class="details-card">
                    <div class="card-header">
                        <i class="fas fa-map-marker-alt"></i> Shipping Address
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                            <i class="fas fa-home text-muted me-2"></i>
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Order Tracking -->
            <div class="col-lg-4">
                <div class="details-card">
                    <div class="card-header">
                        <i class="fas fa-truck"></i> Order Tracking
                    </div>
                    <div class="card-body">
                        <div class="order-timeline">
                            <div class="timeline-item active">
                                <strong>Order Placed</strong>
                                <div class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="timeline-item {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                                <strong>Order Confirmed</strong>
                                <div class="text-muted small">
                                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                        Processing your order
                                    @else
                                        Waiting for confirmation
                                    @endif
                                </div>
                            </div>
                            <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'active' : '' }}">
                                <strong>Shipped</strong>
                                <div class="text-muted small">
                                    @if(in_array($order->status, ['shipped', 'delivered']))
                                        Your order is on the way
                                    @else
                                        Preparing for shipment
                                    @endif
                                </div>
                            </div>
                            <div class="timeline-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                                <strong>Delivered</strong>
                                <div class="text-muted small">
                                    @if($order->status == 'delivered')
                                        Order delivered successfully
                                    @else
                                        Estimated delivery in 3-5 days
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(in_array($order->status, ['shipped', 'processing']))
                        <div class="mt-4">
                            <a href="#" class="track-order-btn w-100 text-center d-block">
                                <i class="fas fa-search"></i> Track Package
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="details-card">
                    <div class="card-header">
                        <i class="fas fa-cogs"></i> Order Actions
                    </div>
                    <div class="card-body">
                        @if($order->status == 'pending')
                            <button class="btn btn-danger w-100 mb-2">
                                <i class="fas fa-times"></i> Cancel Order
                            </button>
                        @endif
                        
                        @if($order->status == 'delivered')
                            <button class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-undo"></i> Return Item
                            </button>
                        @endif
                        
                        <button class="btn btn-info w-100 mb-2">
                            <i class="fas fa-download"></i> Download Invoice
                        </button>
                        
                        <button class="btn btn-secondary w-100">
                            <i class="fas fa-headset"></i> Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection