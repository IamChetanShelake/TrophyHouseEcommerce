@extends('admin.layouts.masterlayout')

@section('content')

    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalLabel">Product Chat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="chatModalBody">
                    <p class="text-center">Loading...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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

    <div class="content-wrapper">
        <div class="card" style="padding: 20px;">
            <div class="card-body">

                {{--  <h1>Orders</h1>  --}}
                <h1>Orders - {{ ucfirst($status ?? 'All') }}</h1>

                <div class="row">
                    <div class="col-lg-6 offset-lg-4">
                        <form method="GET" action="{{ route('orders') }}" class="d-flex mb-3">
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="🔍 Search order id / customer"
                                class="form-control me-2 shadow-sm rounded-pill px-3 border-primary" />

                            <button class="btn btn-primary rounded-pill px-4 shadow-sm"
                                style="background: linear-gradient(90deg, #5A3279, #8E44AD); border: none;">
                                Search
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-2 text-start">
                        <a href="{{ route('createorder') }}" class="btn"
                            style="background:#ffc107;color:white; font-size:15px;">+
                            New</a>
                    </div>
                </div>

                @if ($payments->count())
                    <table class="table table-bordered text-center" width="100%" border="1" cellpadding="8"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
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
                                <!-- Status Modals -->
                                <div class="modal fade" id="statusModal{{ $p->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Delivery Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Mark as <b>Ready to Pickup</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">No</button>
                                                <form action="{{ route('orders.item.delivery_status', $p->id) }}"
                                                    method="POST">
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
                                                Mark as <b>Delivered</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">No</button>
                                                <form action="{{ route('orders.item.delivery_status', $p->id) }}"
                                                    method="POST">
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
                                    <td>₹{{ number_format($p->amount, 2) }}</td>
                                    <td>{{ $p->items->count() }}</td>
                                    <td>{{ $p->payment_mode ?? '-' }}</td>
                                    <td>{{ $p->updated_at?->format('d M Y') }}</td>
                                    <td>
                                        @if ($p->delivery_status == 'pending')
                                            <span class="badge"
                                                style="background-color: #dcbf00;color: #c2d400;
    border: none;
    font-size: 13px;
    border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif($p->delivery_status == 'accepted')
                                            <span class="badge"
                                                style="background-color: #008616;
                                                color: #00d720;
    border: none;
    font-size: 13px;
    border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'approved')
                                            <button class="badge"
                                                style=" background-color: #c9ddff;
    color: #001cff;
    border: none;
    font-size: 13px;
    border-radius: 25px;
"
                                                data-bs-toggle="modal" data-bs-target="#statusModal{{ $p->id }}">
                                                {{ $p->delivery_status }}
                                            </button>
                                        @elseif ($p->delivery_status == 'ready_to_pickup')
                                            {{-- <span class="badge"
                                                style="background-color: #a4ffae;color: #00c264;
    border: none;
    font-size: 13px;
    border-radius: 25px;">{{ $p->delivery_status }}</span> --}}
                                            <button class="badge"
                                                style="background-color: #a4ffae;color: #00c264;
    border: none;
    font-size: 13px;
    border-radius: 25px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModalDelivered{{ $p->id }}">
                                                Ready To Pick Up
                                            </button>
                                        @elseif ($p->delivery_status == 'delivered')
                                            <span class="badge"
                                                style="background-color: #89ff9c;color: #39c900;
    border: none;
    font-size: 13px;
    border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'cancelled')
                                            <span class="badge"
                                                style="background-color: #ff7777;color: #d30000;
    border: none;
    font-size: 13px;
    border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @else
                                            <span class="badge bg-dark">pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($p->delivery_status == 'pending')
                                            <span class="badge"
                                                style="background-color: #dcbf00">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'accepted')
                                            <span class="badge"
                                                style="background-color: #008616">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'approved')
                                            <button class="badge" style="background-color: #003fab"
                                                data-bs-toggle="modal" data-bs-target="#statusModal{{ $p->id }}">
                                                {{ $p->delivery_status }}
                                            </button>
                                        @elseif ($p->delivery_status == 'ready_to_pickup')
                                            <button class="badge" style="background-color: #00a4b0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModalDelivered{{ $p->id }}">
                                                Ready To Pick Up
                                            </button>
                                        @elseif ($p->delivery_status == 'delivered')
                                            <span class="badge"
                                                style="background-color: #00ff2a">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'cancelled')
                                            <span class="badge"
                                                style="background-color: #b40000">{{ $p->delivery_status }}</span>
                                        @else
                                            <span class="badge bg-dark">pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-info btn-sm view-user" data-id="{{ $p->order_id }}">
                                            <i class="fa fa-eye"></i> User
                                        </button>
                                        <a class="btn btn-primary btn-sm view-products" data-id="{{ $p->order_id }}">
                                            Products
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No paid orders yet.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Delegation for chat buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('view-chat-btn')) {
                    const productId = e.target.dataset.productId;
                    const productName = e.target.dataset.productName;

                    console.log(productId);

                    // Close products modal first
                    const productsModalEl = document.getElementById('productsModal');
                    const productsModal = bootstrap.Modal.getInstance(productsModalEl);
                    if (productsModal) productsModal.hide();

                    // Open chat modal
                    document.getElementById("chatModalLabel").innerText = "Chat for Product - " +
                        productName;

                    const chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
                    chatModal.show();

                    document.getElementById('chatModalBody').innerHTML =
                        '<p class="text-center">Loading...</p>';

                    fetch(`/admin/orders/product/${productId}/chat`)
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('chatModalBody').innerHTML = html;
                        })
                        .catch(err => {
                            document.getElementById('chatModalBody').innerHTML =
                                '<p class="text-danger">Failed to load chat.</p>';
                        });
                }
            });

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
                                <p><strong>Profile:</strong> <img src=" ${user . image}"
         alt="Profile Image"
         width="80" height="80"> </p>
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

            // Products Modal
            document.querySelectorAll('.view-products').forEach(btn => {
                btn.addEventListener('click', function() {
                    let orderId = this.getAttribute('data-id');

                    fetch(`/orders/${orderId}/products`)
                        .then(res => {
                            if (!res.ok) throw new Error(`HTTP ${res.status}`);
                            return res.json();
                        })
                        .then(data => {
                            if (!data.products || data.products.length === 0) {
                                document.getElementById('product-details').innerHTML =
                                    `<p class="text-muted">No products found for this order.</p>`;
                            } else {
                                let table = `
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Variant</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Designer</th>
                                                <th>Chat</th>
                                                <th>Customization Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                `;

                                data.products.forEach(p => {
                                    let variant = p.variant ?
                                        `${p.variant.size} inch (${p.variant.color})` :
                                        'N/A';
                                    let designer = p.designer?.name ?? (p
                                        .customization_request?.designer?.name ??
                                        'Not Assigned');

                                    let chat = (p.customization_request && p
                                            .customization_request.messages_count > 0) ?
                                        `<button type="button" class="btn btn-info btn-sm view-chat-btn"
                                            data-product-id="${p.id}"
                                            data-product-name="${p.product?.title ?? 'N/A'}">View Chat</button>` :
                                        `<span class="text-muted">No Chat</span>`;

                                    let statusHtml = '';
                                    if (p.customization_request) {
                                        switch (p.customization_request.status) {
                                            case 'accepted':
                                                statusHtml = p.is_approved ?
                                                    `<span class="badge bg-success">Approved</span>` :
                                                    `<span class="badge bg-warning text-dark">Accepted</span>`;
                                                break;
                                            case 'pending':
                                                statusHtml =
                                                    `<span class="badge bg-secondary">Pending</span>`;
                                                break;
                                            case 'approved':
                                                statusHtml =
                                                    `<span class="badge bg-success">Approved</span>`;
                                                break;
                                            case 'completed':
                                                statusHtml =
                                                    `<span class="badge bg-info">Completed</span>`;
                                                break;
                                            case 'rejected':
                                                statusHtml =
                                                    `<span class="badge bg-danger">Rejected</span>`;
                                                break;
                                        }
                                    }

                                    table += `
                                        <tr>
                                            <td>${p.product?.title ?? 'N/A'}</td>
                                            <td>${variant}</td>
                                            <td>${p.quantity}</td>
                                            <td>${p.unit_price}</td>
                                            <td>${designer}</td>
                                            <td>${chat}</td>
                                            <td>${statusHtml}</td>
                                        </tr>
                                    `;
                                });

                                table += `</tbody></table>`;
                                document.getElementById('product-details').innerHTML = table;
                            }

                            new bootstrap.Modal(document.getElementById('productsModal'))
                                .show();
                        })
                        .catch(err => {
                            console.error('Fetch error:', err);
                            document.getElementById('product-details').innerHTML =
                                `<p style="color:red;">Unable to load product details.</p>`;
                            new bootstrap.Modal(document.getElementById('productsModal'))
                                .show();
                        });
                });
            });

        });
    </script>
@endsection
