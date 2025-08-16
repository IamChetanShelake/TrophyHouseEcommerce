<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $payment->order_id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
            background: #fff;
            position: relative;
        }

        /* Full Page Watermark */
        .watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: url('{{ public_path("website/assets/images/TH-logo.png") }}') center center no-repeat;
            background-size: 500px; /* Adjust logo size */
            opacity: 0.05; /* Faded effect */
        }

        .invoice-box {
            max-width: 900px;
            margin: 30px auto;
            background: rgba(255,255,255,0.96); /* Slight overlay for better readability */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #d62828;
        }
        .logo {
            max-height: 70px;
            margin-bottom: 10px;
        }
        .company-info {
            font-size: 13px;
            color: #666;
        }
        .invoice-title {
            color: #d62828;
            font-size: 26px;
            margin-top: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .invoice-details {
            margin-top: 25px;
            padding: 15px;
            background: #fff7f7;
            border-radius: 8px;
            border: 1px solid #f5d0d0;
        }
        .invoice-details p {
            margin: 5px 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background: #d62828;
            color: white;
            font-weight: 600;
            padding: 10px;
            text-align: center;
            font-size: 13px;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 13px;
            background: rgba(255,255,255,0.9);
        }
        .total-summary {
            margin-top: 25px;
            border-top: 2px solid #d62828;
            padding-top: 15px;
            width: 100%;
        }
        .total-summary td {
            padding: 10px;
            font-size: 14px;
        }
        .total-summary .label {
            text-align: right;
            font-weight: bold;
            color: #333;
        }
        .total-summary .value {
            text-align: right;
            font-weight: bold;
            color: #d62828;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<!-- Watermark -->
<div class="watermark"></div>

<div class="invoice-box">

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('website/assets/images/TH-logo.png') }}" alt="Trophy House Logo" class="logo">
        {{-- <div class="invoice-title">Official Invoice</div> --}}
        <div class="company-info">
            GSTIN: 29ABCDE1234F1Z5 | support@trophyhouse.com | +91-9876543210
        </div>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-details">
        <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
        <p><strong>Date:</strong> {{ $payment->created_at->format('d M Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        <p><strong>Customer:</strong> {{ $customer->name ?? 'N/A' }}</p>
        @if(!empty($customer->email))
            <p><strong>Email:</strong> {{ $customer->email }}</p>
        @endif
        @if(!empty($customer->mobile))
            <p><strong>Phone:</strong> {{ $customer->mobile }}</p>
        @endif
        <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_mode ?? 'Online Payment') }}</p>
        @if($payment->transaction_id)
            <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
        @endif
    </div>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Variant</th>
                <th>Qty</th>
                <th>Unit Price </th>
                <th>Base Amount </th>
                <th>GST 18% </th>
                <th>Total </th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalBase = 0;
            $totalGST = 0;
        @endphp
        @foreach($payment->paymentItems as $item)
            @php
                $unitPrice = $item->total_price / $item->quantity;
                $baseAmount = $unitPrice * $item->quantity;
                $gstAmount = $baseAmount * 0.18;
                $totalAmount = $baseAmount + $gstAmount;
                $totalBase += $baseAmount;
                $totalGST += $gstAmount;
            @endphp
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>{{ $item->variant->size ?? 'Standard' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($unitPrice, 2) }}</td>
                <td>{{ number_format($baseAmount, 2) }}</td>
                <td>{{ number_format($gstAmount, 2) }}</td>
                <td>{{ number_format($totalAmount, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Total Summary -->
    <table class="total-summary">
        <tr>
            <td class="label">Total Base Amount</td>
            <td class="value">{{ number_format($totalBase, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Total GST (18%)</td>
            <td class="value">{{ number_format($totalGST, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Grand Total</td>
            <td class="value"><strong>{{ number_format($totalBase + $totalGST, 2) }}</strong></td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Thank you for your purchase!<br>
        This is a computer-generated invoice and does not require a signature.
    </div>

</div>
</body>
</html>
