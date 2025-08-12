@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{route('category')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a> Edit Category </h3>
            {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                    </ol>
                </nav> --}}
        </div>
        <div class="row">
             @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('fail') }}
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
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="card-title">Basic form elements</h4>
                            <p class="card-description"> Basic form elements </p> --}}
                        <form class="forms-sample" action="{{route('category.update',$cat->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="name" class="form-control" id="name" name="name" value="{{$cat->name}}" placeholder=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                 <textarea name="description" class="form-control" id="description"  rows="4" >{{$cat->description}}</textarea>
                            </div>
                        
                                <div class="">
                                <img src="{{asset('category_images/'.$cat->image)}}" alt="" width="70px;">
                                </div>
                            <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="image" class="file-upload-default" >
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                          </span>
                        </div>
                      </div>

                            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                            {{-- <button class="btn btn-light">Cancel</button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{route('category')}}" class="btn btn-dark">Back</a>
    </div>
    <!-- content-wrapper ends -->
     <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection
