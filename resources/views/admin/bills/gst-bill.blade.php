@extends('admin.layouts.masterlayout')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2>GST Bill</h2>
                <h4>Order ID: {{ $payment->order_id }}</h4>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Customer Details:</h5>
                    <p><strong>Name:</strong> {{ $payment->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $payment->customer_email }}</p>
                    <p><strong>Phone:</strong> {{ $payment->customer_phone }}</p>
                    @if($payment->gstin)
                        <p><strong>GSTIN:</strong> {{ $payment->gstin }}</p>
                    @endif
                    @if($payment->hsn_code)
                        <p><strong>HSN Code:</strong> {{ $payment->hsn_code }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    <h5>Order Details:</h5>
                    <p><strong>Order Date:</strong> {{ $payment->created_at->format('d M Y') }}</p>
                    <p><strong>Payment Mode:</strong> {{ $payment->payment_mode }}</p>
                    <p><strong>Status:</strong> {{ $payment->status }}</p>
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
                        <th>Discount</th>
                        <th>GST (18%)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $sr = 1; $subtotal = 0; @endphp
                    @foreach($payment->items as $item)
                        <tr>
                            <td>{{ $sr++ }}</td>
                            <td>{{ $item->product->title ?? 'N/A' }}</td>
                            <td>{{ $item->variant->size ?? 'N/A' }}</td>
                            <td>{{ $item->color ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->unit_price, 2) }}</td>
                            <td>₹{{ number_format(($item->unit_price - $item->total_price/$item->quantity), 2) }}</td>
                            <td>₹{{ number_format(($item->total_price * 0.18), 2) }}</td>
                            <td>₹{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @php $subtotal += $item->total_price; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-end"><strong>Subtotal:</strong></td>
                        <td colspan="2">₹{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-end"><strong>GST (18%):</strong></td>
                        <td colspan="2">₹{{ number_format($subtotal * 0.18, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-end"><strong>Total Amount:</strong></td>
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
    .btn, .card-header, .content-wrapper { display: none !important; }
    body { margin: 0; }
}
</style>
@endsection
