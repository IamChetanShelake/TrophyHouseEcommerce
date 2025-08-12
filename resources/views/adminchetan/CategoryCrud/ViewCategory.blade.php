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
            <h3 class="page-title"><a href="{{route('category')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>View Category </h3>

        </div>
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 grid-margin stretch-card">
                       
                                    
                                        @if ($cat->image)
                                           <img src="{{ asset('category_images/' . $cat->image) }}" alt="" style="width: 400px !important;height: 400px !important;;
    height: auto;
    border-radius:0px;">
                                        @else
                                          
                                                <p>No Image Available</p>
                                          
                                        @endif
            

                                    </tr>
                        </div>
                        <div class="col-lg-6 col-sm-12 grid-margin stretch-card">
                        
                        
                        <table class="table">
                            <tbody>
                             
                                
                                    <tr>
                                        <td><b>Name :- </b></td>
                                        <td>{{ $cat->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Description :-</b></td>
                                        <td>{{$cat->description}}</td>
                                    </tr>
                                 
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{route('category')}}" class="btn btn-dark">Back</a>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
