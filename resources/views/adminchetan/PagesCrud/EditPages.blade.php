@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> <a href="{{route('pages')}}" class="" style="color:transparent;">
                <img src="{{asset('images/left-arrow.png')}}" style="width:40px;" alt="">
            </a>Edit Page Details </h3>
           
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <form class="forms-sample" action="{{ route('page.update',$page->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="title">Title</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="title" name="title" value="{{$page->title}}" placeholder=""
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label><span style="color:red;">*</span>
                                <textarea class="form-control" name="description" id="summernote" rows="4" required>{!!$page->description!!}</textarea>
                            </div>
                            
                            

                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                            {{-- <button class="btn btn-light">Cancel</button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{route('pages')}}" class="btn btn-dark">Back</a>
    </div>
    <!-- content-wrapper ends -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection
