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
            <h3 class="page-title">
                {{-- <a href="{{route('category')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a> --}}
                Sub-Category Table</h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('subCategory.add') }}" class="btn btn-gradient-primary me-2">Add Sub-Category</a>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        {{-- <p class="card-description"> Add class <code>.table</code> --}}
                        </p>
                        <div>
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

                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subcat as $subc)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $subc->title }}</td>

                                        @if ($subc->image)
                                            <td><img src="{{ asset('sub-category_images/' . $subc->image) }}" alt="">
                                            </td>
                                        @else
                                            <td>
                                                <p>No Image Available</p>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('subCategory.show', $subc->id) }}"
                                                class="btn btn-info">View</a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">

                                                <a href="{{ route('subCategory.edit', $subc->id) }}"
                                                    class="btn btn-success">update</a>


                                                <form action="{{ route('subCategory.destroy', $subc->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit"
                                                        onclick="return confirm('sure you want to delete this item ?')"
                                                        value="Delete" class="btn btn-dark">
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
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
