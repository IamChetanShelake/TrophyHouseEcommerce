@extends('website.layout.master')

@section('content')
<style>
    .profile-banner {
        width: 100%;
        height: 110px;
        background: url('{{ asset('website/assets/images/banner.jpg') }}') center center/cover no-repeat;
        position: relative;
    }

    .profile-info {
        position: relative;
        margin-top: -75px;
        text-align: center;
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        object-fit: cover;
        background-color: #fff;
    }

    .profile-name {
        font-weight: bold;
        font-size: 22px;
        margin-top: 15px;
        color: #333;
    }

    .profile-sub {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .save-btn {
        background-color: transparent;
        border: 2px solid #e63946;
        color: #e63946;
        border-radius: 25px;
        padding: 6px 18px;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }

    .save-btn:hover {
        background-color: #e63946;
        color: white;
    }

    .edit-profile-section {
        max-width: 900px;
        margin: 40px auto;
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        font-family: 'Source Sans 3', sans-serif;
    }

    .section-title {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 30px;
        color: #e63946;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.6rem;
        background-color: #f8f9fa;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-col {
        flex: 1;
        min-width: 250px;
    }

    .submit-button {
        margin-top: 30px;
        background: linear-gradient(to right, #f9d423, #ff4e50);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        transition: 0.3s;
    }

    .submit-button:hover {
        background: linear-gradient(to right, #fca311, #e63946);
    }
</style>

<!-- Banner -->
<div class="profile-banner"></div>

<!-- Form start -->
<form method="POST" id="profileForm" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Profile Info -->
    <div class="profile-info">
        @php
            $profileImage = Auth::user()->profile_img ?? 'default-avatar.png';
        @endphp

        <div class="profile-wrapper" style="position: relative; display: inline-block;">
            @if (!empty(Auth::user()->profile_img))
                <img src="{{ asset('profile_images/' . Auth::user()->profile_img) }}" class="avatar" alt="User">
            @else
                <img src="{{ asset('images/profile-default.png') }}" class="avatar" alt="User">
            @endif

            <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display: none;">
            <input type="file" name="profile_image" id="profile_image_input" class="d-none" accept="image/*">

            <div class="camera-icon" onclick="document.getElementById('cameraInput').click()"
                style="position: absolute; bottom: 10px; right: 10px; background: #e63946; color: #fff; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <i class="fas fa-camera"></i>
            </div>
        </div>

        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-sub">{{ Auth::user()->email }}</div>


    <!-- Edit Form Section -->
    <div class="edit-profile-section">
        <div class="section-title">Personal Details</div>

        <div class="form-row">
            <div class="form-col">
                <label for="name">Full Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>

            <div class="form-col">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- <div class="form-row">
            <div class="form-col">
                <label for="password">New Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Leave blank to keep current password">
                @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>
        </div> -->

            <div class="form-col">
                <label for="profile_image">Profile Image</label>
                <input type="file" class="form-control @error('profile_img') is-invalid @enderror" name="profile_image" accept="image/*">
                @error('profile_img')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
            </div>


        <!-- ✅ Update Profile button submits same form -->
        <button type="submit" class="submit-button">Update Profile</button>
    </div>
</form>

<!-- ✅ Success Message -->
@if (session('success'))
    <div class="alert alert-success text-center mt-4">
        {{ session('success') }}
    </div>
@endif
@endsection

@push('scripts')
<script>
    document.getElementById('cameraInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.avatar').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Assign selected file to form input
            const profileInput = document.getElementById('profile_image_input');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            profileInput.files = dataTransfer.files;
        }
    });
</script>
@endpush
