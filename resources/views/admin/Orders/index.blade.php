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

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $payments->links() }}
    @else
        <p>No paid orders yet.</p>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // View User Details
            document.querySelectorAll('.view-user').forEach(btn => {
                btn.addEventListener('click', function() {
                    let orderId = this.getAttribute('data-id');
                    fetch(`/orders/user/${orderId}`)
                        .then(res => {
                            if (!res.ok) throw new Error(`HTTP ${res.status}`);
                            return res.json();
                        })
                        .then(user => {
                            document.getElementById('user-details').innerHTML = `
            <p><strong>Name:</strong> ${user.name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Phone:</strong> ${user.phone ?? 'N/A'}</p>
        `;
                            new bootstrap.Modal(document.getElementById('userModal')).show();
                        })
                        .catch(err => {
                            console.error('Fetch error:', err);
                            document.getElementById('user-details').innerHTML =
                                `<p style="color:red;">Unable to load user details.</p>`;
                            new bootstrap.Modal(document.getElementById('userModal')).show();
                        });

                });
            });
        });
    </script>


@endsection
