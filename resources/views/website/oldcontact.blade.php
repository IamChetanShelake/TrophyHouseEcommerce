@extends('website.layout.master')
@section('content')
    <style>
        .contact-section {
            background: #fff8ec;
            font-family: 'Source Sans 3', sans-serif;
            padding: 60px 0;
        }

        .contact-box {
            background: #fff4da;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.15);
        }

        .form-control,
        .form-select {
            border-radius: 0;
            border: 1px solid #ffc107;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ff9800;
            box-shadow: none;
        }

        .contact-image {
            width: 100%;
            max-height: 365px;
            border-radius: 10px;
            margin-top: 40px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(255, 152, 0, 0.3);
        }

        .contact-detail-icon {
            font-size: 24px;
            color: #dc3545;
            margin-bottom: 10px;
        }

        .contact-detail-text {
            color: #444;
            font-weight: 500;
        }
    </style>

    <section class="contact-section">
        <div class="container">
            <!-- Heading -->
            <div class="text-center mb-5">
                <h3 class="text-center mb-5" style="color: #e63946;font-family: 'Times New Roman', serif; font-weight: bold;">
                    Contact Us</h3>
                <p class="text-muted">Any questions or remarks? Just write us a message!</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Contact Form -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-box">
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter your name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter a valid email address" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Enter your address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                                        placeholder="Enter a message" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit"
                                        class="btn btn-outline-danger btn-sm btn-danger px-4 rounded-pill"
                                        style="color:white">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="row mt-5">
                <div class="col-12">
                    <iframe
                       src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3749.068620839914!2d73.78193697500247!3d20.00563448139983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeba8cbff77b3%3A0x114ab7191ad0ab8a!2sTrophy%20House!5e0!3m2!1sen!2sin!4v1750696327362!5m2!1sen!2sin" 
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Contact Info (3 columns) -->
            <div class="row text-center mt-4">
                <div class="col-md-4 mb-3">
                    <div class="contact-detail-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div class="contact-detail-text">+91 9422558740, +91 8966932578</div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="contact-detail-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div class="contact-detail-text">Space cosmos, Mumbai - Agra Hwy, beside canara Bank, opp. Meher Bus Stop, Ashok Stambh, Raviwar Karanja, Panchavati, Nashik, Maharashtra 422001</div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="contact-detail-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div class="contact-detail-text">--</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
