@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{ route('teams') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> View About Details </h3>

        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">
                        @if ($team->image)
                            <img src="{{ asset('team_images/' . $team->image) }}" alt=""
                                style="width: 50%;height: auto;border-radius:0px;">
                        @else
                            <p>No Image Available</p>
                        @endif
                    </div>
                    <div class="col-lg-6 col-sm-12 grid-margin stretch-card">

                        <table class="table">
                            <tbody>


                                <tr>
                                    <td><b>Name :-</b> </td>
                                    <td>{{ $team->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Role :-</b></td>
                                    <td>{{ $team->role }}</td>
                                </tr>
                                <tr>
                                    <td><b>Description :-</b></td>
                                    <td>{{ $team->description }}</td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ route('teams') }}" class="btn btn-dark">Back</a>
            </div>
            
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
