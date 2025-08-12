@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
        }
    </style>

    <div class="content-wrapper">
       
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">users Table</h4>
                        {{-- <p class="card-description"> Add class <code>.table</code> --}}
                        </p>
                        <table class="table">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
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
                                    <th>user name.</th>
                                    <th>email</th>
                                    <th>view</th>
                                    {{-- <th>action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sr = 1;
                                @endphp

                                @foreach ($users as $user)
                                    @if ($user->role === 0)
                                        <tr>
                                            <td>{{ $sr }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{route('user.show',$user->id)}}" class="btn btn-info">View</a>
                                            </td>
                                            {{-- <td>
                                                @if($user->status === 0)
                                                <a href="" class="btn btn-danger">Block</a>
                                                @elseif($user->status === 1)
                                                <a href="" class="btn btn-success">unblock</a>
                                                @endif
                                            </td> --}}
                                        </tr>
                                    
                                    @endif
                                    {{$users->links()}}
                                @endforeach
                                @php
                                    $sr++;
                                @endphp

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
