@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: start;
            white-space: break-spaces;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">View User </h3>

        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        
                        <table class="table">
                            <tbody>
                             
                                
                                    <tr>
                                        <td><b> Name :- </b></td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email :- </b></td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Password :- </b></td>
                                        <td>{{$user->password}}</td>
                                    </tr>
                                    
                                
                            </tbody>
                        </table>
                        <a href="{{route('users')}}" class="btn btn-dark mt-5 ">Back</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
