@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>Bill</h2>
                    {{--  <h4>Order ID: {{ $payment->order_id }}</h4>  --}}
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Customer Details:</h4>
                        <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                        <p><strong>Name:</strong> {{ $payment->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $payment->customer_email }}</p>
                        <p><strong>Phone:</strong> {{ $payment->customer_phone }}</p>
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
                        <p><strong>Email:</strong>
                            trophyhousensk1@gmail.com</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            {{--  <th>Discount</th>  --}}
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
                                <td>{{ $item->product->title ?? 'N/A' }}</td>
                                <td>{{ $item->variant->size ?? 'N/A' }}</td>
                                <td>{{ $item->color ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                                {{--  <td>₹{{ number_format(($item->unit_price - $item->total_price/$item->quantity), 2) }}</td>  --}}
                                <td>₹{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @php $subtotal += $item->total_price; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-end"><strong>Subtotal:</strong></td>
                            <td colspan="2">₹{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end"><strong>Printing Charges:</strong></td>
                            <td colspan="2">₹{{ number_format($payment->making_charges, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end"><strong>Total Amount:</strong></td>
                            <td colspan="2"><strong>₹{{ number_format($payment->amount, 2) }}</strong></td>
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

            .btn,
            .card-header,
            .content-wrapper {
                display: none !important;
            }

            body {
                margin: 0;
            }
        }
    </style>
@endsection
