{{-- @extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: start;
            white-space: break-spaces;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> <a href="{{ route('products') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>View Product </h3>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">


                        @if ($product->image)
                            <td><img src="{{ asset('product_images/' . $product->image) }}" alt=""
                                    style="width: 400px !important;height: 400px !important;border-radius:0px;"></td>
                        @else
                            <td>
                                <p>No Image Available</p>
                            </td>
                        @endif

                    </div>

                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">
                        <table class="table">
                            <tbody>

                                <tr>
                                    <td> <b> Name :- </b></td>
                                    <td>{{ $product->title }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Description :-</b></td>
                                    <td>{{ $product->description }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Category :-</b></td>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Sub-Category :-</b></td>
                                    <td>{{ $product->subcategory->title }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Old Price (Rs) :-</b></td>
                                    <td>{{ $product->price }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Discount (%) :-</b></td>
                                    <td>{{ $product->discount_percentage }}</td>
                                </tr>
                                <tr>
                                    <td> <b> New Price (Rs) :-</b></td>
                                    <td>{{ $product->new_price }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Rating :-</b></td>
                                    <td>{{ $product->rating }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Top Pick :-</b></td>
                                    <td>
                                        @if ($product->is_top_pick)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Best Seller :-</b></td>
                                    <td>
                                        @if ($product->is_best_seller)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> New Arrival :-</b></td>
                                    <td>
                                        @if ($product->is_new_arrival)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ route('products') }}" class="btn btn-dark">Back</a>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection --}}


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
            <h3 class="page-title"><a href="{{ route('products') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>View Product </h3>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">


                        @if ($product->image)
                            <td><img src="{{ asset('product_images/' . $product->image) }}" alt=""
                                    style="width: 400px !important;height: 400px !important;border-radius:0px;"></td>
                        @else
                            <td>
                                <p>No Image Available</p>
                            </td>
                        @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">


                        <table class="table">
                            <tbody>



                                <tr>
                                    <td> <b> Name :- </b></td>
                                    <td>{{ $product->title }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Description :-</b></td>
                                    <td>{{ $product->description }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Category :-</b></td>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Sub-Category :-</b></td>
                                    <td>{{ $product->subcategory->title }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Old Price (Rs) :-</b></td>
                                    <td>{{ $product->price }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Discount (%) :-</b></td>
                                    <td>{{ $product->discount_percentage }}</td>
                                </tr>
                                <tr>
                                    <td> <b> New Price (Rs) :-</b></td>
                                    <td>{{ $product->new_price }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Rating :-</b></td>
                                    <td>{{ $product->rating }}</td>
                                </tr>
                                <tr>
                                    <td> <b> Top Pick :-</b></td>
                                    <td>
                                        @if ($product->is_top_pick)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> Best Seller :-</b></td>
                                    <td>
                                        @if ($product->is_best_seller)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b> New Arrival :-</b></td>
                                    <td>
                                        @if ($product->is_new_arrival)
                                            <p>Yes</p>
                                        @else
                                            <p>--</p>
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ route('products') }}" class="btn btn-dark">Back</a>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
