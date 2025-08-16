@extends('admin.layouts.masterlayout')

@section('content')
    {{-- Back button --}}
    <a href="{{ route('orders', $orderId) }}" class="btn btn-dark mb-3" style="display:inline-block; width:16%; ">
        ← Back to Orders
    </a>
    <h1>Products in Order {{ $orderId }}</h1>
    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Variant</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Designer</th>
                <th>Chat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
                <tr>
                    <td>{{ $p->product->title ?? 'N/A' }}</td>
                    <td>{{ $p->variant ? $p->variant->size . ' (' . $p->variant->color . ')' : 'N/A' }}</td>
                    <td>{{ $p->quantity }}</td>
                    <td>{{ $p->unit_price }}</td>
                    <td>{{ $p->designer->name ?? 'Not Assigned' }}</td>
                    <td>
                        @if ($p->customizationRequest && $p->customizationRequest->messages->count() > 0)
                            <a href="javascript:void(0);" class="btn btn-info btn-sm view-chat-btn"
                                data-product-id="{{ $p->id }}" data-product-name="{{ $p->product->title }}">
                                View Chat
                            </a>
                        @else
                            <span class="text-muted">No Chat</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatButtons = document.querySelectorAll('.view-chat-btn');

            chatButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const productName = this.dataset.productName;

                    // Update modal title with product name
                    document.getElementById("chatModalLabel").innerText = "Chat for Product - " +
                        productName;


                    // Show modal
                    const chatModal = new bootstrap.Modal(document.getElementById('chatModal'));
                    chatModal.show();

                    // Show loading
                    document.getElementById('chatModalBody').innerHTML =
                        '<p class="text-center">Loading...</p>';

                    // Fetch chat via AJAX
                    fetch(`/admin/orders/product/${productId}/chat`)
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('chatModalBody').innerHTML = html;
                        })
                        .catch(err => {
                            document.getElementById('chatModalBody').innerHTML =
                                '<p class="text-danger">Failed to load chat.</p>';
                        });
                });
            });
        });
    </script>
@endsection
