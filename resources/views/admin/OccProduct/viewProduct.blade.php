@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: start;
        }

        .image-thumb {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <a href="{{ route('occproducts') }}" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="Back">
                </a>
                View Occasion Product
            </h3>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-lg-6 col-sm-12">
                        @if ($product->image)
                            <img src="{{ asset('OccasionalProduct_images/' . $product->image) }}" class="img-fluid"
                                style="width:50%; object-fit:cover; border-radius: 8px;">
                        @else
                            <p>No Main Image Available</p>
                        @endif
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><b>Title:</b></td>
                                    <td>{{ $product->title }}</td>
                                </tr>
                                <tr>
                                    <td><b>Description:</b></td>
                                    <td>{!! $product->description !!}</td>
                                </tr>
                                <tr>
                                    <td><b>For Occasion:</b></td>
                                    <td>{{ $product->occasion->title ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Category:</b></td>
                                    <td>{{ $product->category->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Subcategory:</b></td>
                                    <td>{{ $product->subcategory->title ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td><b>Rating:</b></td>
                                    <td>{{ $product->rating ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Variants --}}
                <h5 class="mb-3"><b>Variants</b></h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Discount (%)</th>
                                <th>Final Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->variants as $variant)
                                <tr>
                                    <td>{{ $variant->size }} - inch</td>
                                    <td>₹{{ number_format($variant->price, 2) }}</td>
                                    <td>{{ $variant->discount_percentage ?? 0 }}%</td>
                                    <td>₹{{ number_format($variant->discounted_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Colors --}}
                <h5 class="mb-3"><b>Available Colors</b></h5>
                @php
                    $colors = json_decode($product->variants->first()->color ?? '[]', true);
                @endphp
                @if (!empty($colors))
                    <ul class="list-inline">
                        @foreach ($colors as $color)
                            <li class="list-inline-item badge text-black p-2 m-1" style="border: 1px solid black; ">
                                {{ $color }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No colors assigned.</p>
                @endif

                {{-- Additional Images --}}
                <h5 class="mb-3"><b>Additional Images</b></h5>
                <div class="row">
                    @forelse ($product->images as $img)
                        <div class="col-md-3 col-6 mb-3">
                            <img src="{{ asset('OccasionalProduct_images/' . $img->image) }}" style="height:150px;"
                                class="">
                        </div>
                    @empty
                        <p class="ms-3">No additional images found.</p>
                    @endforelse
                </div>

                <a href="{{ route('occproducts') }}" class="btn btn-dark mt-3">Back</a>
            </div>
        </div>
    </div>
@endsection
