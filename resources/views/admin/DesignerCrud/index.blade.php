@extends('admin.layouts.masterlayout')

@section('content')
<style>
    table thead, table tbody td {
        text-align: center;
        white-space: break-spaces;
        vertical-align: middle;
    }
    img.designer-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Designer</h3>
        <nav aria-label="breadcrumb">
            <a href="{{ route('designer.add') }}" class="btn btn-gradient-primary me-2">Add Designer</a>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- Success Message --}}
                    @if (session('success'))
                        <div id="successMessage" class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        <script>
                            setTimeout(() => {
                                document.getElementById('successMessage')?.remove();
                            }, 3000);
                        </script>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($designers as $designer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($designer->profile_img)
                                            <img src="{{ asset('designer_images/' . $designer->profile_img) }}" alt="Image" class="designer-img">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="designer-img">
                                        @endif
                                    </td>
                                    <td>{{ $designer->name }}</td>
                                    <td>{{ $designer->email }}</td>
                                    <td>{{ $designer->mobile }}</td>
                                    
                                   
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('designer.view', $designer->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('designer.edit', $designer->id) }}" class="btn btn-success">Update</a>
                                            <form action="{{ route('designer.destroy', $designer->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-dark" value="Delete">
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($designers->isEmpty())
                                <tr>
                                    <td colspan="8">No designers found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
