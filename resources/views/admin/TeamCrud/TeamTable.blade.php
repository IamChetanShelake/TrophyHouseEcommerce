@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Team</h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('team.add') }}" class="btn btn-gradient-primary me-2">Add Team</a>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Team Table</h4>
                        {{-- <p class="card-description"> Add class <code>.table</code> --}}
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
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp
                                @foreach ($teams as $team)
                                    <tr>
                                        <td>{{ $sr }}</td>
                                        <td>{{ $team->name }}</td>

                                        @if ($team->image)
                                            <td><img src="{{ asset('team_images/' . $team->image) }}" alt=""></td>
                                        @else
                                            <td>
                                                <p>No Image Available</p>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('team.view', $team->id) }}" class="btn btn-info">View</a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">

                                                <a href="{{ route('team.edit', $team->id) }}"
                                                    class="btn btn-success">Update</a>
                                                <form action="{{ route('team.destroy', $team->id) }}" method="post">
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
