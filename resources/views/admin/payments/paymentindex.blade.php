@extends('admin.layouts.masterlayout')

@section('content')
<h1>Paid Orders</h1>

<form method="GET" action="{{ route('admin.orders.index') }}" style="margin-bottom:12px;">
  <input type="text" name="q" value="{{ request('q') }}" placeholder="search order id / customer" />
  <button>Search</button>
</form>

@if($payments->count())
<table width="100%" border="1" cellpadding="8" cellspacing="0">
  <thead>
    <tr>
      <th>Order</th>
      <th>Customer</th>
      <th>Amount</th>
      <th>Items</th>
      <th>Payment Mode</th>
      <th>Placed At</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($payments as $p)
    <tr>
      <td>{{ $p->order_id }}</td>
      <td>{{ $p->customer_name }}<br>{{ $p->customer_email }}</td>
      <td>₹{{ number_format($p->amount,2) }}</td>
      <td>{{ $p->items->count() }}</td>
      <td>{{ $p->payment_mode ?? '-' }}</td>
      <td>{{ $p->updated_at?->format('d M Y, h:i A') ?? $p->created_at?->format('d M Y, h:i A') }}</td>
      <td><a href="{{ route('admin.orders.show', $p) }}">View</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $payments->links() }}
@else
  <p>No paid orders yet.</p>
@endif
@endsection
