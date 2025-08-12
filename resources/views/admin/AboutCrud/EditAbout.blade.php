@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{route('about')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>  Edit About Details </h3>
           
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <form class="forms-sample" action="{{ route('about.update',$about->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="title">Title</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="title" name="title" value="{{$about->title}}" placeholder=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label><span style="color:red;">*</span>
                                <textarea class="form-control" name="description" id="description" rows="4" required>{{$about->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="longdescription">Long Description</label><span style="color:red;">*</span>
                                <textarea class="form-control" name="longdescription" id="summernote" rows="4">{{$about->long_description}}</textarea>
                                @error('longdescription')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            
                            <div class="form-group">
                                <div class="">
                              <img src="{{asset('about_images/'.$about->image)}}" alt="" width="70px;">
                            </div>
                                <label>File upload</label>
                                <input type="file" name="image" class="file-upload-default" >
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">Upload</button>
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
        <a href="{{route('about')}}" class="btn btn-dark">Back</a>
    </div>
    <!-- content-wrapper ends -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection
