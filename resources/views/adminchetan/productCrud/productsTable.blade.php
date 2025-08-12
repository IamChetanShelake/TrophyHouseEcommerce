@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Product Tables </h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('product.add') }}" class="btn btn-gradient-primary me-2">Add Product</a>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <table class="table">
                            @if (session('error'))
                                <div id="failMessage" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div id="successMessage" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    setTimeout(function() {
                                        $("#successMessage, #failMessage").fadeOut('slow');
                                    }, 3000); // 3 seconds
                                });
                            </script>
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Top Pick</th>
                                    <th>Best Seller</th>
                                    <th>New Arrival</th>
                                    {{-- <th>View</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach ($products as $prod)
                                    <tr>
                                        <td>{{ $sr }}</td>
                                        <td>{{ $prod->title }}</td>
                                        <td>{{ $prod->category->name }}</td>
                                        <td>{{ $prod->subcategory->title }}</td>
                                        <td>


                                            <!-- Top Pick -->
                                            <form action="{{ route('product.toggleField', $prod->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="field" value="is_top_pick">
                                                <label class="switch">
                                                    <input type="checkbox" name="value" value="1"
                                                        onchange="this.form.submit()"
                                                        {{ $prod->is_top_pick ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Best Seller -->
                                            <form action="{{ route('product.toggleField', $prod->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="field" value="is_best_seller">
                                                <label class="switch">
                                                    <input type="checkbox" name="value" value="1"
                                                        onchange="this.form.submit()"
                                                        {{ $prod->is_best_seller ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- New Arrival -->
                                            <form action="{{ route('product.toggleField', $prod->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="field" value="is_new_arrival">
                                                <label class="switch">
                                                    <input type="checkbox" name="value" value="1"
                                                        onchange="this.form.submit()"
                                                        {{ $prod->is_new_arrival ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </form>


                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('product.show', $prod->id) }}" class="btn btn-info">View</a>
                                        </td> --}}
                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">
                                                <a href="{{ route('product.show', $prod->id) }}"
                                                    class="btn btn-info" style="padding:6px 10px;">View</a>
                                                <a href="{{ route('product.edit', $prod->id) }}"
                                                    class="btn btn-success" style="padding:6px 10px;">update</a>
                                                <form action="{{ route('product.destroy', $prod->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" onclick="return confirm('sure delete ?')"
                                                        value="Delete" class="btn btn-dark" style="padding:6px 10px;">
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                    @php
                                        $sr++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
