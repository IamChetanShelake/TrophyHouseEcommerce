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
    <div>
        <a href="{{ route('createorder') }}" class="btn" style="background:#ffc107;color:white; font-size:21px;">+
            New</a>
    </div>

    <form method="GET" action="{{ route('orders') }}" style="margin-bottom:12px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="search order id / customer" />
        <button>Search</button>
    </form>

    @if ($payments->count())
        <table width="100%" border="1" cellpadding="8" cellspacing="0" class="text-center">
            <thead>
                <tr>
                    <th>Order ID</th>
                    {{-- <th>Customer</th> --}}
                    <th>Amt.</th>
                    <th>Items</th>
                    <th>Paymt. Mode</th>
                    <th>Placed At</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $p)
                    <!-- Status Modal -->
                    <div class="modal fade" id="statusModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Update Delivery Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    Are you sure you want to mark this order as <b>Ready to Pickup</b>?
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                                    <form action="{{ route('orders.item.delivery_status', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="delivery_status" value="ready_to_pickup">
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="statusModalDelivered{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Delivery Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to mark this order as <b>Delivered</b>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                    <form action="{{ route('orders.item.delivery_status', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="delivery_status" value="delivered">
                                        <button type="submit" class="btn btn-primary">Yes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <tr>
                        <td>{{ $p->order_id }}</td>
                        {{-- <td>{{ $p->customer_name }}<br>{{ $p->customer_email }}</td> --}}
                        <td>₹{{ number_format($p->amount, 2) }}</td>
                        <td>{{ $p->items->count() }}</td>
                        <td>{{ $p->payment_mode ?? '-' }}</td>
                        <td>{{ $p->updated_at?->format('d M Y') ?? $p->created_at?->format('d M Y') }}</td>
                        {{-- <td>{{ $p->updated_at?->format('d M Y, h:i A') ?? $p->created_at?->format('d M Y, h:i A') }}</td> --}}
                        <td>
                            @if ($p->order_status == 'pending')
                                <span class="badge" style="background-color: #dcbf00">{{ $p->order_status }}</span>
                            @elseif($p->order_status == 'accepted')
                                <span class="badge" style="background-color: #008616">{{ $p->order_status }}</span>
                            @elseif ($p->order_status == 'approved')
                                @if ($p->delivery_status === null)
                                    <button class="badge" style="background-color: #003fab" data-bs-toggle="modal"
                                        data-bs-target="#statusModal{{ $p->id }}">
                                        {{ $p->order_status }}
                                    </button>
                                @elseif ($p->delivery_status == 'ready_to_pickup')
                                    {{-- <span class="badge" style="background-color: #a4ffae">{{ $p->delivery_status }}</span> --}}
                                    <!-- Delivered Modal Button -->
                                    <button class="badge" style="background-color: #00a4b0" data-bs-toggle="modal"
                                        data-bs-target="#statusModalDelivered{{ $p->id }}">
                                        Ready To Pick Up
                                    </button>
                                @elseif ($p->delivery_status == 'delivered')
                                    <span class="badge" style="background-color: #00ff2a">{{ $p->delivery_status }}</span>
                                @elseif ($p->delivery_status == 'cancelled')
                                    <span class="badge" style="background-color: #b40000">{{ $p->delivery_status }}</span>
                                @endif
                            @else
                                <span class="badge bg-dark">{{ $p->order_status }}</span>
                            @endif
                        </td>

                        <td>
                            <button class="btn btn-info btn-sm view-user" data-id="{{ $p->order_id }}">
                                <i class="fa fa-eye"></i> User
                            </button>
                            <a href="{{ route('orders.products', $p->order_id) }}" class="btn btn-primary btn-sm">
                                Products
                            </a>
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
