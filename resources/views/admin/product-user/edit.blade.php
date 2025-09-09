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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Edit Production User
                        </p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="userForm" method="POST"
                                    action="{{ route('admin.product-user.update', $user->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email (Optional)</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Mobile -->
                                        <div class="col-md-6 mb-3">
                                            <label for="mobile" class="form-label">Mobile</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                value="{{ old('mobile', $user->mobile) }}" required>
                                            @error('mobile')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="password" class="form-label">Password (Leave blank to keep
                                                current)</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                autocomplete="new-password">
                                            <span toggle="#password" class="toggle-password"
                                                style="position: absolute; right: 30px; top: 38px; cursor: pointer;">
                                                👁
                                            </span>
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="col-md-6 mb-3 position-relative">
                                            <label for="password_confirmation" class="form-label">Confirm Password(Leave
                                                blank to keep current)</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" autocomplete="new-password">
                                            <span toggle="#password_confirmation" class="toggle-password"
                                                style="position: absolute; right: 30px; top: 38px; cursor: pointer;">
                                                👁
                                            </span>
                                        </div>


                                        <!-- Profile Image -->
                                        <div class="col-md-6 mb-3">
                                            <label for="profile_image" class="form-label">Profile Image (Optional)</label>
                                            <input type="file" name="profile_image" id="profile_image"
                                                class="form-control">
                                            @if ($user->profile_img)
                                                <img src="{{ asset('profile_image/' . $user->profile_img) }}"
                                                    alt="Current Profile"
                                                    style="width: 50px; height: 50px; margin-top: 10px;">
                                                <p>Leave blank to keep current image.</p>
                                            @endif
                                            @error('profile_image')
                                                <small class="text-danger">{{ $message }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.toggle-password').forEach(function(element) {
                element.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('toggle'));
                    if (input.type === "password") {
                        input.type = "text";
                    } else {
                        input.type = "password";
                    }
                });
            });
        </script>
    @endsection
