@section('title', 'Trophy House - Contact')
@extends('website.layout.master')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Source Sans 3', sans-serif;
            background-color: white;
            /* background-color: #fdf6e3; */
            /* padding: 0 20px; */
        }

        a {
            text-decoration: none;
        }

        .contact-info-card {
            background-color: white;
            border: 1px solid #FFC8C8;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            height: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            font-size: 2rem;
            /* color: red; */
            margin-bottom: 10px;
        }

        .form-section {
            background-color: #fff7dd;
            padding: 50px 30px;
            /* border-radius: 10px; */
            margin-top: 30px;
            /* border: 2px solid red;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); */
        }

        .form-group-icon {
            position: relative;
        }

        .form-group-icon input,
        .form-group-icon select,
        .form-group-icon textarea {
            padding-right: 40px !important;
        }

        .form-group-icon i {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: gray;
            pointer-events: none;
        }

        .form-control,
        .form-select {
            /* background-color: #fffdf2;
          border: 1px solid #ccc; */
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #FFC8C8;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        }

        .btn-yellow {
            background: linear-gradient(to right, #fff7cc, #ffe169);
            /* soft yellow gradient */
            color: #d62828;
            /* red text */
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 18px;
            border: none;
            border-radius: 15px;
            padding: 14px 100px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-yellow:hover {
            background: linear-gradient(to right, #ffd166, #f9c74f);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }
    </style>

    <section>
        <!-- Contact Info Cards -->

        <div class="container py-5 mt-5 mb-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon"><i class="bi bi-geo-alt"></i></div>
                        <p>Space cosmos, old Mumbai Agra Road, Beside Canara Bank, opp. Meher Bus Stop, Ashok Stambh, Nashik 422002</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <p>trophyhousensk1@gmail.com</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info-card h-100">
                        <div class="contact-icon"><i class="bi bi-telephone"></i></div>
                        <p>9423962242, 9423962042, 9404076742</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Contact Form Section -->
        <div class="container-fluid form-section">
            <h2 class="text-center mb-4 fw-bold" style="font-family: 'Times New Roman', serif; font-weight: bold;">Get In
                Touch</h2>
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
            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6 form-group-icon">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter your name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="bi bi-person"></i>
                    </div>
                    <div class="col-md-6 form-group-icon">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter a valid email address" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="col-md-6 form-group-icon">
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div class="col-md-6 form-group-icon">
                        <select class="form-select" name="subject" required>
                            <option disabled selected>Select Subject</option>
                            <option value="enquiry">General Inquiry</option>
                            <option value="support">Support</option>
                            <option value="feedback">Feedback</option>
                        </select>

                    </div>
                    {{-- <div class="col-md-6 form-group-icon">
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Enter your address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                   
                                </div> --}}
                    <div class="col-12 form-group-icon">
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                            placeholder="Enter a message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <i class="bi bi-pencil" style="top:12%;"></i>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn  btn-sm btn-yellow" style="color:red">SEND MESSAGE</button>
                    </div>
                </div>
            </form>
            {{-- <form>
            <div class="row g-3 mb-3">
                <div class="col-md-6 form-group-icon">
                    <input type="text" class="form-control" placeholder="Your Name" required>
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="col-md-6 form-group-icon">
                    <input type="email" class="form-control" placeholder="Email Address" required>
                    <i class="bi bi-envelope-fill"></i>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6 form-group-icon">
                    <input type="text" class="form-control" placeholder="Phone Number" required>
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="col-md-6 form-group-icon">
                    <select class="form-select" required>
                        <option disabled selected>Select Subject</option>
                        <option>General Inquiry</option>
                        <option>Support</option>
                        <option>Feedback</option>
                    </select>

                </div>
            </div>
            <div class="mb-3 form-group-icon">
                <textarea class="form-control" rows="4" placeholder="Your Message" required></textarea>
                <i class="bi bi-pencil-fill"></i>
            </div>
            <div class="text-center" style="background-color: #fff9e6; padding: 20px;">
                <button type="submit" class="btn-yellow">SEND MESSAGE</button>
            </div>

        </form> --}}

        </div>

        <!-- Google Map Section -->
        <div class="container-fluid mt-5 mb-5 px-0" style="background-color: white;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3749.068620839914!2d73.78193697500247!3d20.00563448139983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeba8cbff77b3%3A0x114ab7191ad0ab8a!2sTrophy%20House!5e0!3m2!1sen!2sin!4v1750696327362!5m2!1sen!2sin"
                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </section>
@endsection
