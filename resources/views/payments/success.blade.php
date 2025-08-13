@extends('website.layout.master')

@section('content')
<style>
    .success-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: -20px;
        padding: 20px;
    }
    .success-card {
        background: white;
        border-radius: 20px;
        padding: 50px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }
    .success-icon {
        width: 80px;
        height: 80px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        animation: checkmark 0.6s ease-in-out;
    }
    .success-icon::after {
        content: '✓';
        color: white;
        font-size: 40px;
        font-weight: bold;
    }
    @keyframes checkmark {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    .success-title {
        color: #28a745;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .success-message {
        color: #666;
        font-size: 18px;
        margin-bottom: 40px;
    }
    .payment-details {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        margin: 30px 0;
        text-align: left;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: 600;
        color: #495057;
    }
    .detail-value {
        color: #212529;
        font-weight: 500;
    }
    .continue-btn {
        background: #d32f2f;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }
    .continue-btn:hover {
        background: #b71c1c;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .order-summary {
        background: #e8f5e8;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid #28a745;
    }
</style>

<div class="success-container">
    <div class="success-card">
        <div class="success-icon"></div>
        
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">
            Thank you for your purchase. Your payment has been processed successfully.
        </p>
        
        <div class="order-summary">
            <h4 style="color: #28a745; margin-bottom: 15px;">
                <i class="fas fa-shopping-cart"></i> Order Confirmed
            </h4>
            <p style="margin: 0; color: #666;">
                Your order has been placed successfully and you will receive a confirmation email shortly.
            </p>
        </div>
        
        <div class="payment-details">
            <h4 style="color: #495057; margin-bottom: 20px; text-align: center;">
                <i class="fas fa-receipt"></i> Payment Details
            </h4>
            
            <div class="detail-row">
                <span class="detail-label">Order ID:</span>
                <span class="detail-value">{{ $order_id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $transaction_id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span class="detail-value">₹{{ number_format($payment['order_amount'], 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Status:</span>
                <span class="detail-value" style="color: #28a745; font-weight: bold;">
                    <i class="fas fa-check-circle"></i> PAID
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Date:</span>
                <span class="detail-value">{{ now()->format('d M Y, h:i A') }}</span>
            </div>
        </div>
        
        <div style="margin-top: 40px;">
            <a href="{{ route('Websitehome') }}" class="continue-btn">
                <i class="fas fa-home"></i> Continue Shopping
            </a>
        </div>
        
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e9ecef;">
            <p style="color: #6c757d; font-size: 14px; margin: 0;">
                <i class="fas fa-info-circle"></i> 
                A confirmation email has been sent to your registered email address.
                <br>
                For any queries, please contact our support team.
            </p>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
