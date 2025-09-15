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
                <h1 class="h3 h2-md mb-4">Orders - {{ ucfirst($status ?? 'All') }}</h1>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-8 col-lg-6 offset-lg-3">
                        <form method="GET" action="{{ route('orders') }}" class="d-flex flex-column flex-sm-row gap-2">
                            <input type="text" name="q" value="{{ request('q') }}"
                                placeholder="🔍 Search order id / customer"
                                class="form-control shadow-sm rounded-pill px-3 border-primary" />

                            <button class="btn btn-primary rounded-pill px-4 shadow-sm flex-shrink-0"
                                style="background: linear-gradient(90deg, #5A3279, #8E44AD); border: none;">
                                Search
                            </button>
                        </form>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 text-start">
                        <a href="{{ route('createorder') }}" class="btn w-100 w-sm-auto"
                            style="background:#ffc107;color:white; font-size:15px;">+
                            New</a>
                    </div>
                </div>

                @if ($payments->count())
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" width="100%" border="1" cellpadding="8"
                            cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th class="d-none d-sm-table-cell">Order ID</th>
                                    <th>Amt.</th>
                                    <th>Items</th>
                                    <th class="d-none d-md-table-cell">Paymt. Mode</th>
                                    <th class="d-none d-lg-table-cell">Products</th>
                                    <th class="d-none d-lg-table-cell">Placed At</th>
                                    <th class="d-none d-xl-table-cell">Delivery Date</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th class="d-none d-md-table-cell">Transfer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $p)
                                    <div class="modal fade" id="transferOrderModal" tabindex="-1"
                                        aria-labelledby="transferOrderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="transferOrderModalLabel">Transfer Order</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ route('admin.orders.transfer', $p->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <div class="input-group input-group-sm">
                                                            <select name="new_designer_id"
                                                                class="form-select form-select-sm" required
                                                                style="min-width: 120px;">
                                                                <option value="">Transfer To</option>
                                                                @foreach ($designers as $designer)
                                                                    <option value="{{ $designer->id }}">
                                                                        {{ $designer->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="button" class="btn btn-warning btn-sm"
                                                                title="Transfer Order" data-bs-toggle="modal"
                                                                data-bs-target="#transferOrderModal">
                                                                <i class="fas fa-exchange-alt"></i> Transfer
                                                            </button>

                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Status Modals -->
                                    @php
                                        $isOffline = str_starts_with($p->order_id, 'THOFF_');
                                        $nextStatus = $isOffline ? 'ready_to_pickup' : 'ready_to_dispatch';
                                        $nextStatusText = $isOffline ? 'Ready to Pickup' : 'Ready to Dispatch';
                                    @endphp

                                    <div class="modal fade" id="statusModal{{ $p->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Delivery Status</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Mark as <b>{{ $nextStatusText }}</b>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">No</button>
                                                    <form action="{{ route('orders.item.delivery_status', $p->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="delivery_status"
                                                            value="{{ $nextStatus }}">
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
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
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
                                        <td class="d-none d-sm-table-cell">{{ $p->order_id }}</td>
                                        <td>₹{{ number_format($p->amount, 2) }}</td>
                                        <td>{{ $p->items->count() }}</td>
                                        <td class="d-none d-md-table-cell">{{ $p->payment_mode ?? '-' }}</td>
                                        <td class="d-none d-lg-table-cell">
                                            {{ optional($p->items)->where('delivery_status', 'approved')->count() ?? 0 }},
                                            {{ optional($p->items)->where('delivery_status', 'ready_to_dispatch')->count() ?? 0 }}
                                        </td>
                                        <td class="d-none d-lg-table-cell">{{ $p->updated_at?->format('d M Y') }}</td>
                                        <td class="d-none d-xl-table-cell">{{ $p->delivery_date ?? 'N/A' }}</td>
                                        {{--  <td>
                                        @if ($p->delivery_status == 'pending')
                                            <span class="badge"
                                                style="background-color: #dcbf00;color: white;
                                         border: none;
                                      font-size: 13px;
                                      border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif($p->delivery_status == 'accepted')
                                            <span class="badge"
                                                style="background-color: #008616;
                                                color: white;
                                                border: none;
                                                font-size: 13px;
                                         border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'approved')
                                            <button class="badge"
                                                style=" background-color: #001cff;
                                            color:white;
                                            border: none;
                                            font-size: 13px;
                                          border-radius: 25px;
                                                    "
                                                data-bs-toggle="modal" data-bs-target="#statusModal{{ $p->id }}">
                                                {{ $p->delivery_status }}
                                            </button>
                                        @elseif ($p->delivery_status == 'ready_to_pickup')

                                            <button class="badge"
                                                style="background-color: #00c264;color:white ;
                                                     border: none;
                                                     font-size: 13px;
                                                     border-radius: 25px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#statusModalDelivered{{ $p->id }}">
                                                Ready To Pick Up
                                            </button>
                                        @elseif ($p->delivery_status == 'delivered')
                                            <span class="badge"
                                                style="background-color: #39c900;color:white ;
                                               border: none;
                                               font-size: 13px;
                                               border-radius: 25px;">{{ $p->delivery_status }}</span>
                                        @elseif ($p->delivery_status == 'cancelled')
                                            <span class="badge"
                                                style="background-color: #d30000;color:white ;
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
                                    </td>  --}}

                                        <td>
                                            @php
                                                $styles = [
                                                    'pending' => 'background-color: #dcbf00; color: white;',
                                                    'accepted' => 'background-color: #008616; color: white;',
                                                    'approved' => 'background-color: #bae6ff; color: #202cff;',
                                                    'ready_to_pickup' => 'background-color: #c1ffc8; color: #0d8e00;',
                                                    'ready_to_dispatch' => 'background-color: #c1ffc8; color: #0d8e00;',
                                                    'dispatched' => 'background-color: #c1ffc8; color: #0d8e00;',
                                                    'delivered' => 'background-color: #dcffe2; color: #00d101;',
                                                    'cancelled' => 'background-color: #ff7777; color: red;',
                                                ];

                                                $defaultStyle = 'background-color: #333; color: #fff;';
                                                $style = $styles[$p->delivery_status] ?? $defaultStyle;
                                            @endphp

                                            @if ($p->delivery_status == 'approved')
                                                <button class="badge"
                                                    style="{{ $style }} border: none; font-size: 13px; border-radius: 25px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#statusModal{{ $p->id }}">
                                                    {{ $p->delivery_status }}
                                                </button>
                                            @elseif ($p->delivery_status == 'ready_to_pickup')
                                                <button class="badge"
                                                    style="{{ $style }} border: none; font-size: 13px; border-radius: 25px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#statusModalDelivered{{ $p->id }}">
                                                    Ready To Pick Up
                                                </button>
                                            @elseif ($p->delivery_status == 'ready_to_dispatch')
                                                <button class="badge"
                                                    style="{{ $style }} border: none; font-size: 13px; border-radius: 25px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#statusModalDelivered{{ $p->id }}">
                                                    Ready To Dispatch
                                                </button>
                                            @else
                                                <span class="badge"
                                                    style="{{ $style }} border: none; font-size: 13px; border-radius: 25px;">
                                                    {{ $p->delivery_status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical btn-group-sm d-block d-sm-inline-block"
                                                role="group">
                                                <button class="btn btn-info btn-sm mb-1 mb-sm-0 me-sm-1 view-user"
                                                    data-id="{{ $p->order_id }}">
                                                    <i class="fa fa-eye"></i> User
                                                </button>
                                                <a class="btn btn-primary btn-sm mb-1 mb-sm-0 me-sm-1 view-products"
                                                    data-id="{{ $p->order_id }}">
                                                    Products
                                                </a>
                                                @if (Auth::user()->role == 1)
                                                    <a href="{{ route('offgenerate.bill', $p->order_id) }}"
                                                        class="btn btn-success btn-sm" target="_blank">Bill</a>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="d-none d-md-table-cell">
                                            @if ($designers && $designers->count() > 0)
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    title="Transfer Order" data-bs-toggle="modal"
                                                    data-bs-target="#transferOrderModal">
                                                    <i class="fas fa-exchange-alt"></i> Transfer
                                                </button>

                                                <div class="mt-1">
                                                    <small class="text-muted">Status: {{ $p->delivery_status }}</small>
                                                </div>
                                            @else
                                                <span class="text-danger small">No designers available</span>
                                            @endif
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

            // Global designers variable
            window.designers = [];

            // Load designers data
            function loadDesigners() {
                return fetch('/admin/designers')
                    .then(res => {
                        if (!res.ok) throw new Error(`HTTP ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        window.designers = data.designers || [];
                    })
                    .catch(err => {
                        console.error('Failed to load designers:', err);
                        window.designers = [];
                    });
            }

            // Load designers on page load
            loadDesigners();

            // Delegation for chat buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('view-chat-btn')) {
                    const productId = e.target.dataset.productId;
                    const productName = e.target.dataset.productName;

                    console.log('Opening chat for product:', productId);

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
                            console.error('Chat load error:', err);
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
                                <p><strong>Profile:</strong> <img src="${user.image || '/default-avatar.png'}"
                                    alt="Profile Image" width="80" height="80" style="border-radius: 50%;"> </p>
                                <p><strong>Name:</strong> ${user.name || 'N/A'}</p>
                                <p><strong>Email:</strong> ${user.email || 'N/A'}</p>
                                <p><strong>Phone:</strong> ${user.phone || 'N/A'}</p>
                            `;
                            new bootstrap.Modal(document.getElementById('userModal')).show();
                        })
                        .catch(err => {
                            console.error('User details error:', err);
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

                    // Show loading in modal
                    document.getElementById('product-details').innerHTML =
                        '<p class="text-center">Loading products...</p>';
                    new bootstrap.Modal(document.getElementById('productsModal')).show();

                    fetch(`/orders/${orderId}/products`)
                        .then(res => {
                            if (!res.ok) throw new Error(`HTTP ${res.status}`);
                            return res.json();
                        })
                        .then(data => {
                            console.log('Products data:', data);

                            if (!data.products || data.products.length === 0) {
                                document.getElementById('product-details').innerHTML =
                                    `<p class="text-muted">No products found for this order.</p>`;
                            } else {
                                let transferOptions =
                                    `<option value="">Select Designer</option>`;
                                if (window.designers && window.designers.length > 0) {
                                    window.designers.forEach(d => {
                                        transferOptions +=
                                            `<option value="${d.id}">${d.name}</option>`;
                                    });
                                } else {
                                    transferOptions =
                                        `<option value="">No designers available</option>`;
                                }

                                let table = `
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-dark">
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
                                        `${p.variant.size || 'N/A'} inch (${p.variant.color || 'N/A'})` :
                                        'N/A';

                                    let designer = p.designer?.name ??
                                        (p.customization_request?.designer?.name ??
                                            'Not Assigned');

                                    let chat = (p.customization_request && p
                                            .customization_request.messages_count > 0) ?
                                        `<button type="button" class="btn btn-info btn-sm view-chat-btn"
                                            data-product-id="${p.id}"
                                            data-product-name="${p.product?.title ?? 'N/A'}">
                                             View Chat
                                        </button>` :
                                        `<span class="text-muted"> No Chat</span>`;

                                    let statusHtml = '';
                                    if (p.customization_request) {
                                        switch (p.customization_request.status) {
                                            case 'accepted':
                                                statusHtml = p.is_approved ?
                                                    `<span class="badge bg-success"><i class="fas fa-check"></i> Approved</span>` :
                                                    `<span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Accepted</span>`;
                                                break;
                                            case 'pending':
                                                statusHtml =
                                                    `<span class="badge bg-secondary"><i class="fas fa-hourglass-half"></i> Pending</span>`;
                                                break;
                                            case 'approved':
                                                statusHtml =
                                                    `<span class="badge bg-success"><i class="fas fa-thumbs-up"></i> Approved</span>`;
                                                break;
                                            case 'completed':
                                                statusHtml =
                                                    `<span class="badge bg-info"><i class="fas fa-check-circle"></i> Completed</span>`;
                                                break;
                                            case 'rejected':
                                                statusHtml =
                                                    `<span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span>`;
                                                break;
                                            default:
                                                statusHtml =
                                                    `<span class="badge bg-light text-dark">${p.customization_request.status || 'Unknown'}</span>`;
                                        }
                                    } else {
                                        statusHtml =
                                            `<span class="badge bg-light text-dark">No Customization</span>`;
                                    }

                                    table += `
                                        <tr>
                                            <td>
                                                <strong>${p.product?.title ?? 'N/A'}</strong>
                                                ${p.product?.id ? `<br><small class="text-muted">ID: ${p.product.id}</small>` : ''}
                                            </td>
                                            <td>${variant}</td>
                                            <td><span class="badge bg-primary">${p.quantity}</span></td>
                                            <td>₹${p.unit_price || 'N/A'}</td>
                                            <td>${designer}</td>
                                            <td>${chat}</td>
                                            <td>${statusHtml}</td>
                                           
                                        </tr>
                                    `;
                                });

                                table += `
                                            </tbody>
                                        </table>
                                    </div>
                                `;

                                document.getElementById('product-details').innerHTML = table;
                            }
                        })
                        .catch(err => {
                            console.error('Products load error:', err);
                            document.getElementById('product-details').innerHTML =
                                `<div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Unable to load product details. Please try again.
                                    <br><small class="text-muted">Error: ${err.message}</small>
                                </div>`;
                        });
                });
            });

        });
    </script>
@endsection
