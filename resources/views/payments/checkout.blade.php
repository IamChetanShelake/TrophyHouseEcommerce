<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trophy House - Payment Checkout</title>
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .checkout-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .logo {
            margin-bottom: 30px;
        }
        .amount {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
        .order-id {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .message {
            color: #666;
            margin-top: 20px;
        }
        .error-message {
            color: #e74c3c;
            background: #fdf2f2;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #e74c3c;
        }
        .retry-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        .retry-btn:hover {
            background: #5a6fd8;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="logo">
            <h2 style="color: #667eea; margin: 0;">Trophy House</h2>
            <p style="color: #666; margin: 5px 0 0 0;">Secure Payment</p>
        </div>
        
        <div class="amount">₹{{ number_format($amount, 2) }}</div>
        <div class="order-id">Order ID: {{ $order_id }}</div>
        
        <div class="loading" id="loading">
            <div class="spinner"></div>
        </div>
        
        <div class="message" id="message">
            Initializing secure payment gateway...
        </div>
        
        <div id="error-container" style="display: none;">
            <div class="error-message" id="error-message"></div>
            <button class="retry-btn" onclick="retryPayment()">Retry Payment</button>
        </div>
    </div>

    <script>
        let paymentInitialized = false;
        
        function initializePayment() {
            try {
                const stage = "{{ $stage }}";
                const mode = stage === 'SANDBOX' ? 'sandbox' : 'production';
                
                console.log('Initializing Cashfree with mode:', mode);
                console.log('Payment Session ID:', "{{ $payment_session_id }}");
                
                const cashfree = new Cashfree({
                    mode: mode
                });
                
                // Update message
                document.getElementById('message').textContent = 'Redirecting to payment gateway...';
                
                cashfree.checkout({
                    paymentSessionId: "{{ $payment_session_id }}",
                    redirectTarget: "_self"
                }).then(function(result) {
                    console.log('Cashfree checkout result:', result);
                }).catch(function(error) {
                    console.error('Cashfree checkout error:', error);
                    showError('Payment initialization failed. Please try again.');
                });
                
                paymentInitialized = true;
                
            } catch (error) {
                console.error('Error initializing payment:', error);
                showError('Failed to initialize payment gateway. Please try again.');
            }
        }
        
        function showError(message) {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('message').style.display = 'none';
            document.getElementById('error-message').textContent = message;
            document.getElementById('error-container').style.display = 'block';
        }
        
        function retryPayment() {
            document.getElementById('error-container').style.display = 'none';
            document.getElementById('loading').style.display = 'flex';
            document.getElementById('message').style.display = 'block';
            document.getElementById('message').textContent = 'Retrying payment initialization...';
            
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }
        
        // Initialize payment when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add a small delay to ensure everything is loaded
            setTimeout(initializePayment, 1000);
        });
        
        // Fallback: if payment hasn't initialized after 10 seconds, show error
        setTimeout(function() {
            if (!paymentInitialized) {
                showError('Payment gateway is taking longer than expected. Please try again.');
            }
        }, 10000);
    </script>
</body>
</html>
