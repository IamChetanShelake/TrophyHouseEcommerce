@extends('admin.layouts.masterlayout')
@section('content')
    <style>
        .form-control,
        .btn {
            font-size: 16px;
        }

        .form-label {
            font-size: 16px;
            font-weight: 500;
            color: #000;
        }

        .btn-primary {
            background-color: #FFE235;
            border: none;
            color: #000;
        }

        .btn-primary:hover {
            background-color: #f5f5f5;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            color: #fff;
        }

        .app-wrapper {
            background: #FFFFF4;
        }

        @media (max-width: 768px) {
            .custom-margin {
                margin-left: 10px !important;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <x-session-message />
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Product Users List</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-end">
                                    <a href="{{ route('admin.product-user.create') }}" class="btn btn-primary mb-3 ">Add New
                                    </a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Profile Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email ?? 'N/A' }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td>
                                                        @if ($user->profile_img)
                                                            <img src="{{ asset('profile_image/' . $user->profile_img) }}"
                                                                alt="Profile" style="width: 50px; height: 50px;">
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.product-user.edit', $user->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                        <form action="{{ route('admin.product-user.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
