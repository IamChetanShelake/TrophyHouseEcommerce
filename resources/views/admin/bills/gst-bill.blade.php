@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>Bill</h2>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mt-2">
                        <h4>Customer Details:</h4>
                        <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                        <p><strong>Name:</strong> {{ $payment->customer_name }}</p>
                        @isset($payment->customer_email)
                            <p><strong>Email:</strong> {{ $payment->customer_email }}</p>
                        @endisset
                        <p><strong>Phone:</strong> {{ $payment->customer_phone }}</p>
                        @if ($payment->gstin)
                            <p><strong>GSTIN:</strong> {{ $payment->gstin }}</p>
                        @endif
                        @if ($payment->hsn_code)
                            <p><strong>HSN Code:</strong> {{ $payment->hsn_code }}</p>
                        @endif
                        <p><strong>Order Date:</strong> {{ $payment->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <img src="{{ asset('admin/assets/images/trophy house logo.png') }}" alt="logo">
                        <p><b>
                                Space cosmos, old Mumbai Agra Road,<br> Beside Canara Bank, opp. Meher Bus Stop,<br> Ashok
                                Stambh,
                                Nashik 422002
                            </b></p>
                        <p><strong>Phone:</strong> 9423962242, 9423962042, 9404076742</p>
                        <p><strong>Email:</strong> trophyhousensk1@gmail.com</p>
                        <p><strong>GSTIN:</strong> 22AAAAA0000A1Z5</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>GST (18%)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sr = 1;
                            $subtotal = 0;
                        @endphp
                        @foreach ($payment->items as $item)
                            <tr>
                                <td>{{ $sr++ }}</td>
                                <td> <img src="{{ asset('product_images/' . $item->product->image) }}" alt="Image"></td>
                                <td>{{ $item->product->title ?? 'N/A' }}</td>
                                <td>{{ $item->variant->size ?? 'N/A' }}</td>
                                <td>{{ $item->color ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                <td>₹{{ number_format($item->total_price * 0.18, 2) }}</td>
                                <td>₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @php $subtotal += $item->total_price; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-end"><strong>Subtotal:</strong></td>
                            <td>₹{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-end"><strong>Printing Charges:</strong></td>
                            <td>₹{{ number_format($payment->making_charges, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-end"><strong>GST (18%):</strong></td>
                            <td>₹{{ number_format($subtotal * 0.18, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-end"><strong>Total Amount:</strong></td>
                            <td><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-center mt-4">
                    <button onclick="window.print()" class="btn btn-primary">Print Bill</button>
                    <a href="{{ route('orders') }}" class="btn btn-secondary">Back to Orders</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            /* Hide everything by default */
            body * {
                visibility: hidden;
            }

            /* Show only the content-wrapper and its children */
            .content-wrapper,
            .content-wrapper * {
                visibility: visible;
            }

            /* Ensure content-wrapper takes full width and is positioned correctly */
            .content-wrapper {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                margin: 0;
                padding: 10px;
            }

            /* Hide buttons inside content-wrapper during print */
            .content-wrapper .btn {
                display: none !important;
            }

            /* Ensure the row with customer and company details stays on one line */
            .row.mb-4 {
                display: flex;
                flex-wrap: nowrap;
                width: 100%;
                margin: 0;
            }

            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
                padding: 0 10px;
                box-sizing: border-box;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Ensure the table and text are formatted nicely */
            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th,
            .table td {
                border: 1px solid #000;
                padding: 8px;
            }

            /* Ensure logo fits within the column */
            .col-md-6 img {
                max-width: 100%;
                height: auto;
            }

            /* Optional: Adjust font sizes or other styles for print */
            body {
                margin: 0;
                font-size: 12pt;
            }
        }
    </style>
@endsection
