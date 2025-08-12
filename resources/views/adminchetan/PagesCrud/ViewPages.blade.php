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
            <h3 class="page-title"><a href="{{route('pages')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>View Page Detail </h3>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        
                        <table class="table">
                            <tbody>
                             
                                
                                    <tr>
                                        <td><b> Name :- </b></td>
                                        <td>{{ $page->title }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b> Description :- </b></td>
                                        <td>{!!$page->description!!}</td>
                                    </tr>   
                                
                            </tbody>
                        </table>
                        <a href="{{route('pages')}}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
