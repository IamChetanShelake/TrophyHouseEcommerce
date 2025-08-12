{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
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

    .login-wrapper {
        max-width: 480px;
        margin: 5vh auto;
        background: url('{{ asset("website/assets/images/loginPage.png") }}') no-repeat center center;
        background-size: cover;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        padding: 2.5rem;
        color: #333;
        position: relative;
        border: 2px solid #ffc107;
    }

    .login-content {
        position: relative;
        z-index: 2;
    }

    .login-wrapper h4 {
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
        .login-wrapper {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>

<div class="container">
    <div class="login-wrapper">
        <div class="login-content text-center">
            <img src="{{ asset('website/assets/images/TH-Logo.png') }}" alt="Logo" style="height: 60px;" class="mb-3">
            <h4>Welcome Back! Login to continue.</h4>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required
                        placeholder="Email Address">

                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required
                        placeholder="Password">

                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-3 text-start">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                            id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-yellow w-100">Login</button>
                </div>
                   <div class="d-grid mb-3">
                    <a href="{{ route('google-auth') }}" class="btn btn-outline-light border w-100 d-flex align-items-center justify-content-center" style="border-radius: 10px;color:black">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="height: 20px;" class="me-2">
                        Continue with Google
                    </a>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="btn btn-link text-dark" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
                @endif

                <!-- Register Link -->
                <div class="text-center mt-2">
                    <small>Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-dark">Register</a></small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

