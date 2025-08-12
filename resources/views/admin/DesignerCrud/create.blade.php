@extends('admin.layouts.masterlayout')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <a href="{{ route('Designerinfo') }}">
                <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
            </a> Add Designer
        </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('designer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('admin.DesignerCrud.form', ['type' => 'create'])
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('Designerinfo') }}" class="btn btn-dark mt-2">Back</a>
</div>
@endsection
