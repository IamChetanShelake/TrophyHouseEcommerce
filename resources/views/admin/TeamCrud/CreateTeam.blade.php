@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{route('teams')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>  Add Team </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                       
                        <form class="forms-sample" action="{{ route('team.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="name" name="name" placeholder=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label><span style="color:red;">*</span>
                                <textarea class="form-control" name="description" id="summernote" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="role" name="role" placeholder=""
                                    required>
                            </div>
                           
                            <div class="form-group">
                                <label>File upload</label><span style="color:red;">*</span>
                                <input type="file" name="image" class="file-upload-default" required>
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
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{route('teams')}}" class="btn btn-dark">Back</a>
    </div>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200,
            focus: true
        });
    });
    </script>
    <!-- content-wrapper ends -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection
