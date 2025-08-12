@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
            white-space: break-spaces;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{route('Admingallery')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a> View Gallery </h3>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        
                        <table class="table">
                            <tbody>
                             
                                
                                    <tr>
                                        <td>Title :- </td>
                                        <td>{{ $gallery->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Description :-</td>
                                        <td>{{$gallery->description}}</td>
                                    </tr>

                                
                                    
                                    <td>Image:-</td>
                                    
                                        @if ($gallery->image)
                                            <td><img src="{{ asset('gallery_images/' . $gallery->image) }}" alt="" style="width: 200px;height: auto;border-radius:0px;"></td>
                                        @else
                                            <td>
                                                <p>No Image Available</p>
                                            </td>
                                        @endif
            

                                    </tr>
                                
                            </tbody>
                        </table>
                        <a href="{{route('Admingallery')}}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
