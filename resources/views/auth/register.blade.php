{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                         

                        <!--<div class="row mb-3">-->
                        <!--    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>-->

                        <!--    <div class="col-md-6">-->
                        <!--        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">-->

                        <!--        @error('email')-->
                        <!--            <span class="invalid-feedback" role="alert">-->
                        <!--                <strong>{{ $message }}</strong>-->
                        <!--            </span>-->
                        <!--        @enderror-->
                        <!--    </div>-->
                        <!--</div>-->

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .signup-wrapper {
            max-width: 480px;
            margin: 5vh auto;
            background: url('{{ asset('website/assets/images/loginPage.png') }}') no-repeat center center;
            background-size: cover;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            color: #333;
            position: relative;
            border: 2px solid #ffc107;
            border-radius: 12px;
        }

        .signup-content {
            position: relative;
            z-index: 2;
        }

        .signup-wrapper h4 {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem;
        }

        .btn-yellow {
            background: linear-gradient(to right, #f9d423, #ff4e50);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem;
            transition: background 0.3s ease-in-out;
        }

        .btn-yellow:hover {
            background: linear-gradient(to right, #fca311, #e63946);
        }

        @media (max-width: 576px) {
            .signup-wrapper {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>

    <div class="container">
        <div class="signup-wrapper">
            <div class="signup-content text-center">
                <img src="{{ asset('website/assets/images/TH-logo.png') }}" alt="Logo" style="height: 60px;" class="mb-3">
                <h4>Sign up for exclusive designs, deals & quick checkout.</h4>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required placeholder="Enter Full Name*">

                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" min="0" required placeholder="Phone">

                        @error('phone')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    
                    <!-- Email -->
                    <div class="mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required placeholder="Email ID*">

                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <!-- Password -->
                    <div class="mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required placeholder="Password*">

                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required placeholder="Confirm Password*">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-yellow w-100">SIGN UP</button>
                    </div>

                    <!-- Google Button -->
                    <div class="d-grid mb-3">
                        <a href="{{ route('google-auth') }}"
                            class="btn btn-outline-light border w-100 d-flex align-items-center justify-content-center"
                            style="border-radius: 10px;color:black">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google"
                                style="height: 20px;" class="me-2">
                            Continue with Google
                        </a>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <small>Already have an account? <a href="{{ route('login') }}" class="fw-bold text-dark">Log
                                In</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
