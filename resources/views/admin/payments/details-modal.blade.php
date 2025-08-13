<div class="payment-details">
    <div class="row">
        <div class="col-md-6">
            <h6 class="text-muted mb-3">Payment Information</h6>
            <table class="table table-sm">
                <tr>
                    <td><strong>Order ID:</strong></td>
                    <td>{{ $payment->order_id }}</td>
                </tr>
                <tr>
                    <td><strong>Cashfree Order ID:</strong></td>
                    <td>{{ $payment->cf_order_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Amount:</strong></td>
                    <td><strong class="text-success">₹{{ number_format($payment->amount, 2) }}</strong></td>
                </tr>
                <tr>
                    <td><strong>Currency:</strong></td>
                    <td>{{ $payment->currency }}</td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>
                        <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Payment Method:</strong></td>
                    <td>{{ $payment->payment_mode ? strtoupper($payment->payment_mode) : 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Transaction ID:</strong></td>
                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted mb-3">Customer Information</h6>
            <table class="table table-sm">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td>{{ $payment->customer_name }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $payment->customer_email }}</td>
                </tr>
                <tr>
                    <td><strong>Phone:</strong></td>
                    <td>{{ $payment->customer_phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Customer ID:</strong></td>
                    <td>{{ $payment->customer_id }}</td>
                </tr>
                <tr>
                    <td><strong>Created At:</strong></td>
                    <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                <tr>
                    <td><strong>Updated At:</strong></td>
                    <td>{{ $payment->updated_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>

    @if($payment->paymentItems && $payment->paymentItems->count() > 0)
        <hr>
        <h6 class="text-muted mb-3">Purchased Items</h6>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Variant</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment->paymentItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('product_images/' . $item->product->image) }}" 
                                         alt="{{ $item->product->title }}" 
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                    <div>
                                        <strong>{{ $item->product->title }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($item->variant)
                                    {{ $item->variant->size ?? 'Standard' }}
                                @else
                                    Standard
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->unit_price, 2) }}</td>
                            <td><strong>₹{{ number_format($item->total_price, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total:</th>
                        <th>₹{{ number_format($payment->paymentItems->sum('total_price'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No items found for this payment.
        </div>
    @endif
</div>