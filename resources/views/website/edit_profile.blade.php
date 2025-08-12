@section('title', 'Trophy House - Edit Profile')
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

    .camera-icon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #e63946;
        color: #fff;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
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

    .edit-profile-section {
        max-width: 600px;
        margin: 20px auto 40px auto;
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        font-family: 'Source Sans 3', sans-serif;
    }

    .form-col {
        margin-bottom: 25px;
    }

    .form-col label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
        display: block;
        font-size: 15px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 10px 14px;
        font-size: 14px;
        box-shadow: none;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #e63946;
        box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.2);
        outline: none;
    }

    .submit-button {
        margin-top: 10px;
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

    .section-divider {
        margin-bottom: 30px;
        text-align: center;
    }

    .section-divider h4 {
        font-weight: 700;
        color: #e63946;
    }

    .section-divider hr {
        width: 60px;
        border-top: 3px solid #e63946;
        margin: 10px auto;
    }
</style>

<div class="profile-banner"></div>

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="profile-info">
        @php
            $profileImg = Auth::check() && Auth::user()->profile_img
                ? asset('profile_images/' . Auth::user()->profile_img)
                : base_path('images/profile-default.png');
        @endphp

        <div class="profile-wrapper" style="position: relative; display: inline-block;">
            <img id="profilePreview"
                 src="{{ Auth::user()->profile_img }}"
                 class="avatar"
                 alt="User">

            <input type="file" name="profile_image" id="profile_image" accept="image/*" style="display: none;">

            <div class="camera-icon" onclick="document.getElementById('profile_image').click();">
                <i class="fas fa-camera"></i>
            </div>
        </div>

        <div class="profile-name">{{ Auth::check() ? Auth::user()->name : '' }}</div>
        <div class="profile-sub">{{ Auth::check() ? Auth::user()->email : '' }}</div>
    </div>

    <div class="edit-profile-section">
        <div class="section-divider">
            <h4>Update Your Profile</h4>
            <hr>
        </div>

        <div class="form-col">
            <label for="name">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? '') }}" >
        </div>

        <div class="form-col">
            <label for="email">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" >
        </div>
        
        <div class="form-col">
            <label for="phone">Phone No</label>
            <input type="number" name="phone" class="form-control" value="{{ old('phone', Auth::user()->mobile ?? '') }}">
        </div>

        <div class="text-center">
            <button type="submit" class="submit-button">Update Profile</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('profile_image');
        const preview = document.getElementById('profilePreview');

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
