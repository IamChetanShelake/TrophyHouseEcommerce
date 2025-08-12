@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h3 class="page-title">
                <a href="{{ route('occasion') }}" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> Edit Occasion
            </h3>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('occasion.update', $occasion->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title', $occasion->title) }}" required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label><span style="color:red;">*</span>
                            <textarea class="form-control" name="description" id="summernote" rows="4">{{ old('description', $occasion->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12">
                            <label>Image</label> <span style="color:red;">*</span><br>
                            @if ($occasion->image)
                                <img src="{{ asset('occasion_images/' . $occasion->image) }}" alt="Image"
                                    style="height: 100px; margin-bottom: 10px;">
                            @endif
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload New Image (optional)">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3"
                                        type="button">Upload</button>
                                </span>
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-4 mt-3">
                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
