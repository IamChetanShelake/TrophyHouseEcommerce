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
        <h3 class="page-title">
            <a href="{{ route('Designerinfo') }}">
                <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
            </a> View Designer
        </h3>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $designer->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $designer->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mobile No:</strong></td>
                                <td>{{ $designer->mobile }}</td>
                            </tr>
                            <tr>
                                <td><strong>Birthday:</strong></td>
                                <td>{{ $designer->birthday }}</td>
                            </tr>
                            <tr>
    <td><strong>Designation:</strong></td>
    <td>{{ $designer->designation }}</td>
</tr>
<tr>
    <td><strong>Image:</strong></td>
    <td>
        @if ($designer->profile_img)
            <img src="{{ asset('designer_images/' . $designer->profile_img) }}" width="100">
        @else
            <p>No Image</p>
        @endif
    </td>
</tr>


                        </tbody>
                    </table>
                    <a href="{{ route('Designerinfo') }}" class="btn btn-dark mt-3">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
