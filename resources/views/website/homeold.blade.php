@extends('website.layout.master')
@section('content')
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

                                <h1 id="hero-title">Tropies - Every Win,<br>A Masterpiece</h1>
                                <p id="hero-description" style="font-size: 16px;">
                                    Honor excellence with our premium trophies — designed to last, built to inspire. From
                                    sports to corporate milestones, we’ve got the perfect piece for every victory.
                                </p>
                                <div class="button-groups">
                                    @if (!Auth::user())
                                        <a href="{{ route('register') }}" class="custom-btn">Sign Up</a>
                                        <a href="{{ route('login') }}" class="custom-btn">Log in</a>
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
                                    <img id="quote-box-0" src="{{ asset('website/assets/images/homePage/Group105.png') }}"
                                        class="quote-bubble"
                                        style="display: block;left: -16px;height: 60px;width: 215px;bottom: 78px;">
                                    <img id="quote-box-1" src="{{ asset('website/assets/images/homePage/Group 106.png') }}"
                                        class="quote-bubble"
                                        style="display: none;left: -23px;bottom: 153px;height: 60px;width: 215px;">
                                    <img id="quote-box-2" src="{{ asset('website/assets/images/homePage/Group 107.png') }}"
                                        class="quote-bubble"
                                        style="display: none;top: 10px;right: 339px;height: 60px;width: 215px;">
                                    <img id="quote-box-3" src="{{ asset('website/assets/images/homePage/Group 113.png') }}"
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
                <div class="text-center mb-5">
                    <h3 class="text-danger fw-bold" style="font-family: 'Times New Roman', serif;">Categories</h3>
                    <div class="category-tabs mt-3" style="font-family: 'Source Sans 3', sans-serif;">
                        <ul class="nav justify-content-center" style="font-size: 14px;">
                            @foreach ($categories as $cat)
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Category Grid -->
                <div class="row text-center category-items" style="font-family: 'Source Sans 3', sans-serif;">
                    @foreach ($categories as $cat)
                        @foreach ($cat->products as $product)
                            <div class="col-lg-2 col-sm-2 col-md-2 item-box" data-category="{{ strtolower($cat->name) }}">
                                <div class="img-wrap position-relative">
                                    <img src="{{ asset('product_images/' . $product->image) }}"
                                        alt="{{ $product->title }}" class="img-fluid">
                                    <div class="yellow-base"></div>
                                </div>
                                <p class="text-center item-title" style="bottom: 16px; position: relative;">
                                    {{ $product->title }}
                                </p>
                            </div>
                        @endforeach
                    @endforeach
                </div>

            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoryLinks = document.querySelectorAll('.category-tabs .nav-link');
                const items = document.querySelectorAll('.category-items > .item-box');

                categoryLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        categoryLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');

                        const selectedCategory = this.textContent.trim().toLowerCase();

                        items.forEach(item => {
                            const itemCategory = item.getAttribute('data-category')
                                .toLowerCase();
                            item.style.display = (itemCategory === selectedCategory) ? 'block' :
                                'none';
                        });
                    });
                });

                categoryLinks[0].click();
            });
        </script>
        <!--====== End Category Section ======-->


        <!--====== Start Explore Our Top Picks Section ======-->
        <section class="trophy-section py-5" style="background-color:white">
            <div class="container-fluid">
                <h4 class="text-center mb-5"
                    style="color: #e63946;font-family: 'Source Sans 3', sans-serif; font-weight: bold;">"Explore Our Top
                    Picks"</h4>
                <div class="row justify-content-center text-center">
                    <div class="trophy-card-wrapper position-relative ">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">
                            @foreach ($products as $prod)
                                @if ($prod->is_top_pick == 1)
                                    <a href="{{route('product.show',$prod->id)}}">

                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                            <div class="card trophy-card text-center shadow-md">
                                                <div class="position-relative">
                                                    <img src="{{ asset('product_images/' . $prod->image) }}"
                                                        alt="Trophy" class="img-fluid"
                                                        style="height: 150px; width: 100%; object-fit: contain;" />
                                                    <div class="trophy-hover-bar">
                                                        <i class="fas fa-heart icon-toggle"></i>
                                                        <form action="{{ route('cart.add') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $prod->id }}">
                                                            <button type="submit" class="add-to-cart-btn">Add To
                                                                Cart</button>
                                                        </form>
                                                        <i class="fas fa-share icon-toggle"></i>
                                                    </div>
                                                </div>
                                                <div class="card-body py-2">
                                                    <p class="mb-1 product-id">{{ $prod->title }}</p>
                                                    <p class="mb-0 text-danger fw-bold">{{ $prod->new_price }} Rs</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach

                            {{-- <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card trophy-card text-center shadow-sm">
                                <div class="card trophy-card text-center shadow-sm">

                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">10002</p>
                                        <p class="mb-0 text-danger fw-bold">500 Rs</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card trophy-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">003</p>
                                        <p class="mb-0 text-danger fw-bold">530 Rs</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card trophy-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">004</p>
                                        <p class="mb-0 text-danger fw-bold">540 Rs</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card trophy-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">005</p>
                                        <p class="mb-0 text-danger fw-bold">550 Rs</p>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="text-center mt-4 w-100">
                                <a href="#" class="see-more-btn">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--====== End Explore Our Top Picks Section ======-->

        <!--====== Start Our Best Sellers Section ======-->
        <section class="trophy-section" style="font-family: 'Times New Roman', serif; background-color:white">
            <div class="container-fluid">
                <h4 class="text-center mb-5"
                    style="color: #e63946;font-family: 'Source Sans 3', sans-serif; font-weight: bold;">"Our Best Sellers"
                </h4>
                <div class="row justify-content-center text-center">

                    <div class="trophy-card-wrapper position-relative ">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">
                            @foreach ($products as $prod)
                                @if ($prod->is_best_seller == 1)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                        <div class="card trophy-card text-center shadow-md">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                                    class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: contain;" />
                                                <div class="trophy-hover-bar">
                                                    <i class="fas fa-heart icon-toggle"></i>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $prod->id }}">
                                                        <button type="submit" class="add-to-cart-btn">Add To
                                                            Cart</button>
                                                    </form>
                                                    <i class="fas fa-share icon-toggle"></i>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="mb-1 product-id">{{ $prod->title }}</p>
                                                <p class="mb-0 text-danger fw-bold">{{ $prod->new_price }} Rs</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            {{-- <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                <div class="card trophy-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">002</p>
                                        <p class="mb-0 text-danger fw-bold">500 Rs</p>
                                    </div>
                                </div>
                            </div> --}}



                            <div class="text-center mt-4 w-100">
                                <a href="#" class="see-more-btn">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--====== End Our Best Sellers Section ======-->


        <!--======Celebrate the momentss Sections  ======-->
        <section class="container-fluid testimonial-section py-5 bg-white">

            <div class="container">
                <div class="row align-items-center mb-4">

                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                        <div class="custom-card text-center p-0 overflow-hidden">

                            <!-- Image Header -->
                            <div class="py-4" id="card-header">
                                <img src="{{ asset('website/assets/images/homePage/celebration.png') }}"
                                    alt="Trophy Icon" style="max-width: 100px;">
                            </div>

                            <!-- List View -->
                            <div class="list-group list-group-flush" id="list-view"
                                style="font-family: 'Source Sans 3', sans-serif;">
                                <div class="list-group-item custom-item bg-light-yellow text-dark hover-yellow">
                                    <span style="font-weight: 600;">Designed for the Day</span>
                                    <button class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                        onclick="showDetail(0)">→</button>
                                </div>
                                <div class="list-group-item custom-item bg-light-red text-dark hover-red">
                                    <span style="font-weight: 600;">Limited Editions, Big Impact</span>
                                    <button class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                        onclick="showDetail(1)">→</button>
                                </div>
                                <div class="list-group-item custom-item bg-light-yellow text-dark hover-yellow">
                                    <span style="font-weight: 600;">A Keepsake to Remember</span>
                                    <button class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                        onclick="showDetail(2)">→</button>
                                </div>
                                <div class="list-group-item custom-item bg-light-red text-dark hover-red">
                                    <span style="font-weight: 600;">Personalized Just for Them</span>
                                    <button class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                        onclick="showDetail(3)">→</button>
                                </div>
                            </div>

                            <!-- Detail View -->
                            <div class="p-3 bg-light-yellow text-start d-none" id="detail-view"
                                style="font-family: 'Source Sans 3', sans-serif;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong id="detail-title">Title</strong>
                                    <button class="btn btn-sm rounded-circle bg-white text-dark border border-white shadow"
                                        onclick="backToList()">&#8599;</button>

                                </div>
                                <p class="mt-2" id="detail-desc">
                                    <!-- Detail description here -->
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
                        <h2 class="text-danger fw-bold mb-2" style="font-family: 'Times New Roman', serif;">Celebrate the
                            moment</h2>

                        <h5 class="fw-bold mb-3" style="font-family: 'Source Sans 3', sans-serif;">
                            Celebrate Dad in Style — Limited Edition Trophies Available Now!
                        </h5>
                        <p class="text-muted mb-4" style="font-family: 'Source Sans 3', sans-serif;">
                            Make this Father’s Day unforgettable with a trophy that says it all. Our limited edition designs
                            are crafted to honor <br>the strength, love, and support only a dad can give. Shop now and give
                            him the recognition he truly deserves!
                        </p>


                        <div class="d-flex flex-wrap gap-5 justify-content-start">
                            <!-- Trophy Card 1 -->
                            <div>
                                <div class="card trophy-card large-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">001</p>
                                        <p class="mb-0 text-danger fw-bold">540 Rs</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Trophy Card 2 -->
                            <div>
                                <div class="card trophy-card large-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">002</p>
                                        <p class="mb-0 text-danger fw-bold">550 Rs</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Trophy Card 3 -->
                            <div>
                                <div class="card trophy-card large-card text-center shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('website/assets/images/Trophy.png') }}" alt="Trophy"
                                            class="img-fluid"
                                            style="max-height: 150px; width: 100%; object-fit: contain;" />
                                        <div class="trophy-hover-bar">
                                            <i class="fas fa-heart icon-toggle"></i>
                                            <button>Add To Cart</button>
                                            <i class="fas fa-share icon-toggle"></i>
                                        </div>
                                    </div>
                                    <div class="card-body py-2">
                                        <p class="mb-1 product-id">003</p>
                                        <p class="mb-0 text-danger fw-bold">530 Rs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <img src="{{ asset('website/assets/images/homePage/carousal-right.png') }}" alt="images"
                                style="height: 35px;position: relative;left: 795px;bottom: 121px;">

                        </div>
                    </div>


                </div>
        </section>


        <!--====== End Celebrate the momentss Sections  ======-->


        <!--====== Start New Arrivals Section ======-->
        <section class="trophy-section py-5" style="font-family: 'Times New Roman', serif; background-color:white">
            <div class="container-fluid">

                <p
                    class="text-center mb-5"style="color: #e63946;font-family: 'Source Sans 3', sans-serif;font-weight: bold;font-size: 24px;">
                    "New Arrivals"</p>
                <div class="row justify-content-center text-center">

                    <div class="trophy-card-wrapper position-relative ">
                        <div class="hover-yellow-bg d-none d-sm-block"></div>
                        <div class="row justify-content-center text-center position-relative">
                            @foreach ($products as $prod)
                                @if ($prod->is_new_arrival == 1)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                        <div class="card trophy-card text-center shadow-md">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                                    class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: contain;" />
                                                <div class="trophy-hover-bar">
                                                    <i class="fas fa-heart icon-toggle"></i>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $prod->id }}">
                                                        <button type="submit" class="add-to-cart-btn">Add To
                                                            Cart</button>
                                                    </form>
                                                    <i class="fas fa-share icon-toggle"></i>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="mb-1 product-id">{{ $prod->title }}</p>
                                                <p class="mb-0 text-danger fw-bold">{{ $prod->new_price }} Rs</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach





                            <div class="text-center mt-4 w-100">
                                <a href="#" class="see-more-btn">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
        <section class="animated-headline-area pt-25 pb-25" style="background-color: white;">
            <div class="headline-wrap style-one text-center mb-3">
                <p
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif; text-transform: none;">
                    Client List
                </p>
            </div>
            <div class="headline-wrap style-one">
                <div class="marquee-wrap">
                    <div class="marquee-inner left d-flex align-items-center">
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/himalaya.png') }}" alt="himalaya"
                                style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/pears.png') }}" alt="pears"
                                style="width: 90px; height: 40px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/hindustan.png') }}" alt="hindustan"
                                width="120" height="60">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/pantaloons.png') }}"
                                alt="pantaloons"style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/flipkart.png') }}" alt="Flipkart"
                                style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/hdfc.png') }}" alt="HDFC Bank"
                                style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/icicbank.png') }}"
                                alt="icicbank"style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/tatasky.png') }}" alt="tatasky"
                                width="120" height="60">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/pears.png') }}" alt="Pears"
                                style="width: 90px; height: 40px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/himalaya.png') }}"
                                alt="Himalaya"style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/amazon.png') }}" alt="Amazon"
                                width="120" height="60">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/flipkart.png') }}"
                                alt="Flipkart"style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/hindustan.png') }}" alt="hindustan"
                                width="120" height="60">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/pantaloons.png') }}" alt="pantaloons"
                                style="width: 120px; height: 60px;">
                        </div>

                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/hdfc.png') }}" alt="HDFC Bank"
                                style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/icicbank.png') }}" alt="icicbank"
                                style="width: 120px; height: 60px;">
                        </div>
                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/tatasky.png') }}" alt="tatasky"
                                width="120" height="60">
                        </div>

                        <div class="logo-item">
                            <img src="{{ asset('website/assets/images/ClientImages/flipkart.png') }}"
                                alt="Flipkart"style="width: 120px; height: 60px;">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--====== End Clients List Section ======-->

        <!--====== start About us Section ======-->

        <!-- About Us Section -->
        <section class="about-us-section py-5">
            <div class="container">
                <p class="text-center"
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif;">
                    About Us
                </p>

                <!-- List View -->
                <div id="aboutus-list-view">
                    <div class="row align-items-start">
                        <div class="col-md-7 pb-0 position-relative"
                            style="font-family: 'Source Sans 3', sans-serif; text-align: justify; top: 29px;">
                            <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}" alt="Decorative Bottom"
                                class="position-absolute bottom-0 start-0 trophy-bg d-none d-md-block"
                                style="z-index: 0; width: 200px; opacity: 17.8;top:97px">
                            <div style="position: relative; z-index: 1;">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>
                            </div>

                        </div>


                        <div class="col-md-5 pb-0">
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about1.png') }}"
                                        alt="Trophy Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Craftsmanship That Lasts</span>

                                    <button class="btn aboutus-arrow" data-id="1">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="height: 30px;">
                                    </button>
                                </div>
                            </div>
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about2.png') }}" alt="Gear Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Fully Custom, Fully You</span>

                                    <button class="btn aboutus-arrow" data-id="2">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="    height: 30px;">
                                    </button>
                                </div>
                            </div>
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about3.png') }}"
                                        alt="Delivery Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Delivered With Confidence</span>

                                    <button class="btn aboutus-arrow" data-id="3">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="    height: 30px;">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail View -->
                <div id="aboutus-detail-view" class="p-4 bg-light d-none"
                    style="font-family: 'Times New Roman', Times, serif;">
                    <div class="d-flex justify-content-between align-items-start">
                        <strong id="aboutus-detail-title">Title</strong>
                        <button class="btn btn-sm rounded-circle bg-white text-dark border shadow"
                            onclick="aboutusBackToList()">&#8599;</button>
                    </div>
                    <p class="mt-2" id="aboutus-detail-desc"></p>
                </div>
                <!-- Section Templates (hidden) -->
                <div id="aboutus-sections" class="d-none">
                    <div id="aboutus-section-1" class="aboutus-section py-5">
                        <div class="container">
                            <div class="row align-items-start">
                                <!-- Left Column: Text Content -->
                                <div class="col-md-8 mb-4 mb-md-0"
                                    style="position: relative; z-index: 1; min-height: 250px;">
                                    <p>Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. </p>
                                    <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                        Ipsum passages, and more recently with desktop publishing software like Aldus
                                        PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the
                                        printing and typesetting industry. Contrary to popular belief, Lorem Ipsum is not
                                        simply random text. </p>
                                    <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. . </p>

                                    <!-- Trophy image BELOW the text -->
                                    <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                        alt="Decorative Bottom" class="position-absolute trophy-bg"
                                        style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                                </div>




                                <div class="col-md-4">
                                    <div class="custom-card-wrappers">

                                        <!-- Overlapping Circular Icon -->
                                        <div class="icon-boxs">
                                            <img src="{{ asset('website/assets/images/homePage/about1.png') }}"
                                                alt="Trophy Icon">
                                        </div>

                                        <div class="custom-cards">
                                            <!-- Back to List Button -->
                                            <button class="btn back-to-list-btn">
                                                <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                    alt="Back Arrow" class="back-to-list">
                                            </button>

                                            <h5 class="card-titles" style="font-family: 'Source Sans 3', sans-serif;">
                                                Craftsmanship That Lasts</h5>
                                            <h6 class="card-subtitles" style="font-family: 'Source Sans 3', sans-serif;">
                                                Celebrate success with quality that endures.</h6>
                                            <p class="card-texts"style="font-family: 'Source Sans 3', sans-serif;">
                                                At Trophy House, every trophy is a work of art — thoughtfully designed,
                                                precisely detailed, and expertly finished.
                                                We use only premium materials to ensure each piece not only looks
                                                exceptional but stands the test of time. Because a
                                                true achievement deserves more than a symbol — it deserves a lasting
                                                impression.
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div id="aboutus-section-2" class="aboutus-section">
                        <div class="row align-items-start">
                            <div
                                class="col-md-8 mb-4 mb-md-0"style="font-family: 'Source Sans 3', sans-serif;position: relative; z-index: 1; min-height: 250px;">
                                <p>Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>

                                <!-- Trophy image BELOW the text -->
                                <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                    alt="Decorative Bottom" class="position-absolute trophy-bg"
                                    style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                            </div>
                            <div class="col-md-4">

                                <div class="custom-card-wrappers">

                                    <!-- Overlapping Circular Icon -->
                                    <div class="icon-boxs">
                                        <img src="{{ asset('website/assets/images/homePage/about2.png') }}"
                                            alt="Trophy Icon">
                                    </div>

                                    <div class="custom-cards">
                                        <!-- Back to List Button -->
                                        <button class="btn back-to-list-btn">
                                            <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                alt="Back Arrow" class="back-to-list">
                                        </button>

                                        <h5 class="card-titles" style="font-family: 'Source Sans 3', sans-serif;">
                                            Craftsmanship That Lasts</h5>
                                        <h6 class="card-subtitles" style="font-family: 'Source Sans 3', sans-serif;">
                                            Celebrate success with quality that endures.</h6>
                                        <p class="card-texts" style="font-family: 'Source Sans 3', sans-serif;">
                                            At Trophy House, every trophy is a work of art — thoughtfully designed,
                                            precisely detailed, and expertly finished.
                                            We use only premium materials to ensure each piece not only looks exceptional
                                            but stands the test of time. Because a
                                            true achievement deserves more than a symbol — it deserves a lasting impression.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="aboutus-section-3" class="aboutus-section">
                        <div class="row align-items-start">
                            <div
                                class="col-md-8 mb-4 mb-md-0"style="font-family: 'Source Sans 3', sans-serif;position: relative; z-index: 1; min-height: 250px;">
                                <p>Lorem 3 Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>

                                <!-- Trophy image BELOW the text -->
                                <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                    alt="Decorative Bottom" class="position-absolute trophy-bg"
                                    style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                            </div>
                            <div class="col-md-4">
                                <div class="custom-card-wrappers">

                                    <!-- Overlapping Circular Icon -->
                                    <div class="icon-boxs">
                                        <img src="{{ asset('website/assets/images/homePage/about3.png') }}"
                                            alt="Trophy Icon">
                                    </div>

                                    <div class="custom-cards">
                                        <!-- Back to List Button -->
                                        <button class="btn back-to-list-btn">
                                            <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                alt="Back Arrow" class="back-to-list">
                                        </button>

                                        <h5 class="card-titles"style="font-family: 'Source Sans 3', sans-serif;">
                                            Craftsmanship That Lasts</h5>
                                        <h6 class="card-subtitles"style="font-family: 'Source Sans 3', sans-serif;">
                                            Celebrate success with quality that endures.</h6>
                                        <p class="card-texts"style="font-family: 'Source Sans 3', sans-serif;">
                                            At Trophy House, every trophy is a work of art — thoughtfully designed,
                                            precisely detailed, and expertly finished.
                                            We use only premium materials to ensure each piece not only looks exceptional
                                            but stands the test of time. Because a
                                            true achievement deserves more than a symbol — it deserves a lasting impression.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Container -->
                <div id="aboutus-dynamic-content" class="mt-4"></div>
            </div>



        </section>


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
                            <img src="{{ asset('website/assets/images/homePage/things1.svg') }}" alt="Customization Icon"
                                style="height: 50px; width: 50px;">
                        </div>
                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Return & Exchange Policy
                        </div>

                        <div class="info-divider-horizontal"style="width: 306px;position: relative;left: -30px;"></div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            We accept returns and exchanges within 7 days for damaged or incorrect items. Custom products
                            can only be exchanged if there’s a production error.
                        </div>
                    </div>



                    <!-- Card 2 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="vertical-divider d-none d-md-block"></div>
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things2.svg') }}" alt="Customization Icon"
                                style="height: 50px; width: 50px;">
                        </div>

                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Delivery Information
                        </div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;"></div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            Standard delivery in 3–7 business days across India. Express shipping available at checkout.
                            Every order is carefully packed for safe arrival.
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="vertical-divider d-none d-md-block"></div>
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things3.svg') }}" alt="Customization Icon"
                                style="height: 50px; width: 50px;">
                        </div>

                        <div class="info-heading"
                            style="padding-top: 25px; padding-bottom: 10px; font-weight: 700; font-family: 'Source Sans 3', sans-serif;">
                            Customization Guidelines
                        </div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;"></div>
                        <div class="info-desc" style="font-family: 'Source Sans 3', sans-serif;">
                            Double-check names, logos, and text before confirming your order. Custom items can’t be edited
                            or cancelled once production begins.
                        </div>
                    </div>


                    <!-- Card 4 -->
                    <div class="col-md-3 col-12 info-item position-relative">
                        <div class="info-icon">
                            <img src="{{ asset('website/assets/images/homePage/things4.svg') }}" alt="Customization Icon"
                                style="height: 50px; width: 50px;">
                        </div>
                        <div class="info-heading" style="padding-top: 25px;padding-bottom: 10px;">Secure Payments</div>
                        <div class="info-divider-horizontal" style="width: 306px;position: relative;left: -36px;"></div>
                        <div class="info-desc">
                            Your payment is protected with industry-standard encryption. We support UPI, credit/debit cards,
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
                    TESTIMONIALS</h3>
                <!-- Background Plate -->
                <div class="testimonials-bg-plate"></div>
                <div class="swiper-wrapper-container">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper" style="font-family: 'Source Sans 3', sans-serif;    bottom: 35px;">
                            <!-- Slide 1 -->
                            <div class="swiper-slide" style="top: 58px;">
                                <div class="testimonial-card outer-card text-center">
                                    <div class="testimonial-img">
                                        <img src="{{ asset('website/assets/images/homePage/testimonialsImage.png') }}"
                                            class="rounded-circle border border-warning" alt="">
                                    </div>
                                    <div class="testimonial-quote-box">
                                        <div class="quote-img-wrapper">
                                            <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                class="quote-img start-quote" alt="">
                                            <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                class="quote-img end-quote" alt="">
                                        </div>
                                        <p>slide 1 Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2-->
                            <div class="swiper-slide" style="top: 58px;">
                                <div class="testimonial-card outer-card text-center">
                                    <div class="testimonial-img">
                                        <img src="{{ asset('website/assets/images/homePage/testimonialsImage.png') }}"
                                            class="rounded-circle border border-warning" alt="">
                                    </div>
                                    <div class="testimonial-quote-box">
                                        <div class="quote-img-wrapper">
                                            <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                class="quote-img start-quote" alt="">
                                            <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                class="quote-img end-quote" alt="">
                                        </div>
                                        <p>slide 3 Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3-->
                            <div class="swiper-slide" style="top: 58px;">
                                <div class="testimonial-card outer-card text-center">
                                    <div class="testimonial-img">
                                        <img src="{{ asset('website/assets/images/homePage/testimonialsImage.png') }}"
                                            class="rounded-circle border border-warning" alt="">
                                    </div>
                                    <div class="testimonial-quote-box">
                                        <div class="quote-img-wrapper">
                                            <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                class="quote-img start-quote" alt="">
                                            <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                class="quote-img end-quote" alt="">
                                        </div>
                                        <p>slide 4 Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 4-->
                            <div class="swiper-slide" style="top: 58px;">
                                <div class="testimonial-card outer-card text-center">
                                    <div class="testimonial-img">
                                        <img src="{{ asset('website/assets/images/homePage/testimonialsImage.png') }}"
                                            class="rounded-circle border border-warning" alt="">
                                    </div>
                                    <div class="testimonial-quote-box">
                                        <div class="quote-img-wrapper">
                                            <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                class="quote-img start-quote" alt="">
                                            <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                class="quote-img end-quote" alt="">
                                        </div>
                                        <p>slide 4 Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Slide 5-->
                            <div class="swiper-slide" style="top: 58px;">
                                <div class="testimonial-card outer-card text-center">
                                    <div class="testimonial-img">
                                        <img src="{{ asset('website/assets/images/homePage/testimonialsImage.png') }}"
                                            class="rounded-circle border border-warning" alt="">
                                    </div>
                                    <div class="testimonial-quote-box">
                                        <div class="quote-img-wrapper">
                                            <img src="{{ asset('website/assets/images/homePage/left-quotes.svg') }}"
                                                class="quote-img start-quote" alt="">
                                            <img src="{{ asset('website/assets/images/homePage/right-quotes.svg') }}"
                                                class="quote-img end-quote" alt="">
                                        </div>
                                        <p>slide 5 Lorem Ipsum is simply dummy text of the printing and typesetting
                                            industry.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </section>

        <style>
            .swiper {
                padding: 20px 88px;
            }

            .swiper-wrapper-container {
                overflow: hidden;
                width: 85%;
                max-width: 1200px;
                margin: 0 auto;
                position: relative;
            }

            .swiper {
                padding-left: 0;
                padding-right: 0;
            }

            .swiper-slide {
                display: flex;
                justify-content: center;
                align-items: stretch;
            }

            .testimonial-card {
                border: 2px solid #ffc107;
                padding: 20px 15px;
                background: white;
                position: relative;
                max-width: 400px;
                margin: auto;
                transition: all 0.3s ease-in-out;
                transform: scale(1);
            }

            .testimonial-card.active-center {
                background-color: #e63946;
                border: none;
                transform: scale(1.08);
                z-index: 2;
                padding: 30px 20px;
                transition: all 0.3s ease-in-out;
                margin-top: -11px;
            }

            /* .testimonial-card.active-center for this class i want to increses the height and width*/
            .testimonial-card.active-center .testimonial-quote-box {
                height: 200px;
                width: 100%;
                padding: 54px 14px 20px;
                bottom: 16px;
            }

            .testimonial-card.active-center .quote-img {
                filter: brightness(0) saturate(100%) invert(92%) sepia(13%) saturate(402%) hue-rotate(354deg) brightness(104%) contrast(100%);
            }

            .testimonial-img {
                position: absolute;
                top: -40px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 2;
            }

            .testimonial-img img {
                width: 91px;
                height: 91px;
                border: 5px solid white;
                position: relative;
                top: 58px;
            }

            .testimonial-quote-box {
                margin-top: 50px;
                padding: 40px 20px 20px;
                background-color: #ffc107;
                position: relative;
            }

            .quote-img-wrapper {
                position: absolute;
                top: -20px;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
            }

            .quote-img {
                width: 40px;
                height: 40px;
                position: absolute;
            }

            .start-quote {
                top: 6px;
                left: 64px;
            }

            .end-quote {
                top: 7px;
                right: 63px;
            }

            .swiper-button-prev,
            .swiper-button-next {
                color: #e63946;
            }

            .swiper-button-prev,
            .swiper-button-next {
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                width: 40px;
                height: 40px;
                color: transparent;
            }

            /* Custom left arrow image */
            .swiper-button-prev {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-left.png') }}');
            }

            /* Custom right arrow image */
            .swiper-button-next {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-right.png') }}');
            }

            /* for background plate */
            .testimonials-section {
                position: relative;
                overflow: hidden;
            }

            .testimonials-bg-plate {
                position: absolute;
                bottom: -40px;
                left: 0;
                width: 100%;
                height: 50%;
                background-color: #FFF5DA;
                z-index: 0;
                overflow: hidden;
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

        {{-- <script>
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    
                   fetch("{{ route('cart.add') }}", {
                       
                            method: 'ANY',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Something went wrong!');
                        });
                });
            });
        </script> --}}

    </main>
    {{-- <script>
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    console.log('Adding product to cart:', productId);

                    fetch("{{ route('cart.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                if (response.status === 401) {
                                    alert('Please log in to add items to your cart.');
                                    window.location.href = '{{ route('login') }}';
                                } else if (response.status === 422) {
                                    return response.json().then(data => {
                                        throw new Error('Validation failed: ' + JSON.stringify(data
                                            .errors));
                                    });
                                }
                                throw new Error(`HTTP error! Status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Success:', data);
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Something went wrong: ' + error.message);
                        });
                });
            });
        </script> --}}
@endsection
