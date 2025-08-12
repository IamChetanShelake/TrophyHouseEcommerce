@extends('admin.layouts.masterlayout')

@section('content')
<style>
    table thead, table tbody td{
        text-align: center;
    }
</style>
   
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Pages</h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('page.add') }}" class="btn btn-gradient-primary me-2">
                    Add Pages</a>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Page Table</h4>
                        </p>
                        <table class="table">
                             @if (session('error'))
                                <div id="failMessage" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div id="successMessage" class="alert alert-success">
                                    {{ session('success') }}
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
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Title.</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach ($page as $pg)
                                    <tr>
                                        <td>{{ $sr }}</td>
                                        <td>{{ $pg->title }}</td>
                                        <td>
                                            <a href="{{ route('page.view', $pg->id) }}" class="btn btn-info">View</a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">

                                                <a href="{{ route('page.edit', $pg->id) }}"
                                                    class="btn btn-success">Update</a>
                                                <form action="{{ route('page.destroy', $pg->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" onclick="return confirm('sure delete ?')"
                                                        value="Delete" class="btn btn-dark">
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                    @php
                                        $sr++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
