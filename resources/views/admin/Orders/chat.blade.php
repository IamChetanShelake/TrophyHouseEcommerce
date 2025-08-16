@extends('admin.layouts.masterlayout')

@section('content')
    <h1>Chat for {{ $productItem->product->name ?? 'Product' }}</h1>
    {{-- Back button --}}
    <a href="{{ route('orders.products', $orderId) }}" class="btn btn-dark mb-3"
        style="display:inline-block; width:16%;>
        ← Back to Products
    </a>

    @if ($productItem->messages && $productItem->messages->messages && $productItem->messages->messages->count())
@foreach ($productItem->messages->messages as $msg)
<div style="margin-bottom:
        10px;">
        <strong>
            {{ $msg->user_id ? $msg->user->name : $msg->designer->name ?? 'Designer' }}
        </strong>:
        {{ $msg->message }}
        <small style="color: gray;">{{ $msg->created_at->format('d M Y, h:i A') }}</small>
        </div>
        @endforeach
    @else
        <p>No chat messages for this product.</p>
        @endif
    @endsection
