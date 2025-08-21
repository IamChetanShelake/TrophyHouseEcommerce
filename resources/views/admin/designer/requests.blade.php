@extends('admin.designer.layouts.master')

@section('content')
    <h3 class="mb-4">Customization Requests</h3>
    <table class="table table-bordered ">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Product(s)</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $orderId => $orderRequests)
                @php
                    $firstReq = $orderRequests->first();
                @endphp
                <tr>
                    <td>{{ $firstReq->id }}</td>
                    <td>{{ $orderId }}</td>
                    <td>
                        {{ $orderRequests->count() }} products
                        <br>
                        <button type="button" class="btn btn-info btn-sm mt-1" data-bs-toggle="modal"
                            data-bs-target="#orderModal{{ $orderId }}">
                            View Products
                        </button>
                    </td>
                    <td>{{ ucfirst($firstReq->status) }}</td>
                    <td>
                        @if ($firstReq->status == 'pending')
                            <div style="display: flex; gap: 5px;">
                                <form method="POST" action="{{ route('customization.accept', $orderId) }}"
                                    style="display: inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm" style="white-space: nowrap;">Accept</button>
                                </form>

                                <form method="POST" action="{{ route('customization.reject', $orderId) }}"
                                    style="display: inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" style="white-space: nowrap;">Reject</button>
                                </form>
                            </div>
                        @elseif ($firstReq->status == 'accepted' && $firstReq->designer_id == Auth::id())
                            <a href="{{ route('workspace.order', $orderId) }}" class="btn btn-primary btn-sm">Workspace</a>
                        @else
                            <span class="text-muted">{{ $firstReq->status }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modals should be outside the table --}}
    @foreach ($requests as $orderId => $orderRequests)
        <div class="modal fade" id="orderModal{{ $orderId }}" tabindex="-1"
            aria-labelledby="orderModalLabel{{ $orderId }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel{{ $orderId }}">Products in Order
                            {{ $orderId }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderRequests as $req)
                                    <tr>
                                        <td>{{ $req->paymentItem?->product?->title ?? 'N/A' }}</td>
                                        <td>{{ $req->paymentItem?->quantity ?? 0 }}</td>
                                        <td>{{ $req->description ?? 'N/A' }}</td>
                                        <td>
                                            @if ($req->paymentItem?->product?->title)
                                                <img src="{{ asset('product_images/' . $req->paymentItem->product->image) }}"
                                                    alt="Product Image" style="width:auto; height:70px;border-radius:0px;">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
