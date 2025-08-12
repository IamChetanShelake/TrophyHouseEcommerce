@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"><a href="{{ route('clients') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> Edit Client Details </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form class="forms-sample" action="{{ route('client.update', $client->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="title">Name</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="" value="{{$client->name}}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="summernote" rows="4" >{{$client->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                <div class="">
                              <img src="{{asset('client_images/'.$client->image)}}" alt="" width="70px;">
                            </div>
                                <label>Image</label>
                                <input type="file" name="image" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled
                                        placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-gradient-primary py-3"
                                            type="button">Upload</button>
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('clients') }}" class="btn btn-dark">Back</a>
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
