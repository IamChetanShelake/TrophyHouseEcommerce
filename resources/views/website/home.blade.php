@extends('website.layout.master')
@section('content')
    <style>
        .occasional-slider-section .occasional-slider-container {
            display: flex;
            overflow-x: visible;
            scroll-behavior: smooth;
            gap: 9px;
            padding-bottom: 20px;
        }

        .occasional-slider-section .occasional-slider-container::-webkit-scrollbar {
            display: none;
        }

        .occasional-slider-section .trophy-card {
            flex: 0 0 calc(33.33% - 20px);
            /*max-width: calc(30.33% - 20px);*/
            /*width: 550px;*/
            border: 1px solid #f0cfcf;
            border-radius: 10px;
            transition: 0.3s ease-in-out;
        }

        .occasional-slider-section .occasional-slider-container:has(.trophy-card:only-child) .trophy-card {
            flex: 0 0 100%;
        }

        .occasional-slider-section .slider-right-arrow {
            cursor: pointer;
            height: 30px;
            margin-left: 10px;
            margin-top: auto;
            margin-bottom: auto;
        }

        .occasional-slider-section .product-section {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .toggle-circles {

            display: flex;

            gap: 12px;

        }



        .circle-toggle {

            width: 20px;

            height: 20px;

            border-radius: 50%;

            border: 2px solid #e03c3c;

            background-color: transparent;

            cursor: pointer;

            transition: all 0.3s ease-in-out;

        }



        .circle-toggle.active {

            background-color: #e03c3c;

        }



        .aboutus-view {

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            transition: transform 0.5s ease-in-out;

            opacity: 0;

            transform: translate(100%);

            z-index: 0;

        }



        .aboutus-view.slide-active {

            opacity: 1;

            transform: translate(0%);

            z-index: 1;

        }



        .aboutus-view.slide-left {

            transform: translate(-100%);

        }

        0.subcategory-box {
            transition: transform 0.3s ease;
        }

        .subcategory-box:hover {
            transform: scale(1.08);
            /* adjust scale factor as needed */
        }

        .card.trophy-card:hover {
            transform: scale(1.08);
            /* adjust scale factor as needed */
        }

        .no-products {
            display: none;
            font-family: 'Source Sans 3', sans-serif;
            color: #e63946;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        .login-wrapper {
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

        @media (max-width: 576px) {
            .category-items {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: center !important;
                align-items: center !important;
                width: 100% !important;
                padding: 0 10px !important;
                margin: 0 !important;
                flex-direction: row !important;
            }

            .category-items .subcategory-box {
                flex: 0 0 50% !important;
                max-width: 180px !important;
                box-sizing: border-box !important;
                padding: 0 5px !important;
                margin-bottom: 20px !important;
                text-align: center !important;
                width: 50% !important;
                min-width: 0 !important;
            }

            .category-items .subcategory-box .subcategory-tab {
                width: 100% !important;
                padding: 10px !important;
            }

            .category-items .subcategory-box img {
                max-height: 100px !important;
                /* Image size */
                width: 100% !important;
                object-fit: contain !important;
                display: block !important;
                margin: 0 auto !important;
            }

            .category-items .subcategory-box h6 {
                font-size: 14px !important;
                /* Text size */
                margin-top: 10px !important;
                text-align: center !important;
                /* Centers text */
            }
        }

        @media (max-width: 576px) {
            .position-relative.overflow-hidden {
                min-height: 852px !important;
                /* Overrides the inline min-height on mobile */
            }
        }

        @media (min-width: 550px) and (max-width: 570px) {
            .trophy-section .row.justify-content-center.text-center {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .trophy-section .top-pick-product {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                box-sizing: border-box;
                padding: 0 15px;
                margin-bottom: 20px;
            }
        }

        .occProduct-trophy-card {
            width: 150px;
        }
    </style>

    <style>
        .price-filter {
            border: 1px solid #ddd;
        }

        .range-slider {
            position: relative;
            height: 40px;
        }

        .range-slider input[type=range] {
            position: absolute;
            width: 100%;
            pointer-events: none;
            -webkit-appearance: none;
            background: none;
        }

        .range-slider input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #007bff;
            border: 2px solid white;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            -webkit-appearance: none;
        }

        .range-slider input[type=range]:first-of-type::-webkit-slider-thumb {
            z-index: 10;
        }

        .range-slider input[type=range]:last-of-type::-webkit-slider-thumb {
            z-index: 10;
        }

        .range-slider input[type=range]::-moz-range-thumb {
            pointer-events: all;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #007bff;
            border: 2px solid white;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        .range-slider input[type=range]:first-of-type::-moz-range-thumb {
            z-index: 10;
        }

        .range-slider input[type=range]:last-of-type::-moz-range-thumb {
            z-index: 1;
        }
    </style>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="backdrop-filter: blur(3px);">
        <div class="modal-dialog" role="document">
            <div class="modal-content p-5"
                style="z-index:9;
       background: url('{{ asset('website/assets/images/loginPage.png') }}') no-repeat center center; background-size: contain; background-color:white; ">

                <div class="modal-body">
                    <div class="login-content text-center d-none">
                        <img src="{{ asset('website/assets/images/TH-logo.png') }}" alt="Logo" style="height: 60px;"
                            class="mb-3">
                        <h4>Welcome Back! Login to continue.</h4>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- mobile -->
                            <div class="mb-3">
                                <input id="mobile" type="tel"
                                    class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                    value="{{ old('mobile') }}" required placeholder=" Phone Number ">

                                @error('mobile')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
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
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

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
                                <a href="{{ route('google-auth') }}"
                                    class="btn btn-outline-light border w-100 d-flex align-items-center justify-content-center"
                                    style="border-radius: 10px;color:black">
                                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                                        alt="Google" style="height: 20px;" class="me-2">
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
                                <small>Don't have an account? <a href="javascript:void(0);"
                                        class="fw-bold text-dark switch-form" data-form="signup">Register</a></small>
                            </div>
                        </form>
                    </div>

                    {{-- signup-content  --}}
                    <div class="signup-content text-center d-none">
                        <img src="{{ asset('website/assets/images/TH-logo.png') }}" alt="Logo" style="height: 60px;"
                            class="mb-3">
                        <h4>Sign up for exclusive designs, deals & quick checkout.</h4>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required placeholder="Enter Full Name*">

                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <input id="phone" type="number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" min="0" required placeholder="Phone*">

                                @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required placeholder="Email ID*">

                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <!-- Password -->
                            <div class="mb-3">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    placeholder="Password*">

                                @error('password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required placeholder="Confirm Password*">
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
                                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                                        alt="Google" style="height: 20px;" class="me-2">
                                    Continue with Google
                                </a>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <small>Already have an account? <a href="javascript:void(0);"
                                        class="fw-bold text-dark switch-form" data-form="login">Log In</a></small>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--====== Main Bg  ======-->
    <main class="main-bg" style="background-color: white;">

        <!--====== Start Hero Section ======-->
        <section class="hero-section" style="padding-top: 39px;">
            <div class="hero-wrapper-one">
                <div class="container" style="margin-top: -85px;">
                    <div class="row align-items-center">
                        <!-- Left Content Area -->
                        <div class="col-lg-6">
                            <div id="hero-content" class="hero-content style-one mb-50">
                                <span class="sub-headings"
                                    style="font-family: 'Poppins', sans-serif;font-size: 14px;">Celebrate every win</span>

                                <h1 id="hero-title">Trophies - Every Win,<br>A Masterpiece</h1>
                                <p id="hero-description" style="font-size: 16px;">
                                    Honor excellence with our premium trophies — designed to last, built to inspire. From
                                    sports to corporate milestones, we’ve got the perfect piece for every victory.
                                </p>
                                <div class="button-groups">
                                    @if (!Auth::user())
                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor:pointer;"
                                            class="custom-btn" data-form="signup">Sign
                                            Up</a>
                                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="custom-btn"
                                            style="cursor:pointer;" data-form="login">Log
                                            in</a>
                                    @endif
                                </div>
                            </div>

                            <img src="{{ asset('website/assets/images/Vector4.png') }}" alt="Curved Arrow"
                                class="curved-arrow">

                        </div>

                        <!-- Right Trophy & Icons -->
                        <div class="col-lg-6">
                            <div class="hero-visual">
                                <div class="hero-image responsive-img-wrapper">
                                    <img id="main-trophy" src="{{ asset('website/assets/images/homePage/trophy1.png') }}"
                                        alt="Trophy">
                                    <img id="quote-box-0"
                                        src="{{ asset('website/assets/images/homePage/Group105.png') }}"
                                        class="quote-bubble"
                                        style="display: block;left: -16px;height: 60px;width: 215px;bottom: 78px;">
                                    <img id="quote-box-1"
                                        src="{{ asset('website/assets/images/homePage/Group 106.png') }}"
                                        class="quote-bubble"
                                        style="display: none;left: -23px;bottom: 153px;height: 60px;width: 215px;">
                                    <img id="quote-box-2"
                                        src="{{ asset('website/assets/images/homePage/Group 107.png') }}"
                                        class="quote-bubble"
                                        style="display: none;top: 10px;right: 339px;height: 60px;width: 215px;">
                                    <img id="quote-box-3"
                                        src="{{ asset('website/assets/images/homePage/Group 113.png') }}"
                                        class="quote-bubble"
                                        style="display: none;left: 4px;height: 60px;width: 215px;bottom: 78px;">
                                </div>

                                <div class="category-icons">
                                    <div class="icon" data-slide="0" style="margin-right: 100px;">
                                        <img src="{{ asset('website/assets/images/1.png') }}" alt="Trophy"
                                            style="margin-right: 2px;">
                                    </div>
                                    <div class="icon" data-slide="1">
                                        <img src="{{ asset('website/assets/images/2.png') }}" alt="Medal">
                                    </div>
                                    <div class="icon" data-slide="2">
                                        <img src="{{ asset('website/assets/images/3.png') }}" alt="Gift">
                                    </div>
                                    <div class="icon" data-slide="3">
                                        <img src="{{ asset('website/assets/images/mala.png') }}" alt="Rosary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            const slides = [{
                    title: "Tropies - Every Win,<br>A Masterpiece",
                    desc: "Honor excellence with our premium trophies — designed to last, built to inspire. From sports to corporate milestones, we’ve got the perfect piece for every victory.",
                    img: "{{ asset('website/assets/images/homePage/trophy1.png') }}",
                    quotePos: "bottom"
                },
                {
                    title: "Medals -Wear Your <br> Win With Pride",
                    desc: "Our finely crafted medals make every achievement shine. Ideal for competitions, marathons, and school events — a true badge of honor.",
                    img: "{{ asset('website/assets/images/homePage/Group 109.png') }}",
                    quotePos: "top"
                },
                {
                    title: "Corporate Gifts - <br> Elevate Every Occasion",
                    desc: "Appreciate your team, impress your clients. Explore our range of high-quality corporate gifts, perfect for events, festivals, and recognition programs.",
                    img: "{{ asset('website/assets/images/homePage/Group110.png') }}",
                    quotePos: "bottom"
                },
                {
                    title: "Samman - Tradition  <br> Meets Tribute",
                    desc: "Celebrate culture and honor legacy with our specially curated Samman awards — a meaningful way to show respect, gratitude, and pride.",
                    img: "{{ asset('website/assets/images/homePage/Group111.png') }}",
                    quotePos: "top"
                }
            ];

            document.querySelectorAll('.category-icons .icon').forEach((icon, index) => {
                icon.addEventListener('mouseenter', () => {
                    const slide = slides[index];

                    // Update title, description, image
                    document.getElementById('hero-title').innerHTML = slide.title;
                    document.getElementById('hero-description').innerText = slide.desc;
                    document.getElementById('main-trophy').src = slide.img;

                    // Hide all quote bubbles
                    for (let i = 0; i < slides.length; i++) {
                        document.getElementById(`quote-box-${i}`).style.display = 'none';
                    }

                    // Show current quote bubble
                    document.getElementById(`quote-box-${index}`).style.display = 'block';
                });
            });
        </script>

        <!--====== End Hero Section ======-->

        <!--====== Start Category Section ======-->
        <section class="category-section" style="background-color: white;">
            <div class="container">
                <!-- Section Heading -->
                <section class="category-section" style="background-color: white;">
                    <div class="container">
                        <!-- Section Heading -->
                        <div class="text-center mb-5">
                            <h3 class="text-danger fw-bold" style="font-family: 'Times New Roman', serif;">Categories</h3>
                            <div class="category-tabs mt-3" style="font-family: 'Source Sans 3', sans-serif;">
                                <ul class="nav justify-content-center" style="font-size: 14px;">
                                    @foreach ($categories as $cat)
                                        <li class="nav-item" style="border:none;">
                                            <a href="#"
                                                class="nav-link category-tab {{ $loop->first ? 'active' : '' }}"
                                                data-category-id="{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Category Grid -->
                        <div class="row text-center d-flex align-items-center justify-content-center category-items">
                            @foreach ($categories as $cat)
                                @foreach ($cat->subcategories as $subcat)
                                    @if ($loop->index + 1 <= 9)
                                        <div class="col-lg-1  col-md-1 col-sm-12 mb-3 text-center subcategory-box"
                                            data-category-id="{{ $cat->id }}">
                                            <div class="card p-2 subcategory-tab"
                                                data-subcategory-id="{{ $subcat->id }}"
                                                style="cursor: pointer;    width: 100px;border: none;">
                                                <img src="{{ asset('sub-category_images/' . $subcat->image) }}"
                                                    alt="{{ $subcat->title }}"
                                                    style="max-height: 100px; object-fit: contain;"
                                                    class="img-fluid mb-2">
                                                <div class="yellow-base"></div>
                                                <h6 class="mb-0">{{ $subcat->title }}</h6>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </section>
                <!-- Category Grid -->

                <script>
                    function filterProductsByCategory(selectedCategoryId) {
                        // Remove active from all subcategories
                        document.querySelectorAll('.subcategory-tab').forEach(t => t.classList.remove('active'));

                        // Hide all subcategories
                        document.querySelectorAll('.subcategory-box').forEach(box => {
                            box.style.display = 'none';
                        });

                        // Show subcategories of selected category
                        document.querySelectorAll(`.subcategory-box[data-category-id="${selectedCategoryId}"]`)
                            .forEach(box => {
                                box.style.display = 'block';
                            });

                        // Highlight active category
                        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                        document.querySelector(`[data-category-id="${selectedCategoryId}"]`).classList.add('active');

                        const topPicks = document.querySelectorAll('.top-pick-product');
                        const bestSellers = document.querySelectorAll('.best-seller-product');
                        const newArrivals = document.querySelectorAll('.new-arrival-product');

                        // Hide all products first
                        topPicks.forEach(p => p.style.display = 'none');
                        bestSellers.forEach(p => p.style.display = 'none');
                        newArrivals.forEach(p => p.style.display = 'none');

                        // Filter & Show Max 6 for Top Picks
                        let topCount = 0;
                        topPicks.forEach(p => {
                            if (p.dataset.categoryId === selectedCategoryId && p.dataset.isTopPick === '1' && topCount < 6) {
                                p.style.display = 'block';
                                topCount++;
                            }
                        });

                        // Filter & Show Max 6 for Best Sellers
                        let bestCount = 0;
                        bestSellers.forEach(p => {
                            if (p.dataset.categoryId === selectedCategoryId && p.dataset.isBestSeller === '1' && bestCount < 6) {
                                p.style.display = 'block';
                                bestCount++;
                            }
                        });

                        // Filter & Show Max 6 for New Arrivals
                        let newCount = 0;
                        newArrivals.forEach(p => {
                            if (p.dataset.categoryId === selectedCategoryId && p.dataset.isNewArrival === '1' && newCount < 6) {
                                p.style.display = 'block';
                                newCount++;
                            }
                        });

                        // Show/Hide "Product Not Found" messages
                        const noProductMsg = document.getElementById('no-products-msg');
                        const bestNoProductMsg = document.getElementById('best-seller-no-products-msg');
                        const newNoProductMsg = document.getElementById('new-arrival-no-products');

                        if (topCount > 0) {
                            noProductMsg.classList.add('d-none');
                        } else {
                            noProductMsg.classList.remove('d-none');
                        }

                        if (bestCount > 0) {
                            bestNoProductMsg.classList.add('d-none');
                        } else {
                            bestNoProductMsg.classList.remove('d-none');
                        }

                        if (newCount > 0) {
                            newNoProductMsg.classList.add('d-none');
                        } else {
                            newNoProductMsg.classList.remove('d-none');
                        }
                    }

                    function showAllProducts() {
                        const topPicks = document.querySelectorAll('.top-pick-product');
                        const bestSellers = document.querySelectorAll('.best-seller-product');
                        const newArrivals = document.querySelectorAll('.new-arrival-product');

                        // Hide all products first
                        topPicks.forEach(p => p.style.display = 'none');
                        bestSellers.forEach(p => p.style.display = 'none');
                        newArrivals.forEach(p => p.style.display = 'none');

                        // Show Max 6 for Top Picks
                        let topCount = 0;
                        topPicks.forEach(p => {
                            if (p.dataset.isTopPick === '1' && topCount < 6) {
                                p.style.display = 'block';
                                topCount++;
                            }
                        });

                        // Show Max 6 for Best Sellers
                        let bestCount = 0;
                        bestSellers.forEach(p => {
                            if (p.dataset.isBestSeller === '1' && bestCount < 6) {
                                p.style.display = 'block';
                                bestCount++;
                            }
                        });

                        // Show Max 6 for New Arrivals
                        let newCount = 0;
                        newArrivals.forEach(p => {
                            if (p.dataset.isNewArrival === '1' && newCount < 6) {
                                p.style.display = 'block';
                                newCount++;
                            }
                        });

                        // Show/Hide "Product Not Found" messages
                        const noProductMsg = document.getElementById('no-products-msg');
                        const bestNoProductMsg = document.getElementById('best-seller-no-products-msg');
                        const newNoProductMsg = document.getElementById('new-arrival-no-products');

                        if (topCount > 0) {
                            noProductMsg.classList.add('d-none');
                        } else {
                            noProductMsg.classList.remove('d-none');
                        }

                        if (bestCount > 0) {
                            bestNoProductMsg.classList.add('d-none');
                        } else {
                            bestNoProductMsg.classList.remove('d-none');
                        }

                        if (newCount > 0) {
                            newNoProductMsg.classList.add('d-none');
                        } else {
                            newNoProductMsg.classList.remove('d-none');
                        }
                    }

                    document.querySelectorAll('.category-tab').forEach(tab => {
                        tab.addEventListener('click', function(e) {
                            e.preventDefault();
                            const selectedCategoryId = this.dataset.categoryId;
                            filterProductsByCategory(selectedCategoryId);
                        });
                    });

                    // Show all products on page load
                    window.addEventListener('DOMContentLoaded', () => {
                        showAllProducts();
                        
                        // Show first category subcategories by default
                        const firstTab = document.querySelector('.category-tab');
                        if (firstTab) {
                            const firstCategoryId = firstTab.dataset.categoryId;
                            document.querySelectorAll('.subcategory-box').forEach(box => {
                                if (box.dataset.categoryId === firstCategoryId) {
                                    box.style.display = 'block';
                                } else {
                                    box.style.display = 'none';
                                }
                            });
                            firstTab.classList.add('active');
                        }
                    });
                </script>




                <script>
                    function filterProductsBySubcategory(subcatId) {
                        // Remove active from all subcategories
                        document.querySelectorAll('.subcategory-tab').forEach(t => t.classList.remove('active'));
                        // Add active to clicked subcategory
                        document.querySelector(`[data-subcategory-id="${subcatId}"]`).classList.add('active');

                        // Hidden input
                        document.getElementById('selectedSubcategory').value = subcatId;

                        const topPicks = document.querySelectorAll('.top-pick-product');
                        const bestSellers = document.querySelectorAll('.best-seller-product');
                        const newArrivals = document.querySelectorAll('.new-arrival-product');

                        // Hide all products first
                        topPicks.forEach(p => p.style.display = 'none');
                        bestSellers.forEach(p => p.style.display = 'none');
                        newArrivals.forEach(p => p.style.display = 'none');

                        // Filter & Show Max 6 for Top Picks
                        let topCount = 0;
                        topPicks.forEach(p => {
                            if (p.dataset.subcategoryId === subcatId && p.dataset.isTopPick === '1' && topCount < 6) {
                                p.style.display = 'block';
                                topCount++;
                            }
                        });

                        // Filter & Show Max 6 for Best Sellers
                        let bestCount = 0;
                        bestSellers.forEach(p => {
                            if (p.dataset.subcategoryId === subcatId && p.dataset.isBestSeller === '1' && bestCount < 6) {
                                p.style.display = 'block';
                                bestCount++;
                            }
                        });

                        // Filter & Show Max 6 for New Arrivals
                        let newCount = 0;
                        newArrivals.forEach(p => {
                            if (p.dataset.subcategoryId === subcatId && p.dataset.isNewArrival === '1' && newCount < 6) {
                                p.style.display = 'block';
                                newCount++;
                            }
                        });

                        // Show/Hide "Product Not Found" messages
                        const noProductMsg = document.getElementById('no-products-msg');
                        const bestNoProductMsg = document.getElementById('best-seller-no-products-msg');
                        const newNoProductMsg = document.getElementById('new-arrival-no-products');

                        if (topCount > 0) {
                            noProductMsg.classList.add('d-none');
                        } else {
                            noProductMsg.classList.remove('d-none');
                        }

                        if (bestCount > 0) {
                            bestNoProductMsg.classList.add('d-none');
                        } else {
                            bestNoProductMsg.classList.remove('d-none');
                        }

                        if (newCount > 0) {
                            newNoProductMsg.classList.add('d-none');
                        } else {
                            newNoProductMsg.classList.remove('d-none');
                        }
                    }

                    document.querySelectorAll('.subcategory-tab').forEach(tab => {
                        tab.addEventListener('click', function() {
                            const subcatId = this.dataset.subcategoryId;
                            filterProductsBySubcategory(subcatId);
                        });
                    });
                </script>


                <!--====== End Category Section ======-->
                <!-- Price Range -->
                {{-- <div class="price-filter mt-4 mb-4 p-3 rounded shadow-sm bg-light">
                    <label class="form-label fw-bold text-dark mb-2">Price Range</label>

                    <!-- Labels -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary px-3 py-2"> <small id="minPriceLabel">0</small></span>
                        <span class="badge bg-success px-3 py-2"> <small id="maxPriceLabel">10000</small></span>
                    </div>

                    <!-- Range Slider -->
                    <div class="range-slider position-relative">
                        <input type="range" id="minPrice" min="0" max="10000" value="0"
                            step="100" class="form-range custom-range">
                        <input type="range" id="maxPrice" min="0" max="10000" value="10000"
                            step="100" class="form-range custom-range">
                    </div>
                </div>
                <!-- Product Listing -->
                <div id="product-list" class="row">
                </div> --}}






            </div>

            {{-- <div class="row" id="productsContainer">
                @foreach ($products as $prod)
                    @php

                        $variantsCount = $prod->variants->count() ?? 0;
                      
                        $minPrice = $variantsCount
                            ? $prod->variants->min('discounted_price') ?? $prod->variants->min('price')
                            : null;
                        $maxPrice = $variantsCount
                            ? $prod->variants->max('discounted_price') ?? $prod->variants->max('price')
                            : null;
                    @endphp
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 allProducts"
                        data-category="{{ $prod->category_id }}" data-subcategory-id="{{ $prod->sub_category_id }}"
                        data-price-min="{{ $minPrice !== null ? $minPrice : '' }}"
                        data-price-max="{{ $maxPrice !== null ? $maxPrice : '' }}"
                        data-variants-count="{{ $variantsCount }}">
                        <div class="card trophy-card text-center shadow-md">
                            <a href="{{ route('productDetail', $prod->id) }}">
                                <div class="position-relative">
                                    <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                        class="img-fluid"
                                        style="height: 150px; width: 100%; object-fit: contain;padding:10px;" />

                                    <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                        <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                            data-product-id="{{ $prod->id }}" title="Toggle Wishlist"></i>

                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                            <input type="hidden" name="variant_id"
                                                value="{{ $prod->variants->first()->id ?? '' }}">
                                            @php
                                                $firstVariant = $prod->variants->first();
                                                $firstColor = '';

                                                if ($firstVariant && $firstVariant->color) {
                                                    $decoded = is_string($firstVariant->color)
                                                        ? json_decode($firstVariant->color, true)
                                                        : $firstVariant->color;
                                                    $firstColor = is_array($decoded) ? $decoded[0] ?? '' : $decoded;
                                                }
                                            @endphp

                                            <input type="hidden" name="color" id="selectedColor"
                                                value="{{ $firstColor }}">
                                            <button type="submit" class="add-to-cart-btn">Add To
                                                Cart</button>
                                        </form>

                                        <i class="fas fa-share icon-toggle share-icon"
                                            data-share-link="{{ route('productDetail', $prod->id) }}"></i>
                                    </div>
                                </div>

                                <div class="card-body py-2">
                                    <p class="mb-1 product-id">
                                        {{ Str::limit($prod->title, 25) }}</p>
                                    <p class="mb-0 text-danger fw-bold">
                                        {{ $prod->variants->first()?->discounted_price ?? 'N/A' }} Rs
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div> --}}


            <!--====== Start Explore Our Top Picks Section ======-->
            @php
                use Illuminate\Support\Str;
            @endphp


            <section class="trophy-section py-5" style="background-color: white;">
                <div class="container-fluid">
                    <h4 class="text-center mb-5 text-danger fw-bold" style="font-family: 'Source Sans 3', sans-serif;">
                        "Explore Our Top Picks"
                    </h4>
                    <div class="row justify-content-center text-center">
                        <div class="trophy-card-wrapper position-relative py-5">
                            <div class="hover-yellow-bg d-none d-sm-block"></div>
                            <div class="row justify-content-center text-center position-relative">
                                <!-- <div class="row justify-content-center text-center py-5"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="background: linear-gradient(90deg, #fff7dc, #FFDE57);"> -->

                                <!-- Product Not Found Message -->
                                <p class="text-center text-danger fw-bold d-none" id="no-products-msg">
                                    <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                                    No Products Found.
                                </p>

                                <!-- Product Card Wrapper -->
                                <!-- <div class="trophy-card-wrapper position-relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row justify-content-center text-center position-relative" id="products-wrapper"> -->
                                @php $hasTopPick = false; @endphp
                                @foreach ($products as $prod)
                                    @php
                                        $hasTopPick = true;
                                        $variantsCount = $prod->variants->count() ?? 0;
                                        // Prefer discounted_price if you show discounted prices; fallback to regular price
                                        $minPrice = $variantsCount
                                            ? $prod->variants->min('discounted_price') ?? $prod->variants->min('price')
                                            : null;
                                        $maxPrice = $variantsCount
                                            ? $prod->variants->max('discounted_price') ?? $prod->variants->max('price')
                                            : null;
                                    @endphp
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 top-pick-product"
                                        data-category="{{ $prod->category_id }}"
                                        data-subcategory-id="{{ $prod->sub_category_id }}"
                                        data-is-top-pick="{{ $prod->is_top_pick }}"
                                        data-is-best-seller="{{ $prod->is_best_seller }}"
                                        data-is-new-arrival="{{ $prod->is_new_arrival }}"
                                        data-price-min="{{ $minPrice !== null ? $minPrice : '' }}"
                                        data-price-max="{{ $maxPrice !== null ? $maxPrice : '' }}"
                                        data-variants-count="{{ $variantsCount }}" style="display: none;">
                                        <div class="card trophy-card text-center shadow-md">
                                            <a href="{{ route('productDetail', $prod->id) }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('product_images/' . $prod->image) }}"
                                                        alt="Trophy" class="img-fluid"
                                                        style="height: 150px; width: 100%; object-fit: contain;padding:10px;" />

                                                    <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                                        <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                            data-product-id="{{ $prod->id }}"
                                                            title="Toggle Wishlist"></i>

                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $prod->id }}">
                                                            <input type="hidden" name="variant_id"
                                                                value="{{ $prod->variants->first()->id ?? '' }}">
                                                            @php
                                                                $firstVariant = $prod->variants->first();
                                                                $firstColor = '';

                                                                if ($firstVariant && $firstVariant->color) {
                                                                    $decoded = is_string($firstVariant->color)
                                                                        ? json_decode($firstVariant->color, true)
                                                                        : $firstVariant->color;
                                                                    $firstColor = is_array($decoded)
                                                                        ? $decoded[0] ?? ''
                                                                        : $decoded;
                                                                }
                                                            @endphp

                                                            <input type="hidden" name="color" id="selectedColor"
                                                                value="{{ $firstColor }}">
                                                            <button type="submit" class="add-to-cart-btn">Add To
                                                                Cart</button>
                                                        </form>

                                                        {{-- <i class="fas fa-share icon-toggle"></i> --}}
                                                        <i class="fas fa-share icon-toggle share-icon"
                                                            data-share-link="{{ route('productDetail', $prod->id) }}"></i>
                                                    </div>
                                                </div>

                                                <div class="card-body py-2">
                                                    <p class="mb-1 product-id">
                                                        {{ Str::limit($prod->title, 25) }}</p>
                                                    <p class="mb-0 text-danger fw-bold">
                                                        {{ $prod->variants->first()?->discounted_price ?? 'N/A' }} Rs
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                                <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @if (!$hasTopPick)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('no-products-msg').classList.remove('d-none');
        });
    </script>
    @endif -->
                            </div>
                        </div>

                        <!-- See More Button -->
                        <input type="hidden" id="selectedSubcategory" value="">
                        {{--  <div class="text-center mt-4 w-100">
                                <a href="{{ route('viewproducts') }}" class="see-more-btn">See More</a>
                            </div>  --}}

                        <div class="text-center mt-4 w-100">
                            <a href="#" class="see-more-btn">See More</a>
                        </div>

                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                const firstTab = document.querySelector('.category-tab');
                                if (firstTab) {
                                    firstTab.click();
                                }
                            });
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const categories = document.querySelectorAll(".category-tab");
                                const subcategories = document.querySelectorAll(".subcategory-tab");

                                const topPicks = document.querySelectorAll(".product-card[data-is-top-pick='1']");
                                const bestSellers = document.querySelectorAll(".product-card[data-is-best-seller='1']");
                                const newArrivals = document.querySelectorAll(".product-card[data-is-new-arrival='1']");


                                function filterProducts(selectedCategoryId = null, selectedSubcategoryId = null) {
                                    let topCount = 0,
                                        bestCount = 0,
                                        newCount = 0;

                                    // Top Picks
                                    topPicks.forEach(p => {
                                        if (
                                            (!selectedCategoryId || p.dataset.categoryId === selectedCategoryId) &&
                                            (!selectedSubcategoryId || p.dataset.subcategoryId === selectedSubcategoryId) &&
                                            topCount < 6
                                        ) {
                                            p.style.display = "block";
                                            topCount++;
                                        } else {
                                            p.style.display = "none";
                                        }
                                    });

                                    // Best Sellers
                                    bestSellers.forEach(p => {
                                        if (
                                            (!selectedCategoryId || p.dataset.categoryId === selectedCategoryId) &&
                                            (!selectedSubcategoryId || p.dataset.subcategoryId === selectedSubcategoryId) &&
                                            bestCount < 6
                                        ) {
                                            p.style.display = "block";
                                            bestCount++;
                                        } else {
                                            p.style.display = "none";
                                        }
                                    });

                                    // New Arrivals
                                    newArrivals.forEach(p => {
                                        if (
                                            (!selectedCategoryId || p.dataset.categoryId === selectedCategoryId) &&
                                            (!selectedSubcategoryId || p.dataset.subcategoryId === selectedSubcategoryId) &&
                                            newCount < 6
                                        ) {
                                            p.style.display = "block";
                                            newCount++;
                                        } else {
                                            p.style.display = "none";
                                        }
                                    });
                                }

                                // Handle category click
                                categories.forEach(cat => {
                                    cat.addEventListener("click", () => {
                                        const categoryId = cat.dataset.categoryId;
                                        filterProducts(categoryId, null);
                                    });
                                });

                                // Handle subcategory click
                                subcategories.forEach(sub => {
                                    sub.addEventListener("click", () => {
                                        const categoryId = sub.dataset.categoryId;
                                        const subcategoryId = sub.dataset.subcategoryId;
                                        filterProducts(categoryId, subcategoryId);
                                    });
                                });

                                // On page load → Show first category products
                                if (categories.length > 0) {
                                    const firstCategoryId = categories[0].dataset.categoryId;
                                    filterProducts(firstCategoryId, null);
                                }
                            });
                        </script>
                        {{-- script to fetch products according to subcat --}}
                        {{-- <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // सर्व subcategory tabs select कर
                                document.querySelectorAll('.subcategory-tab').forEach(tab => {
                                    tab.addEventListener('click', function() {
                                        const subcatId = this.dataset.subcategoryId;

                                        // Hidden input मध्ये value सेट कर
                                        document.getElementById('selectedSubcategory').value = subcatId;
                                    });
                                });

                                // See More button click handle कर
                                document.querySelector('.see-more-btn').addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const subcatId = document.getElementById('selectedSubcategory').value;

                                    if (subcatId) {
                                        window.location.href = `{{ route('viewproducts') }}?subcategory=${subcatId}`;

                                    } else {
                                        window.location.href = `{{ route('viewproducts') }}`;
                                    }
                                });
                            });
                        </script> --}}

                    </div>
                </div>
            </section>



        </section> -->

        <!--====== End Explore Our Top Picks Section ======-->

        <!--====== Start Our Best Sellers Section ======-->
        <section class="trophy-section py-5" style="background-color:white; font-family: 'Times New Roman', serif;">
            <div class="container-fluid">
                <h4 class="text-center mb-5"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    "Our Best Sellers"
                </h4>

                <div class="row justify-content-center text-center">
                    <div class="trophy-card-wrapper position-relative py-5">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">


                            <!-- Product Not Found Message -->
                            <p class="text-center text-danger fw-bold d-none" id="best-seller-no-products-msg">
                                <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                                No Products Found.
                            </p>


                            @php $hasBestSellers = false; @endphp

                            <div class="row  justify-content-center text-center" id="">
                                @foreach ($products as $prod)
                                    @php $hasBestSellers = true; @endphp
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 best-seller-product"
                                        data-category-id="{{ $prod->category_id }}"
                                        data-subcategory-id="{{ $prod->sub_category_id }}"
                                        data-is-top-pick="{{ $prod->is_top_pick }}"
                                        data-is-best-seller="{{ $prod->is_best_seller }}"
                                        data-is-new-arrival="{{ $prod->is_new_arrival }}"
                                        data-price="{{ $prod->variants->first()->discounted_price ?? 0 }}"
                                        data-colors="{{ implode(',', $prod->variants->pluck('color')->flatten()->unique()->toArray()) }}"
                                        data-sizes="{{ implode(',', $prod->variants->pluck('size')->unique()->toArray()) }}"
                                        style="display: none;">

                                        <div class="card trophy-card text-center shadow-md" style="height: 100%;">
                                            <a href="{{ route('productDetail', $prod->id) }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('product_images/' . $prod->image) }}"
                                                        alt="{{ $prod->title }}" class="img-fluid"
                                                        style="height: 150px; width: 100%; object-fit: contain; padding:10px;" />

                                                    {{-- hover bar --}}
                                                    <div class="trophy-hover-bar">
                                                        {{-- wishlist toggle --}}
                                                        <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                            data-product-id="{{ $prod->id }}"
                                                            title="Toggle Wishlist"></i>

                                                        {{-- add to cart --}}
                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $prod->id }}">
                                                            <input type="hidden" name="variant_id"
                                                                value="{{ $prod->variants->first()->id ?? '' }}">

                                                            @php
                                                                $firstVariant = $prod->variants->first();
                                                                $firstColor = '';

                                                                if ($firstVariant && $firstVariant->color) {
                                                                    $decoded = is_string($firstVariant->color)
                                                                        ? json_decode($firstVariant->color, true)
                                                                        : $firstVariant->color;
                                                                    $firstColor = is_array($decoded)
                                                                        ? $decoded[0] ?? ''
                                                                        : $decoded;
                                                                }
                                                            @endphp

                                                            <input type="hidden" name="color" id="selectedColor"
                                                                value="{{ $firstColor }}">
                                                            <button type="submit" class="add-to-cart-btn">Add To
                                                                Cart</button>
                                                        </form>

                                                        <i class="fas fa-share icon-toggle"></i>
                                                    </div>
                                                </div>

                                                <div class="card-body py-2">
                                                    <p class="mb-1 product-id">{{ $prod->title }}</p>
                                                    <p class="mb-0 text-danger fw-bold">
                                                        {{ $prod->variants->first()->discounted_price ?? 'N/A' }} Rs
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>



                        </div>
                    </div>

                    <!-- See More Button -->
                    <div class="text-center mt-4 w-100">
                        <a href="{{ route('viewproducts') }}" class="see-more-btn">See More</a>
                    </div>
                </div>
            </div>
        </section>



        <!--====== End Our Best Sellers Section ======-->

        <!--====== Start New Arrivals Section ======-->
        <section class="trophy-section py-5" style="background-color:white; font-family: 'Times New Roman', serif;">
            <div class="container-fluid">
                <h4 class="text-center mb-5"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    "New Arrivals"
                </h4>

                <div class="row justify-content-center text-center">
                    <div class="trophy-card-wrapper position-relative py-5">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">

                            <!-- Product Not Found Message -->
                            <p class="text-center text-danger fw-bold d-none" id="new-arrival-no-products">
                                <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                                No Products Found.
                            </p>

                            @php $hasNewArrivals = false; @endphp

                            <div class="row justify-content-center text-center" id="">
                                @foreach ($products as $prod)
                                    @php $hasNewArrivals = true; @endphp
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 new-arrival-product"
                                        data-category-id="{{ $prod->category_id }}"
                                        data-subcategory-id="{{ $prod->sub_category_id }}"
                                        data-is-top-pick="{{ $prod->is_top_pick }}"
                                        data-is-best-seller="{{ $prod->is_best_seller }}"
                                        data-is-new-arrival="{{ $prod->is_new_arrival }}"
                                        data-price="{{ $prod->variants->first()->discounted_price ?? 0 }}"
                                        data-colors="{{ implode(',', $prod->variants->pluck('color')->flatten()->unique()->toArray()) }}"
                                        data-sizes="{{ implode(',', $prod->variants->pluck('size')->unique()->toArray()) }}"
                                        style="display: none;">

                                        <div class="card trophy-card text-center shadow-md" style="height: 100%;">
                                            <a href="{{ route('productDetail', $prod->id) }}">
                                                <div class="position-relative">
                                                    <img src="{{ asset('product_images/' . $prod->image) }}"
                                                        alt="{{ $prod->title }}" class="img-fluid"
                                                        style="height: 150px; width: 100%; object-fit: contain; padding:10px;" />

                                                    {{-- hover bar --}}
                                                    <div class="trophy-hover-bar">
                                                        {{-- wishlist toggle --}}
                                                        <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                            data-product-id="{{ $prod->id }}"
                                                            title="Toggle Wishlist"></i>

                                                        {{-- add to cart --}}
                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $prod->id }}">
                                                            <input type="hidden" name="variant_id"
                                                                value="{{ $prod->variants->first()->id ?? '' }}">

                                                            @php
                                                                $firstVariant = $prod->variants->first();
                                                                $firstColor = '';

                                                                if ($firstVariant && $firstVariant->color) {
                                                                    $decoded = is_string($firstVariant->color)
                                                                        ? json_decode($firstVariant->color, true)
                                                                        : $firstVariant->color;
                                                                    $firstColor = is_array($decoded)
                                                                        ? $decoded[0] ?? ''
                                                                        : $decoded;
                                                                }
                                                            @endphp

                                                            <input type="hidden" name="color" id="selectedColor"
                                                                value="{{ $firstColor }}">
                                                            <button type="submit" class="add-to-cart-btn">Add To
                                                                Cart</button>
                                                        </form>

                                                        <i class="fas fa-share icon-toggle"></i>
                                                    </div>
                                                </div>

                                                <div class="card-body py-2">
                                                    <p class="mb-1 product-id">{{ $prod->title }}</p>
                                                    <p class="mb-0 text-danger fw-bold">
                                                        {{ $prod->variants->first()->discounted_price ?? 'N/A' }} Rs
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!-- See More Button -->
                    <div class="text-center mt-4 w-100">
                        <a href="{{ route('viewproducts') }}" class="see-more-btn">See More</a>
                    </div>
                </div>
            </div>
        </section>

        <!--====== End New Arrivals Section ======-->

        <!--======Celebrate the moments Sections  ======-->
        @if ($occProducts->isNotEmpty())
            <section class="container-fluid testimonial-section py-5 bg-white">
                <!--@php $occProducts @endphp-->
                <div class="container">
                    <div class="row align-items-center mb-4">

                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="custom-card text-center p-0 overflow-hidden">

                                <div class="py-4" id="card-header">
                                    <img src="{{ asset('occasion_images/') }}" alt="occasion image"
                                        style="max-width: 100px;">
                                </div>

                                <div class="list-group list-group-flush" id="list-view"
                                    style="font-family: 'Source Sans 3', sans-serif;">
                                    <div class="list-group-item custom-item bg-light-yellow text-dark hover-yellow">
                                        <span style="font-weight: 600;">Designed for the Day</span>
                                        <button
                                            class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                            onclick="showDetail(0)">→</button>
                                    </div>
                                    <div class="list-group-item custom-item bg-light-red text-dark hover-red">
                                        <span style="font-weight: 600;">Limited Editions, Big Impact</span>
                                        <button
                                            class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                            onclick="showDetail(1)">→</button>
                                    </div>
                                    <div class="list-group-item custom-item bg-light-yellow text-dark hover-yellow">
                                        <span style="font-weight: 600;">A Keepsake to Remember</span>
                                        <button
                                            class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                            onclick="showDetail(2)">→</button>
                                    </div>
                                    <div class="list-group-item custom-item bg-light-red text-dark hover-red">
                                        <span style="font-weight: 600;">Personalized Just for Them</span>
                                        <button
                                            class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                            onclick="showDetail(3)">→</button>
                                    </div>
                                </div>

                                <div class="p-3 bg-light-yellow text-start d-none" id="detail-view"
                                    style="font-family: 'Source Sans 3', sans-serif;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong id="detail-title">Title</strong>
                                        <button
                                            class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                            onclick="backToList()">↗</button>

                                    </div>
                                    <p class="mt-2" id="detail-desc">
                                    </p>
                                </div>
                            </div>
                        </div>


                        <script>
                            const detailData = [{
                                    title: "Designed for the Day",
                                    desc: "At Trophy House, every occasion takes center stage. Our limited edition trophies are thoughtfully crafted to capture the emotion and significance of your special moments. Celebrate milestones with a gift that creates lasting memories."
                                },
                                {
                                    title: "Limited Editions, Big Impact",
                                    desc: "Our seasonal collections are available exclusively for limited periods, making each trophy truly unique. By choosing from these special editions, you give a gift that stands out and feels one-of-a-kind. Celebrate meaningful moments with a rare keepsake that captures the spirit of the season."
                                },
                                {
                                    title: "A Keepsake to Remember",
                                    desc: "More than just a gesture, our trophies are crafted to endure through time. They serve as lasting reminders of love, appreciation, and heartfelt recognition. Every piece tells a story that keeps the special moment alive forever."
                                },
                                {
                                    title: "Personalized Just for Them",
                                    desc: "Add personalized names, dates, or heartfelt messages to make each trophy uniquely yours. Transform a beautiful award into a treasured keepsake full of meaning and memories. Give a gift that they’ll cherish and remember for a lifetime."
                                }
                            ];

                            function showDetail(index) {
                                document.getElementById('list-view').classList.add('d-none');
                                document.getElementById('detail-view').classList.remove('d-none');
                                document.getElementById('detail-title').innerText = detailData[index].title;
                                document.getElementById('detail-desc').innerText = detailData[index].desc;
                            }

                            function backToList() {
                                document.getElementById('list-view').classList.remove('d-none');
                                document.getElementById('detail-view').classList.add('d-none');
                            }
                        </script>

                        <div class="col-lg-9 col-md-12">
                            <h2 class="text-danger fw-bold mb-2" style="font-family: 'Times New Roman', serif;">
                                Celebrate the
                                moment</h2>

                            <h5 class="fw-bold mb-3" style="font-family: 'Source Sans 3', sans-serif;">
                                Celebrate Dad in Style — Limited Edition Trophies Available Now!
                            </h5>
                            <p class="text-muted mb-4" style="font-family: 'Source Sans 3', sans-serif;">
                                Make this Father’s Day unforgettable with a trophy that says it all. Our limited
                                edition designs
                                are crafted to honor <br>the strength, love, and support only a dad can give. Shop
                                now and give
                                him the recognition he truly deserves!
                            </p>


                            <div class="d-flex flex-wrap gap-5 justify-content-start">
                                <div class = "occasional-slider-section">
                                    <div class="product-section">
                                        <div class="occasional-slider-container" id="occasionSlider">
                                            @foreach ($occProducts as $product)
                                                @php
                                                    $image =
                                                        $product->images->first()->image ??
                                                        'website/assets/images/Trophy.png';
                                                    $variant = $product->variants->first();
                                                    $price = $variant->discounted_price ?? ($variant->price ?? 0);
                                                @endphp
                                                <div class="card trophy-card occProduct-trophy-card text-center shadow-sm">
                                                    <a href="{{ route('productDetail', $product->id) }}">
                                                        <div class="position-relative p-2">
                                                            <img src="{{ asset('OccasionalProduct_images/' . $product->image) }}"
                                                                alt="{{ $product->title }}" class="img-fluid"
                                                                style="max-height: 150px; width: 100%; object-fit: contain;" />

                                                            <div class="trophy-hover-bar">
                                                                <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($product->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                                    data-product-id="{{ $product->id }}"
                                                                    title="Toggle Wishlist"></i>

                                                                <form action="{{ route('cart.add') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $prod->id }}">
                                                                    <button type="submit" class="add-to-cart-btn">Add
                                                                        To
                                                                        Cart</button>
                                                                </form>
                                                                <!--<i class="fas fa-share icon-toggle"></i>-->
                                                                <i class="fas fa-share icon-toggle share-icon"
                                                                    data-share-link="{{ route('productDetail', $prod->id) }}"></i>
                                                            </div>
                                                        </div>
                                                        <div class="card-body py-2">
                                                            <p class="mb-1 product-id">{{ $product->id }}</p>
                                                            <p class="mb-0 text-danger fw-bold">
                                                                {{ $price }} Rs</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <!--<img src="{{ asset('website/assets/images/homePage/carousal-right.png') }}" alt="images"-->
                                <!--    style="height: 35px;position: relative;left: 795px;bottom: 121px;">-->
                                @if ($occProducts->count() > 3)
                                    <img src="{{ asset('website/assets/images/homePage/carousal-right.png') }}"
                                        alt="Next" class="slider-right-arrow" id="occasionArrow"
                                        style="height: 35px;position: relative;left: 795px;bottom: 121px;">
                                @endif

                            </div>
                        </div>
                        <script>
                            document.getElementById('occasionArrow')?.addEventListener('click', function() {
                                const container = document.getElementById('occasionSlider');
                                const card = container.querySelector('.trophy-card');
                                const scrollAmount = card.offsetWidth + 30;
                                container.scrollBy({
                                    left: scrollAmount * 1,
                                    behavior: 'smooth'
                                });
                            });
                        </script>

                    </div>
            </section>
        @endif
        <!--====== End Celebrate the momentss Sections  ======-->


        <!--====== Start New Arrivals Section ======-->
        <section class="trophy-section py-5" style="font-family: 'Times New Roman', serif; background-color:white;">
            <div class="container-fluid">
                <p class="text-center mb-5"
                    style="color: #e63946;font-family: 'Source Sans 3', sans-serif;font-weight: bold;font-size: 24px;">
                    "New Arrivals"
                </p>

                <div class="row justify-content-center text-center">
                    <div class="trophy-card-wrapper position-relative py-5">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">
                            <!-- <div class="row justify-content-center text-center py-5"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 style="background: linear-gradient(90deg, #fff7dc, #FFDE57);"> -->

                            <!-- No Products Message -->
                            <p class="text-center text-danger fw-bold d-none" id="new-arrival-no-products">
                                <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                                No Products Found.
                            </p>

                            <!-- <div class="trophy-card-wrapper position-relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row justify-content-center text-center position-relative" id="new-arrival-wrapper"> -->
                            @php $hasNewArrivals = false; @endphp
                            @foreach ($products as $prod)
                                @php $hasNewArrivals = true; @endphp
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 new-arrival-product"
                                    data-subcategory-id="{{ $prod->sub_category_id }}"
                                    data-is-top-pick="{{ $prod->is_top_pick }}"
                                    data-is-best-seller="{{ $prod->is_best_seller }}"
                                    data-is-new-arrival="{{ $prod->is_new_arrival }}" style="display: none;">
                                    <div class="card trophy-card text-center shadow-md" style="height: 100%;">
                                        <a href="{{ route('productDetail', $prod->id) }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                                    class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: contain;padding:10px;" />
                                                <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                                    <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                        data-product-id="{{ $prod->id }}"
                                                        title="Toggle Wishlist"></i>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $prod->id }}">
                                                        <input type="hidden" name="variant_id"
                                                            value="{{ $prod->variants->first()->id ?? '' }}">
                                                        <button type="submit" class="add-to-cart-btn">Add To

                                                            Cart</button>
                                                    </form>
                                                    <!--<i class="fas fa-share icon-toggle"></i>-->
                                                    <i class="fas fa-share icon-toggle share-icon"
                                                        data-share-link="{{ route('productDetail', $prod->id) }}"></i>
                                                </div>
                                            </div>
                                            <div class="card-body pt-2 pb-1">
                                                <p class="mb-1 product-id">
                                                    {{ Str::limit($prod->title, 25) }}</p>
                                                <p class="text-danger fw-bold mb-0">
                                                    {{ $prod->variants->first()?->price ?? 'No price disclosed' }}
                                                    Rs
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            <!-- @if (!$hasNewArrivals)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('new-arrival-no-products').classList.remove('d-none');
        });
    </script>
    @endif -->
                        </div>
                    </div>

                    <!-- See More Button -->
                    <div class="text-center mt-4 w-100">
                        <a href="{{ route('viewproducts') }}" class="see-more-btn">See More</a>
                    </div>
                </div>
            </div>
        </section>


        <!-- <section class="trophy-section py-5" style="font-family: 'Times New Roman', serif; background-color:white">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="container-fluid">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-center mb-5"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               style="color: #e63946;font-family: 'Source Sans 3', sans-serif;font-weight: bold;font-size: 24px;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                "New Arrivals"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="row justify-content-center text-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="trophy-card-wrapper position-relative py-5">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="hover-yellow-bg d-none d-sm-block"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="row justify-content-center text-center position-relative">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @foreach ($products as $prod)
    @if ($prod->is_new_arrival == 1 && $loop->index + 1 <= 6)
    <div class="col-12 d-flex justify-content-center d-sm-block col-sm-4 col-md-3 col-lg-2 mb-4 new-arrival-product"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     data-subcategory-id="{{ $prod->sub_category_id }}" style="display: none;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="card trophy-card text-center shadow-md" style="height: 100%;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <a href="{{ route('productDetail', $prod->id) }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="position-relative">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <img src="{{ asset('product_images/' . $prod->image) }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     alt="Trophy" class="img-fluid"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     style="height: 150px; width: 100%; object-fit: contain; margin-bottom: 0;" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       data-product-id="{{ $prod->id }}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       title="Toggle Wishlist"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @csrf
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </form>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="fas fa-share icon-toggle"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="card-body pt-2 pb-1">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <p class="mb-1 product-id">{{ Str::limit($prod->title, 25) }}</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $first = $prod->variants->first();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                @endphp
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <p class="text-danger fw-bold mb-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $first ? $first->price . ' Rs' : 'No price disclosed' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
    @endif
    @endforeach

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div id="new-arrival-no-products" class="no-products" style="display: none;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            No New Arrival products found for this subcategory.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="text-center mt-4 w-100">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="{{ route('viewproducts') }}" class="see-more-btn">See More</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </section> -->

        <!--====== End New Arrivals Section ======-->

        <!-- How it Works === -->
        <section class="how-it-works-section">
            <div class="container">
                <p
                    class="section-title"style="font-family: 'Times New Roman', serif;padding-top: -9px;bottom: 51px;position: relative;font-size:36px">
                    How It Works</p>
                <div class="how-it-works-image">
                    <img src="{{ asset('website/assets/images/homePage/howItWorks.png') }}" alt="How It Works Steps" />
                </div>
            </div>
        </section>
        <!-- How it Works === -->

        <!--====== Start Clients List Section ======-->
        {{-- <section class="animated-headline-area pt-25" id="about-us"
            style="background-color: white;padding-bottom: 75px;">
            <div class="headline-wrap style-one text-center mb-3">
                <p
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif; text-transform: none;">
                    Client List
                </p>
            </div>
            <div class="headline-wrap style-one">
                <div class="marquee-wrap">
                    <div class="marquee-inner left d-flex align-items-center">
                        @foreach ($clients as $client)
                            <div class="logo-item">
                                <img src="{{ asset('client_images/' . $client->image) }}" alt="himalaya"
                                    style="width: 120px; height: 60px;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section> --}}
        <!--====== Start Clients List Section ======-->
        <section class="animated-headline-area pt-25" id="about-us"
            style="background-color: white; padding-bottom: 75px;">
            <div class="headline-wrap style-one text-center mb-3">
                <p
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif; text-transform: none;">
                    Client List
                </p>
            </div>
            <div class="headline-wrap style-one">
                <!--<div class="marquee-wrap">-->
                <!--    <div class="marquee-inner left d-flex align-items-center animate-marquee">-->
                <!-- First set of images -->
                <!--        @foreach ($clients as $client)
    -->
                <!--            <div class="logo-item">-->
                <!--                <img src="{{ asset('client_images/' . $client->image) }}"-->
                <!--                    alt="{{ $client->name ?? 'Client' }}"-->
                <!--                    style="width: 120px; height: 60px; margin: 0 10px;">-->
                <!--            </div>-->
                <!--
    @endforeach-->
                <!-- Duplicated set of images for seamless looping -->
                <!--        @foreach ($clients as $client)
    -->
                <!--            <div class="logo-item">-->
                <!--                <img src="{{ asset('client_images/' . $client->image) }}"-->
                <!--                    alt="{{ $client->name ?? 'Client' }}"-->
                <!--                    style="width: 120px; height: 60px; margin: 0 10px;">-->
                <!--            </div>-->
                <!--
    @endforeach-->
                <!--    </div>-->
                <!--</div>-->
                <div class="">
                    <div class=" d-flex align-items-center " style="flex-wrap: wrap;
    justify-content: center;">

                        @foreach ($clients as $client)
                            <div class="logo-item">
                                <img src="{{ asset('client_images/' . $client->image) }}"
                                    alt="{{ $client->name ?? 'Client' }}"
                                    style="width: 120px; height: 60px; margin: 0 10px;">
                            </div>
                        @endforeach
                        <!-- Duplicated set of images for seamless looping -->
                        <!--@foreach ($clients as $client)
    -->
                        <!--    <div class="logo-item">-->
                        <!--        <img src="{{ asset('client_images/' . $client->image) }}"-->
                        <!--            alt="{{ $client->name ?? 'Client' }}"-->
                        <!--            style="width: 120px; height: 60px; margin: 0 10px;">-->
                        <!--    </div>-->
                        <!--
    @endforeach-->
                    </div>
                </div>
            </div>
        </section>
        <!--====== End Clients List Section ======-->

        <!-- Additional CSS for Animation -->
        <style>
            .marquee-wrap {
                overflow: hidden;
                /* Hides overflow to create the scrolling effect */
                white-space: nowrap;
                /* Prevents line breaks */
            }

            .marquee-inner {
                display: flex;
                align-items: center;
            }

            .animate-marquee {
                animation: marquee 20s linear infinite;
                /* Continuous animation */
            }

            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }

                /* Moves half the width to loop seamlessly */
            }

            /* Optional: Pause on hover */
            .animate-marquee:hover {
                animation-play-state: paused;
            }

            /* Adjust based on the total width of images */
            @media (max-width: 576px) {
                .animate-marquee {
                    animation: marquee 15s linear infinite;
                    /* Faster on mobile */
                }
            }
        </style>
        <!--====== End Clients List Section ======-->

        <!--====== start About us Section ======-->

        <!-- About Us Section -->
        <section class="about-us-section py-10" id="about-us">
            <div class="container">
                <p class="text-center"
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif;">
                    About Us
                </p>


                <div class="position-relative overflow-hidden" style="min-height: 500px;">
                    <div id="aboutus-view-1" class="aboutus-view slide-active">
                        <!-- List View -->
                        <div id="aboutus-list-view">
                            <div class="row align-items-start">
                                <!-- Left side description -->
                                <div class="col-md-7 pb-0 position-relative"
                                    style="font-family: 'Source Sans 3', sans-serif; text-align: justify; top: 29px;">
                                    <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                        alt="Decorative Bottom"
                                        class="position-absolute bottom-0 start-0 trophy-bg d-none d-md-block"
                                        style="z-index: 0; width: 200px; opacity: 17.8;top:97px">
                                    <div class="long-desc-view" style="position: relative; z-index: 1;">
                                        <p>At Trophy House, craftsmanship is more than just a process — it is the
                                            heart of
                                            everything we do. From the initial sketch to the final polish, every
                                            trophy is
                                            handled
                                            with care, precision, and a deep sense of purpose. We believe that
                                            awards should
                                            not
                                            only symbolize success but also embody excellence in their design and
                                            durability.
                                            That's
                                            why we use only the highest quality materials like solid metals,
                                            polished
                                            crystal,
                                            rich
                                            woods, and durable resins to ensure a flawless finish that lasts a
                                            lifetime. Our
                                            team of
                                            experienced artisans and designers work together, blending traditional
                                            techniques
                                            with
                                            modern technology to create timeless pieces that resonate with meaning.
                                            Every
                                            edge
                                            is
                                            smoothed, every detail refined, and every finish perfected — because we
                                            know
                                            that an
                                            award is not just a product, it’s a story. Whether it's for corporate
                                            milestones,
                                            sports
                                            victories, academic achievements, or personal recognition, we make sure
                                            your
                                            trophy
                                            is
                                            as remarkable and enduring as the accomplishment it celebrates.</p>
                                        <!-- Your static text can stay here -->
                                    </div>
                                </div>

                                <!-- Right side cards -->
                                <div class="col-md-5 pb-0">
                                    @foreach ($aboutus as $item)
                                        <div class="about-card d-flex align-items-center mb-3">
                                            <div class="icon-box">
                                                <img src="{{ asset('about_images/' . $item->image) }}"
                                                    alt="Trophy Icon">
                                            </div>
                                            <div class="text-box d-flex justify-content-between align-items-center w-100">
                                                <span>{{ $item->title }}</span>
                                                <button class="btn aboutus-arrow" data-id="{{ $item->id }}">
                                                    <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                                        alt="Arrow" style="height: 30px;">
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Section Templates -->
                        <div id="aboutus-sections" class="d-none">
                            @foreach ($aboutus as $item)
                                <div id="aboutus-section-{{ $item->id }}" class="aboutus-section py-5">
                                    <div class="container">
                                        <div class="row align-items-start">
                                            <!-- LEFT: long_description -->
                                            <div class="col-md-8 mb-4 mb-md-0"
                                                style="position: relative; z-index: 1; min-height: 250px;">
                                                <p style="text-align: justify;">{{ $item->long_description }}</p>
                                                <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                                    alt="Decorative Bottom" class="position-absolute trophy-bg"
                                                    style="z-index: 0; width: 200px; opacity: 17.08; bottom: 0; left: 0;">
                                            </div>

                                            <!-- RIGHT: title + description + image -->
                                            <div class="col-md-4">
                                                <div class="custom-card-wrappers">
                                                    <div class="icon-boxs">
                                                        <img src="{{ asset('about_images/' . $item->image) }}"
                                                            alt="Trophy Icon">
                                                    </div>
                                                    <div class="custom-cards">
                                                        <button class="btn back-to-list-btn">
                                                            <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                                alt="Back Arrow" class="back-to-list">
                                                        </button>
                                                        <h5 class="card-titles">{{ $item->title }}</h5>
                                                        <p class="card-texts">{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Display Container -->
                        <div id="aboutus-dynamic-content" class="mt-4"></div>
                    </div>

                    <div id="aboutus-view-2" class="aboutus-view text-center">
                        {{-- This is the second content (can be testimonials, another info set, or blank initially) --}}
                        <div class="p-4">
                            <h1 style="color: #e03c3c;">About our Director yet to come</h1>
                            <p style="font-family: 'Source Sans 3', sans-serif; text-align: justify;">

                            </p>
                        </div>
                    </div>


                </div>
            </div>

            <div class="d-flex justify-content-center mb-4">
                <div class="toggle-circles">
                    <button class="circle-toggle left-toggle active" onclick="showAboutUsSection(1)"></button>
                    <button class="circle-toggle right-toggle" onclick="showAboutUsSection(2)"></button>
                </div>
            </div>
        </section>

        <script>
            function showAboutUsSection(viewNumber) {
                const leftBtn = document.querySelector('.left-toggle');
                const rightBtn = document.querySelector('.right-toggle');
                const view1 = document.getElementById('aboutus-view-1');
                const view2 = document.getElementById('aboutus-view-2');

                if (viewNumber === 1) {
                    view1.classList.add('slide-active');
                    view2.classList.remove('slide-active');
                    view2.classList.add('slide-left');
                    view1.classList.remove('slide-left');

                    leftBtn.classList.add('active');
                    rightBtn.classList.remove('active');
                } else {
                    view2.classList.add('slide-active');
                    view1.classList.remove('slide-active');
                    view1.classList.add('slide-left');
                    view2.classList.remove('slide-left');

                    rightBtn.classList.add('active');
                    leftBtn.classList.remove('active');
                }
            }
        </script>


        <script>
            document.querySelectorAll('.aboutus-arrow').forEach(el => {
                el.addEventListener('click', function() {
                    const id = this.dataset.id;

                    // Hide the list view
                    document.getElementById('aboutus-list-view').classList.add('d-none');

                    // Clone and show the selected section
                    const section = document.getElementById('aboutus-section-' + id).cloneNode(true);
                    section.classList.remove('d-none');
                    section.classList.add('active');

                    const container = document.getElementById('aboutus-dynamic-content');
                    container.innerHTML = '';
                    container.appendChild(section);

                    // Add back button event
                    section.querySelector('.back-to-list').addEventListener('click', function() {
                        container.innerHTML = '';
                        document.getElementById('aboutus-list-view').classList.remove('d-none');
                    });
                });
            });
        </script>

        <!--======End Things You Should Know===-->

        <!--======start Things You Should Know===-->
        <section class="info-section" style="background-color: white;">
            <div class="container info-section">

                <h3 class="text-center"
                    style="font-size: 28px; font-weight: bold; color: #e03c3c; font-family: 'Times New Roman', serif;">
                    Things You Should Know
                </h3>


                <div class="row text-center"style="padding-top: 60px;">
                    <!-- Card 1 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="vertical-divider d-none d-md-block"></div>
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things1.svg') }}"
                                alt="Customization Icon" style="height: 50px; width: 50px;">
                        </div>
                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Return & Exchange Policy
                        </div>

                        <div class="info-divider-horizontal"style="width: 306px;position: relative;left: -30px;">
                        </div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            We accept returns and exchanges within 7 days for damaged or incorrect items. Custom
                            products
                            can only be exchanged if there’s a production error.
                        </div>
                    </div>



                    <!-- Card 2 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="vertical-divider d-none d-md-block"></div>
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things2.svg') }}"
                                alt="Customization Icon" style="height: 50px; width: 50px;">
                        </div>

                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Delivery Information
                        </div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;">
                        </div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            Standard delivery in 3–7 business days across India. Express shipping available at
                            checkout.
                            Every order is carefully packed for safe arrival.
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="vertical-divider d-none d-md-block"></div>
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things3.svg') }}"
                                alt="Customization Icon" style="height: 50px; width: 50px;">
                        </div>

                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Customization Guidelines
                        </div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;">
                        </div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            Double-check names, logos, and text before confirming your order. Custom items can’t be
                            edited
                            or cancelled once production begins.
                        </div>
                    </div>


                    <!-- Card 4 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things4.svg') }}"
                                alt="Customization Icon" style="height: 50px; width: 50px;">
                        </div>
                        <div class="info-heading" style="padding-top: 25px;padding-bottom: 10px;">Secure Payments
                        </div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;">
                        </div>
                        <div class="info-desc">
                            Your payment is protected with industry-standard encryption. We support UPI,
                            credit/debit cards,
                            and trusted payment gateways.
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--======End Things You Should Know===-->

        <!--========= Starts Testimonials ========-->

        <section class="testimonials-section py-5" style="background-color: white;bottom: 73px;">
            <div class="container-fluid position-relative">

                <h3 class="text-center mb-5"
                    style="font-size: 28px; font-weight: bold; color: #e03c3c; font-family: 'Times New Roman', serif;">
                    Testimonials</h3>
                <!-- Background Plate -->
                <div class="testimonials-bg-plate"></div>
                <div class="swiper-wrapper-container">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper" style="font-family: 'Source Sans 3', sans-serif;    bottom: 35px;">
                            <!-- Slide 1 -->
                            @foreach ($testimonials as $tst)
                                <div class="swiper-slide" style=" padding-top: 94px;">
                                    <div class="testimonial-card outer-card text-center">

                                        <div class="testimonial-img">
                                            <img src="{{ asset('testimonial_images/' . $tst->image) }}"
                                                class="rounded-circle border border-warning" alt="">
                                        </div>
                                        <div class="testimonial-quote-box">
                                            <div class="quote-img-wrapper">
                                                <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                    class="quote-img start-quote" alt="">
                                                <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                    class="quote-img end-quote" alt="">
                                            </div>
                                            <p>{!! $tst->testimonial !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($testimonials as $tst)
                                <div class="swiper-slide" style=" padding-top: 94px;">
                                    <div class="testimonial-card outer-card text-center">

                                        <div class="testimonial-img">
                                            <img src="{{ asset('testimonial_images/' . $tst->image) }}"
                                                class="rounded-circle border border-warning" alt="">
                                        </div>
                                        <div class="testimonial-quote-box">
                                            <div class="quote-img-wrapper">
                                                <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                    class="quote-img start-quote" alt="">
                                                <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                    class="quote-img end-quote" alt="">
                                            </div>
                                            <p>{!! $tst->testimonial !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </section>

        <style>
            /* Custom left arrow image */
            .swiper-button-prev {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-left.png') }}');
            }

            /* Custom right arrow image */
            .swiper-button-next {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-right.png') }}');
            }
        </style>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const swiper = new Swiper(".mySwiper", {
                    loop: true,
                    slidesPerView: 3,
                    centeredSlides: true,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    on: {
                        init: function() {
                            updateSlideClasses();
                        },
                        slideChangeTransitionEnd: function() {
                            updateSlideClasses();
                        }
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                            centeredSlides: true,
                        },
                        768: {
                            slidesPerView: 3,
                            centeredSlides: true,
                        }
                    }
                });

                function updateSlideClasses() {
                    document.querySelectorAll('.swiper-slide').forEach(slide => {
                        slide.querySelector('.testimonial-card')?.classList.remove('active-center');
                    });

                    const activeSlide = document.querySelector('.swiper-slide-active');
                    activeSlide?.querySelector('.testimonial-card')?.classList.add('active-center');
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const wishlistButtons = document.querySelectorAll('.wishlist-toggle');
                const wishlistCountElement = document.querySelector('.wishlist-count');

                wishlistButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation(); // Prevent parent link navigation
                        const productId = this.dataset.productId;
                        const isWishlisted = this.classList.contains('text-danger');

                        // Check if user is authenticated
                        if (!{{ Auth::check() ? 'true' : 'false' }}) {
                            alert('Please log in to manage your wishlist.');
                            window.location.href = '{{ route('login') }}';
                            return;
                        }

                        // Prepare the request
                        const url = isWishlisted ? '/wishlist/get-item/' + productId :
                            '{{ route('wishlist.add') }}';
                        const method = isWishlisted ? 'GET' : 'POST';
                        const body = isWishlisted ? null : JSON.stringify({
                            product_id: productId
                        });

                        // First, fetch the wishlist item ID if removing
                        fetch(url, {
                                method: method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: body,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    alert(data.message || 'An error occurred.');
                                    return Promise.reject(new Error('Request failed'));
                                }

                                if (isWishlisted) {
                                    // Remove from wishlist using the wishlist_item_id
                                    const wishlistItemId = data.wishlist_item_id;
                                    return fetch('{{ route('wishlist.remove', ['id' => ':id']) }}'
                                        .replace(':id', wishlistItemId), {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            },
                                        }).then(response => response.json());
                                } else {
                                    // Product added successfully
                                    this.classList.add('text-danger');
                                    updateWishlistCount(data.count);
                                    alert(data.message); // Single alert for add
                                    return Promise.resolve(data);
                                }
                            })
                            .then(data => {
                                if (isWishlisted && data.success) {
                                    this.classList.remove('text-danger');
                                    updateWishlistCount(data.count);
                                    alert(data.message); // Single alert for remove
                                }
                            })
                            .catch(error => {
                                if (error.message !== 'Request failed') {
                                    console.error('Error:', error);
                                    alert('An error occurred while updating your wishlist.');
                                }
                            });
                    });
                });

                function updateWishlistCount(count) {
                    if (wishlistCountElement) {
                        wishlistCountElement.textContent = count || 0;
                    }
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('exampleModal');

                function showForm(type) {
                    modal.querySelector('.login-content').classList.add('d-none');
                    modal.querySelector('.signup-content').classList.add('d-none');

                    if (type === 'login') {
                        modal.querySelector('.login-content').classList.remove('d-none');
                    } else if (type === 'signup') {
                        modal.querySelector('.signup-content').classList.remove('d-none');
                    }
                }

                modal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const formType = button.getAttribute('data-form');
                    showForm(formType);
                });

                document.querySelectorAll('.switch-form').forEach(function(link) {
                    link.addEventListener('click', function() {
                        const formType = this.getAttribute('data-form');
                        showForm(formType);
                    });
                });
            });
        </script>


    </main>
    {{-- <script>
        const minSlider = document.getElementById("minPrice");
        const maxSlider = document.getElementById("maxPrice");
        const minLabel = document.getElementById("minPriceLabel");
        const maxLabel = document.getElementById("maxPriceLabel");

        function updateLabels() {
            let min = parseInt(minSlider.value);
            let max = parseInt(maxSlider.value);

            if (min > max - 500) {
                min = max - 500;
                minSlider.value = min;
            }

            if (max < min + 500) {
                max = min + 500;
                maxSlider.value = max;
            }

            minLabel.textContent = min;
            maxLabel.textContent = max;

            fetchProducts(min, max);
        }

        minSlider.addEventListener("input", updateLabels);
        maxSlider.addEventListener("input", updateLabels);

        function fetchProducts(min, max) {
            fetch(`/filter-products?min_price=${min}&max_price=${max}`)
                .then(res => res.json())
                .then(data => {
                    let container = document.getElementById("productsContainer");
                    container.innerHTML = "";

                    if (data.products.length > 0) {
                        data.products.forEach(p => {
                            // Compute min & max variant price
                            let prices = p.variants.map(v => v.discounted_price ?? v.price);
                            let minPrice = Math.min(...prices);
                            let maxPrice = Math.max(...prices);

                            let variantId = p.variants.length > 0 ? p.variants[0].id : '';
                            let color = "";

                            if (p.variants.length > 0 && p.variants[0].color) {
                                try {
                                    let decoded = typeof p.variants[0].color === "string" ?
                                        JSON.parse(p.variants[0].color) :
                                        p.variants[0].color;
                                    color = Array.isArray(decoded) ? (decoded[0] ?? '') : decoded;
                                } catch (e) {
                                    color = p.variants[0].color;
                                }
                            }

                            container.innerHTML += `
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 allProducts"
                                data-category="${p.category_id}"
                                data-subcategory-id="${p.sub_category_id}"
                                data-price-min="${minPrice}"
                                data-price-max="${maxPrice}"
                                data-variants-count="${p.variants.length}">
                                <div class="card trophy-card text-center shadow-md">
                                    <a href="/product-detail/${p.id}">
                                        <div class="position-relative">
                                            <img src="/product_images/${p.image}" 
                                                 alt="${p.title}" class="img-fluid"
                                                 style="height: 150px; width: 100%; object-fit: contain; padding:10px;" />

                                            <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                                <i class="fas fa-heart icon-toggle wishlist-toggle" 
                                                   data-product-id="${p.id}" 
                                                   title="Toggle Wishlist"></i>

                                                <form action="/cart/add" method="POST">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="product_id" value="${p.id}">
                                                    <input type="hidden" name="variant_id" value="${variantId}">
                                                    <input type="hidden" name="color" value="${color}">
                                                    <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                </form>

                                                <i class="fas fa-share icon-toggle share-icon" 
                                                   data-share-link="/product-detail/${p.id}"></i>
                                            </div>
                                        </div>

                                        <div class="card-body py-2">
                                            <p class="mb-1 product-id">${p.title.substring(0, 25)}</p>
                                            <p class="mb-0 text-danger fw-bold">₹${minPrice} - ₹${maxPrice}</p>
                                        </div>
                                    </a>
                                </div>
                            </div>`;
                        });
                    } else {
                        container.innerHTML = "<p>No products found in this price range.</p>";
                    }
                });
        }
    </script> --}}
    <script>
        let csrf_token = '{{ csrf_token() }}';

        function fetchFilteredProducts(min, max) {
            const selectedSubcategory = document.getElementById('selectedSubcategory')?.value || '';
            console.log("Fetching with URL:",
                `/filterProducts?min_price=${min}&max_price=${max}&subcategory=${selectedSubcategory}`);
            fetch(`/filterProducts?min_price=${min}&max_price=${max}&subcategory=${selectedSubcategory}`)
                .then(res => {
                    console.log("Response status:", res.status, "OK:", res.ok);
                    if (!res.ok) {
                        return res.text().then(text => {
                            throw new Error(`HTTP error! Status: ${res.status}, Response: ${text}`);
                        });
                    }
                    // Log raw response before parsing
                    return res.text().then(text => {
                        console.log("Raw response text:", text);
                        try {
                            return JSON.parse(text); // Manually parse to catch errors
                        } catch (e) {
                            console.error("JSON parse error:", e);
                            throw new Error(`Failed to parse JSON: ${text}`);
                        }
                    });
                })
                .then(data => {
                    console.log("Parsed API response:", data);
                    let container = document.getElementById("product-list");
                    console.log("Container:", container);
                    if (!container) {
                        console.error("Container #product-list not found in DOM");
                        return;
                    }
                    container.innerHTML = "";
                    if (data && data.products && data.products.length > 0) {
                        console.log("Products:", data.products);
                        data.products.forEach(p => {
                            console.log("Processing product:", p);
                            // Your HTML generation code (unchanged)
                            let prices = p.variants.map(v => v.discounted_price || v.price || 0);
                            let minPrice = Math.min(...prices);
                            let maxPrice = Math.max(...prices);
                            let variantsCount = p.variants.length;
                            let variantId = variantsCount > 0 ? p.variants[0].id : '';
                            let color = '';
                            if (variantsCount > 0 && p.variants[0].color) {
                                try {
                                    let decoded = typeof p.variants[0].color === "string" ? JSON.parse(p
                                        .variants[0].color) : p.variants[0].color;
                                    color = Array.isArray(decoded) ? (decoded[0] || '') : decoded;
                                } catch (e) {
                                    color = p.variants[0].color || '';
                                }
                            }
                            let displayPrice = variantsCount > 0 ? (p.variants[0].discounted_price || p
                                .variants[0].price || 'N/A') : 'N/A';
                            let limitedTitle = p.title.substring(0, 25);
                            container.innerHTML += `
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 allProducts"
                            data-category="${p.category_id}"
                            data-subcategory-id="${p.sub_category_id}"
                            data-price-min="${minPrice}"
                            data-price-max="${maxPrice}"
                            data-variants-count="${variantsCount}">
                            <div class="card trophy-card text-center shadow-md" style="height: 100%;">
                                <a href="/product-detail/${p.id}">
                                    <div class="position-relative">
                                        <img src="/product_images/${p.image}" alt="Trophy"
                                            class="img-fluid"
                                            style="height: 150px; width: 100%; object-fit: contain;padding:10px;" />
                                        <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                                            <i class="fas fa-heart icon-toggle wishlist-toggle"
                                                data-product-id="${p.id}"
                                                title="Toggle Wishlist"></i>
                                            <form action="/cart/add" method="POST">
                                                <input type="hidden" name="_token" value="${csrf_token}">
                                                <input type="hidden" name="product_id" value="${p.id}">
                                                <input type="hidden" name="variant_id" value="${variantId}">
                                                <input type="hidden" name="color" id="selectedColor" value="${color}">
                                                <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                            </form>
                                            <i class="fas fa-share icon-toggle share-icon"
                                                data-share-link="/product-detail/${p.id}"></i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-2 pb-1">
                                        <p class="mb-1 product-id">${limitedTitle}</p>
                                        <p class="text-danger fw-bold mb-0">${displayPrice} Rs</p>
                                    </div>
                                </a>
                            </div>
                        </div>`;
                        });
                    } else {
                        console.log("No products or invalid data:", data);
                        container.innerHTML = `<p class="text-center">No products found in this price range.</p>`;
                    }
                })
                .catch(err => {
                    console.error("Fetch error:", err);
                    document.getElementById("product-list").innerHTML =
                        `<p class="text-center text-danger">Error loading products: ${err.message}</p>`;
                });
        }



        // Attach event listener to range slider
        document.addEventListener("DOMContentLoaded", () => {
            const minRange = document.getElementById("minPrice");
            const maxRange = document.getElementById("maxPrice");
            const minLabel = document.getElementById("minPriceLabel");
            const maxLabel = document.getElementById("maxPriceLabel");

            function updateProducts() {
                let min = parseInt(minRange.value);
                let max = parseInt(maxRange.value);

                if (min > max - 500) {
                    min = max - 500;
                    minRange.value = min;
                }

                if (max < min + 500) {
                    max = min + 500;
                    maxRange.value = max;
                }

                minLabel.textContent = min;
                maxLabel.textContent = max;

                fetchFilteredProducts(min, max);
            }

            minRange.addEventListener("input", updateProducts);
            maxRange.addEventListener("input", updateProducts);

            // Initial load with default range
            updateProducts();
        });
    </script>

@endsection
