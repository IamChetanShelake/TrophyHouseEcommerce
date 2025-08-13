@extends('website.layout.master')

@section('content')
<style>
    .failed-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        margin: -20px;
        padding: 20px;
    }
    .failed-card {
        background: white;
        border-radius: 20px;
        padding: 50px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }
    .failed-icon {
        width: 80px;
        height: 80px;
        background: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        animation: shake 0.6s ease-in-out;
    }
    .failed-icon::after {
        content: '✕';
        color: white;
        font-size: 40px;
        font-weight: bold;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .failed-title {
        color: #dc3545;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    .failed-message {
        color: #666;
        font-size: 18px;
        margin-bottom: 40px;
    }
    .error-details {
        background: #f8d7da;
        border-radius: 15px;
        padding: 30px;
        margin: 30px 0;
        border-left: 4px solid #dc3545;
    }
    .retry-btn {
        background: #d32f2f;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin: 10px;
        transition: all 0.3s ease;
    }
    .retry-btn:hover {
        background: #b71c1c;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .home-btn {
        background: #6c757d;
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin: 10px;
        transition: all 0.3s ease;
    }
    .home-btn:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }
    .help-section {
        background: #fff3cd;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid #ffc107;
    }
</style>

<div class="failed-container">
    <div class="failed-card">
        <div class="failed-icon"></div>
        
        <h1 class="failed-title">Payment Failed!</h1>
        <p class="failed-message">
            We're sorry, but your payment could not be processed at this time.
        </p>
        
        <div class="error-details">
            <h4 style="color: #721c24; margin-bottom: 15px;">
                <i class="fas fa-exclamation-triangle"></i> What happened?
            </h4>
            <p style="margin: 0; color: #721c24;">
                @if(isset($message))
                    {{ $message }}
                @else
                    Your payment was not successful. This could be due to insufficient funds, network issues, or other technical problems.
                @endif
            </p>
            @if(isset($order_id))
                <p style="margin: 10px 0 0 0; color: #721c24; font-size: 14px;">
                    <strong>Order ID:</strong> {{ $order_id }}
                </p>
            @endif
        </div>
        
        <div class="help-section">
            <h4 style="color: #856404; margin-bottom: 15px;">
                <i class="fas fa-lightbulb"></i> What can you do?
            </h4>
            <ul style="text-align: left; color: #856404; margin: 0; padding-left: 20px;">
                <li>Check your internet connection and try again</li>
                <li>Verify your payment details are correct</li>
                <li>Ensure you have sufficient balance in your account</li>
                <li>Try using a different payment method</li>
                <li>Contact your bank if the issue persists</li>
            </ul>
        </div>
        
        <div style="margin-top: 40px;">
            <a href="{{ route('DeliveryaddressPage') }}" class="retry-btn">
                <i class="fas fa-redo"></i> Try Again
            </a>
            <a href="{{ route('Websitehome') }}" class="home-btn">
                <i class="fas fa-home"></i> Go Home
            </a>
        </div>
        
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e9ecef;">
            <p style="color: #6c757d; font-size: 14px; margin: 0;">
                <i class="fas fa-headset"></i> 
                Need help? Contact our support team at 
                <a href="mailto:support@trophyhouse.shop" style="color: #d32f2f;">support@trophyhouse.shop</a>
                <br>
                or call us at <a href="tel:+919999999999" style="color: #d32f2f;">+91 99999 99999</a>
            </p>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
