@extends('website.layout.master')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-color: #e63946;
        --secondary-color: #FFDE57;
        --background-color: #fff;
        --card-border: 1px solid #f0cfcf;
        --text-color: #333;
        --muted-text: #666;
        --transition: all 0.3s ease-in-out;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --accent-color: #00b050;
    }

    body {
        font-family: 'Source Sans 3', sans-serif;
        background: var(--background-color);
    }

    .orders-container {
        min-height: 80vh;
        padding: 40px 0;
    }

    .orders-header {
        background: var(--background-color);
        border-bottom: var(--card-border);
        padding: 15px 0;
        margin-bottom: 30px;
    }

    .orders-header .step {
        font-size: 14px;
        font-weight: 500;
        color: var(--muted-text);
        text-transform: uppercase;
    }

    .orders-header .active-step {
        color: var(--accent-color);
        font-weight: 700;
    }

    .orders-header .dashed-line {
        width: 40px;
        height: 1px;
        border-bottom: 1px dashed #888;
        margin: 0 10px;
    }

    .order-card {
        background: white;
        border: var(--card-border);
        border-radius: 10px;
        margin-bottom: 20px;
        transition: var(--transition);
    }

    .order-card:hover {
        transform: scale(1.02);
        box-shadow: var(--card-shadow);
    }

    .order-header {
        padding: 15px 20px;
        border-bottom: var(--card-border);
        background: linear-gradient(90deg, #fff7dc, #FFDE57);
        border-radius: 10px 10px 0 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 15px;
    }

    .order-body {
        padding: 20px;
    }

    .order-status {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #FFE3E3;
        color: var(--primary-color);
    }

    .status-pending {
        background: #FFE3E3;
        color: var(--primary-color);
    }

    .status-processing {
        background: #E8E8E8;
        color: #004085;
    }

    .status-shipped {
        background: #d1fae5;
        color: var(--accent-color);
    }

    .status-delivered {
        background: #a5f3fc;
        color: #155e75;
    }

    .status-cancelled, .status-failed {
        background: #fee2e2;
        color: var(--primary-color);
    }

    .status-paid {
        background: #d1fae5;
        color: var(--accent-color);
    }

    .product-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: var(--card-border);
        transition: var(--transition);
    }

    .product-item:hover {
        background: #fff7dc;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 8px;
        margin-right: 15px;
        border: var(--card-border);
    }

    .product-name {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 8px;
    }

    .product-price {
        color: var(--primary-color);
        font-size: 16px;
        font-weight: 600;
    }

    .no-orders {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border: var(--card-border);
        border-radius: 10px;
        margin: 0 auto;
        max-width: 500px;
        box-shadow: var(--card-shadow);
    }

    .no-orders-icon {
        font-size: 80px;
        color: var(--primary-color);
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    .btn-shop-now, .btn-download-bill {
        background: linear-gradient(to right, #f9d423, #ff4e50);
        color: white;
        font-weight: 600;
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        text-transform: uppercase;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-shop-now:hover, .btn-download-bill:hover {
        background: linear-gradient(to right, #fca311, #e63946);
        transform: translateY(-2px);
    }

    .dropdown-menu {
        border: var(--card-border);
        border-radius: 10px;
        box-shadow: var(--card-shadow);
    }

    .dropdown-item {
        font-size: 14px;
        padding: 10px 20px;
        transition: var(--transition);
        color: var(--text-color);
    }

    .dropdown-item:hover {
        background: #FFE3E3;
        color: var(--primary-color);
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    @media (max-width: 768px) {
        .orders-header .step {
            font-size: 12px;
        }
        .orders-header .dashed-line {
            width: 20px;
        }
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }
        .product-image {
            width: 80px;
            height: 80px;
        }
        .product-name {
            font-size: 16px;
        }
        .order-card {
            margin-bottom: 15px;
        }
        .no-orders {
            margin: 0 15px;
            padding: 40px 15px;
        }
    }

    @media (max-width: 576px) {
        .order-header {
            gap: 10px;
        }
        .product-item {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        .product-image {
            margin-bottom: 10px;
        }
    }
</style>

<section class="orders-container">
    <div class="container">
        <!-- Orders Header -->
        <div class="orders-header">
            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                <div style="cursor: pointer;" onclick="window.history.back();">
                    <img src="{{ asset('website/assets/images/left.png') }}" alt="Back" width="20">
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="step">CART</span>
                    <span class="dashed-line"></span>
                    <span class="step">ADDRESS</span>
                    <span class="dashed-line"></span>
                    <span class="step active-step">PAYMENT</span>
                </div>
                <div class="d-flex align-items-center">
                    <img src="{{ asset('website/assets/images/secure.png') }}" alt="Secure" width="20" class="me-2">
                    <span style="font-size: 13px; letter-spacing: 0.5px; color: var(--muted-text);">100% SECURE</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($payments->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 style="font-size: 24px; font-weight: bold; color: var(--primary-color); font-family: 'Times New Roman', serif;">
                            My Orders ({{ $payments->count() }})
                        </h4>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-filter"></i> Filter by Status
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="filterOrders('all')">All Orders</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterOrders('paid')">Paid</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterOrders('pending')">Pending</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterOrders('failed')">Failed</a></li>
                            </ul>
                        </div>
                    </div>

                    @foreach($payments as $payment)
                        <div class="order-card" data-status="{{ $payment->status }}">
                            <div class="order-header">
                                <div class="d-flex flex-wrap align-items-center gap-3">
                                    <div>
                                        <strong>Order #{{ $payment->order_id }}</strong>
                                    </div>
                                    <div>
                                        <span class="order-status status-{{ $payment->status }}">
                                            <i class="bi bi-circle-fill fa-xs"></i> {{ ucfirst($payment->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <small style="color: var(--muted-text);">
                                            <i class="bi bi-calendar"></i> {{ $payment->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <strong style="color: var(--primary-color);">₹{{ number_format($payment->amount, 2) }}</strong>
                                    </div>
                                    <div class="ms-auto d-flex gap-2 align-items-center">
                                        @if($payment->status == 'paid')
                                            <a href="{{ route('orders.bill', $payment->order_id) }}" target="_blank" class="btn-download-bill">
                                                <i class="bi bi-file-earmark-pdf"></i> E-Bill
                                            </a>
                                        @endif
                                        <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                            <i class="bi bi-{{ $payment->status == 'paid' ? 'check-circle' : ($payment->status == 'pending' ? 'clock' : 'x-circle') }}"></i>
                                            {{ $payment->status == 'paid' ? 'Payment Successful' : ($payment->status == 'pending' ? 'Payment Pending' : 'Payment Failed') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="order-body">
                                @if($payment->paymentItems->count() > 0)
                                    @foreach($payment->paymentItems as $item)
                                        <div class="product-item">
                                            <img src="{{ asset('product_images/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->title }}" 
                                                 class="product-image">
                                            <div class="product-details">
                                                <div class="product-name">{{ $item->product->title }}</div>
                                                <div style="color: var(--muted-text); font-size: 14px;">
                                                    Quantity: {{ $item->quantity }}
                                                </div>
                                                @if($item->variant)
                                                    <div style="color: var(--muted-text); font-size: 14px;">
                                                        Variant: {{ $item->variant->size ?? 'Standard' }}
                                                    </div>
                                                @endif
                                                <div class="product-price">₹{{ number_format($item->total_price, 2) }}</div>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                    <i class="bi bi-{{ $payment->status == 'paid' ? 'check-circle' : ($payment->status == 'pending' ? 'clock' : 'x-circle') }}"></i>
                                                    {{ ucfirst($payment->status) }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-box text-muted" style="font-size: 60px;"></i>
                                        <p style="color: var(--muted-text); margin-top: 15px;">No items found for this payment</p>
                                    </div>
                                @endif
                                <div class="mt-3 pt-3 border-top">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small style="color: var(--muted-text);">
                                                <i class="bi bi-credit-card"></i>
                                                <strong>Payment Method:</strong> {{ ucfirst($payment->payment_mode ?? 'Online Payment') }}
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            @if($payment->transaction_id)
                                                <small style="color: var(--muted-text);">
                                                    <i class="bi bi-receipt"></i>
                                                    <strong>Transaction ID:</strong> {{ $payment->transaction_id }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-orders">
                        <div class="no-orders-icon">
                            <i class="bi bi-cart"></i>
                        </div>
                        <h3 style="font-size: 24px; font-weight: bold; color: var(--primary-color); font-family: 'Times New Roman', serif;">
                            No Orders Yet
                        </h3>
                        <p style="color: var(--muted-text); margin-bottom: 20px;">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                        <a href="{{ route('Websitehome') }}" class="btn-shop-now">
                            <i class="bi bi-cart"></i> Shop Now
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<script>
function filterOrders(status) {
    const orderCards = document.querySelectorAll('.order-card');
    orderCards.forEach(card => {
        card.style.display = status === 'all' || card.dataset.status === status ? 'block' : 'none';
    });
}
</script>
@endsection