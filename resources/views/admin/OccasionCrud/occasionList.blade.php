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
            <h3 class="page-title"> Occasions List </h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('occasion.add') }}" class="btn btn-gradient-primary me-2">Add Occasion</a>
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
                                    <th>image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($occasions as $oc)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $oc->title }}</td>
                                        @if($oc->image)
                                        <td><img src="{{ asset('occasion_images/' . $oc->image) }}" alt=""></td>
                                        @else
                                         <td>No Image Yet</td>
                                        @endif


                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">
                                                <a href="{{ route('occasion.show', $oc->id) }}" class="btn btn-info"
                                                    style="padding:6px 10px;">View</a>
                                                <a href="{{ route('occasion.edit', $oc->id) }}" class="btn btn-success"
                                                    style="padding:6px 10px;">update</a>
                                                <form action="{{ route('occasion.destroy', $oc->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" onclick="return confirm('sure delete ?')"
                                                        value="Delete" class="btn btn-dark" style="padding:6px 10px;">
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
