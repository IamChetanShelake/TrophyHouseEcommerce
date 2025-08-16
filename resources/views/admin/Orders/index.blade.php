@extends('admin.layouts.masterlayout')

@section('content')
    <!-- User Details Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                </div>
                <div class="modal-body" id="user-details">
                    Loading...
                </div>
            </div>
        </div>
    </div>

    <!-- Products Modal -->
    <div class="modal fade" id="productsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Products</h5>
                </div>
                <div class="modal-body" id="product-details">
                    Loading...
                </div>
            </div>
        </div>
    </div>




    <h1>Orders</h1>

    <form method="GET" action="{{ route('orders') }}" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="search order id / customer" />
        <button>Search</button>
    </form>

    @if ($payments->count())
        <table width="100%" border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Items</th>
                    <th>Payment Mode</th>
                    <th>Placed At</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $p)
                    <tr>
                        <td>{{ $p->order_id }}</td>
                        <td>{{ $p->customer_name }}<br>{{ $p->customer_email }}</td>
                        <td>₹{{ number_format($p->amount, 2) }}</td>
                        <td>{{ $p->items->count() }}</td>
                        <td>{{ $p->payment_mode ?? '-' }}</td>
                        <td>{{ $p->updated_at?->format('d M Y, h:i A') ?? $p->created_at?->format('d M Y, h:i A') }}</td>
                        <td>
                            <button class="btn btn-info btn-sm view-user" data-id="{{ $p->order_id }}">View
                                User</button>
                            <a href="{{ route('orders.products', $p->order_id) }}"
                                class="btn btn-primary btn-sm">Products</a>


                                        </td>
                                            <td colspan="2">
                                                <a href="{{route('order.view',$ord->id)}}" class="btn btn-primary">
                                                    <i class="mdi mdi-eye"></i>
                                                </a>
                                            </td>
                                    </tr>
                                @endforeach

                                <!-- Pagination Links -->
                                <div class="mt-3">
                                    {{ $orders->links() }}
                                </div>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>

    {{-- on-change content javascript  --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusColors = {
            'pending': '#ffcf3f',     // Yellow
            'processing': '#00dcff',  // Teal
            'shipped': '#429dff',     // Blue
            'delivered': '#00ff3a',   // Green
            'cancelled': '#ff3649'    // Red
        };

        // Function to set color
        function setColor(select) {
            const color = statusColors[select.value] || '#6c757d'; // Default grey
            select.style.backgroundColor = color;
            select.style.color = 'white';
            select.style.borderRadius = '99px';
            select.style.width = '90px';
        }

        document.querySelectorAll('.status-dropdown').forEach(function (dropdown) {
            setColor(dropdown); // Set initial color on page load

            dropdown.addEventListener('change', function () {
                let orderId = this.getAttribute('data-id');
                let status = this.value;

                setColor(this); // Update color on change

                fetch(`/updateStatus/${orderId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`status-message-${orderId}`).innerHTML =
                        `<span class="text-success">${data.message}</span>`;
                })
                .catch(error => {
                    document.getElementById(`status-message-${orderId}`).innerHTML =
                        `<span class="text-danger">Failed to update.</span>`;
                });
            });
        });
    });
</script>

@endsection
