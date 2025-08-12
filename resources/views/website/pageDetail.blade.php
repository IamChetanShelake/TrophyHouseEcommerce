@extends('website.layout.master')
@section('content')
    <!-- Page Title -->
    <section class="page-title centred"
        style="background-image: url({{ asset('website/assets/images/background/page-title.jpg') }});">
        <div class="auto-container">
            <div class="content-box">
                <div class="title text-center">
                    <h1>
                        {{ $page->title }}</h1>
                </div>

            </div>
        </div>
    </section>
    <!-- End Page Title -->


    <!-- service-details -->
    <section class="service-details mt-5 mb-5">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-1"></div>
                <div class="col-lg-10 col-md-12 col-sm-12  content-side ">
                    <div class="service-details-content">
                        <div class="inner">
                            <p>{!! $page->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- service-details end -->
@endsection
