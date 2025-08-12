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
            <h3 class="page-title"><a href="{{ route('occasion') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>View Occasion </h3>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">


                        @if ($oc->image)
                            <td><img src="{{ asset('occasion_images/' . $oc->image) }}" alt=""
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
                                    <td><b>Title:</b></td>
                                    <td>{{ $oc->title }}</td>
                                </tr>

                                <tr>
                                    <td><b>Description:</b></td>
                                    <td>{!! $oc->description !!}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <a href="{{ route('occasion') }}" class="btn btn-dark">Back</a>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
