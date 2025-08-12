@extends('admin.layouts.masterlayout')

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
            <h3 class="page-title"><a href="{{route('tests')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>View Testimonial Detail </h3>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                             
                                    
                                    <tr>
                                        <td><b> Author :- </b></td>
                                        <td>{{ $test->author }}</td>
                                    </tr>
                                    <tr>
                                        <td><b> Role :- </b></td>
                                        <td>{{ $test->role }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b> Description :- </b></td>
                                        <td>{!!$test->testimonial!!}</td>
                                    </tr>   
                                    <tr>
                                        <td> <b> Image :- </b></td>
                                        <td>
                                            <img src="{{asset('testimonial_images/'.$test->image)}}" alt="">
                                        </td>
                                    </tr>   
                            </tbody>
                        </table>
                        <a href="{{route('tests')}}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
