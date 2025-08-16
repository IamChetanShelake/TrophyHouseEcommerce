@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Orders Table </h3>
            <div><a href="{{ route('createorder') }}" class="btn" style="background:#ffc107;color:white; font-size:21px;">+
                    New</a></div>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        </p>
                        <div>

                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>SubTotal </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $ord)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $ord->product->title }}</td>
                                        <td>{{ $ord->product->new_price }}</td>
                                        <td>{{ $ord->quantity }}</td>
                                        <td>{{ $ord->total_amount }}</td>
                                        <td>
                                            <select name="status" class="form-control status-dropdown"
                                                data-id="{{ $ord->id }}">
                                                <option value="pending" {{ $ord->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="processing"
                                                    {{ $ord->status == 'processing' ? 'selected' : '' }}>Processing
                                                </option>
                                                <option value="shipped" {{ $ord->status == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="delivered"
                                                    {{ $ord->status == 'delivered' ? 'selected' : '' }}>Delivered
                                                </option>
                                                <option value="cancelled"
                                                    {{ $ord->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                </option>
                                            </select>

                                            <div id="status-message-{{ $ord->id }}"></div>


                                        </td>
                                        <td colspan="2">
                                            <a href="{{ route('order.view', $ord->id) }}" class="btn btn-primary">
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
        document.addEventListener('DOMContentLoaded', function() {
            const statusColors = {
                'pending': '#ffcf3f', // Yellow
                'processing': '#00dcff', // Teal
                'shipped': '#429dff', // Blue
                'delivered': '#00ff3a', // Green
                'cancelled': '#ff3649' // Red
            };

            // Function to set color
            function setColor(select) {
                const color = statusColors[select.value] || '#6c757d'; // Default grey
                select.style.backgroundColor = color;
                select.style.color = 'white';
                select.style.borderRadius = '99px';
                select.style.width = '90px';
            }

            document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
                setColor(dropdown); // Set initial color on page load

                dropdown.addEventListener('change', function() {
                    let orderId = this.getAttribute('data-id');
                    let status = this.value;

                    setColor(this); // Update color on change

                    fetch(`/updateStatus/${orderId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: status
                            })
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
