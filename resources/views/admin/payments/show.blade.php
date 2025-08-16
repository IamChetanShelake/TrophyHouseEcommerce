@extends('admin.layouts.masterlayout')

@section('content')
<h1>Order: {{ $payment->order_id }}</h1>

<h3>Customer</h3>
<div>
  <strong>{{ $payment->customer_name }}</strong><br>
  {{ $payment->customer_email }} | {{ $payment->customer_phone }}
</div>

<h3>Items</h3>
@foreach($payment->items as $item)
  <div style="border:1px solid #ddd;margin:10px 0;padding:10px;">
    <div><strong>{{ $item->product?->title ?? 'Product #' . $item->product_id }}</strong></div>
    <div>Variant: {{ $item->variant?->size ?? '-' }} / {{ $item->variant?->color ?? '-' }}</div>
    <div>Qty: {{ $item->quantity }} | Price: ₹{{ number_format($item->unit_price,2) }}</div>
    <div>Designer: {{ $item->designer?->name ?? '-' }}</div>

    <div style="margin-top:8px;">
      <strong>Customization Status:</strong>
      {{ $item->customizationRequest?->status ?? 'N/A' }}
    </div>

    <div style="margin-top:8px;">
      <strong>Delivery status:</strong> {{ $item->delivery_status ?? 'pending' }}
      <form method="POST" action="{{ route('admin.orders.item.delivery_status', $item) }}" style="display:inline;">
        @csrf
        @method('PATCH')
        <select name="delivery_status">
          <option value="pending" {{ ($item->delivery_status ?? 'pending') == 'pending' ? 'selected' : '' }}>pending</option>
          <option value="ready_to_pickup" {{ ($item->delivery_status ?? '') == 'ready_to_pickup' ? 'selected' : '' }}>ready_to_pickup</option>
          <option value="delivered" {{ ($item->delivery_status ?? '') == 'delivered' ? 'selected' : '' }}>delivered</option>
        </select>
        <button type="submit">Update</button>
      </form>
    </div>

    {{-- Chat (only if customization exists) --}}
    @if($item->customizationRequest)
      <details style="margin-top:10px;">
        <summary>Designer ↔ Customer Chat ({{ $item->customizationRequest->messages->count() }})</summary>
        <div style="max-height:250px;overflow:auto;padding:8px;">
          @foreach($item->customizationRequest->messages as $msg)
            <div style="border-bottom:1px solid #eee;padding:6px 4px;">
              <small>{{ $msg->sent_at ?? $msg->created_at }} — <strong>{{ $msg->sender?->name }}</strong></small>
              <div>{!! nl2br(e($msg->message)) !!}</div>
              @if($msg->attachment)
                <div><a href="{{ asset('storage/'.$msg->attachment) }}" target="_blank">Attachment</a></div>
              @endif
            </div>
          @endforeach
        </div>
      </details>
    @endif
  </div>
@endforeach

@endsection
