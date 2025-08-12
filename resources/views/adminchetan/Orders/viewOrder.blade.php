@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: start;

        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{ route('orders') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>Order Details </h3>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">

                        <table class="table table-hover">
                            <tr>
                                <th class="text-center" colspan="2">Product Details</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td><b>Product Image :- </b></td>
                                    <td>
                                        @if ($order->product->image)
                                            <img src="{{ asset('product_images/' . $order->product->image) }}"
                                                alt=""
                                                style="width: 150px !important;height: 150px !important;height: auto;border-radius:0px;">
                                        @else
                                            <p>No Image Available</p>
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Product Name :- </b></td>
                                    <td>{{ $order->product->title }}</td>

                                </tr>
                                <tr>
                                    <td><b>Product Description :-</b></td>
                                    <td>{{ $order->product->description }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center" colspan="2">User Details</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td><b>User Name :- </b></td>
                                    <td>
                                        {{ $order->user->name }}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>User email :- </b></td>
                                    <td>{{ $order->user->email }}</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>

                     <div class="col-lg-12 col-sm-12 grid-margin stretch-card">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center" colspan="2">Order Details</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td><b>User Name :- </b></td>
                                    <td>
                                        {{ $order->user->name }}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>User email :- </b></td>
                                    <td>{{ $order->user->email }}</td>

                                </tr>

                            </tbody>
                        </table>
                     </div>
                </div>
                <a href="{{ route('orders') }}" class="btn btn-dark">Back</a>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
