<!DOCTYPE html>
<html lang="zxx">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="eCommerce,shop,fashion">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--====== Title ======-->
    <title>Trophy House</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('website/assets/images/TH-Favicon.png') }}" type="image/png">
    <!--====== Google Fonts ======-->
    <link
        href="https://fonts.googleapis.com/css2?family=Aoboshi+One&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <!--====== Flaticon css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/fonts/flaticon/flaticon_pesco.css') }}">
    <!--====== FontAwesome css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/fonts/fontawesome/css/all.min.css') }}">
    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--====== Slick-popup css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/slick/slick.css') }}">
    <!--====== Nice Select css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/nice-select/css/nice-select.css') }}">
    <!--====== Magnific-popup css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/magnific-popup/dist/magnific-popup.css') }}">
    <!--====== Jquery UI css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/jquery-ui/jquery-ui.min.css') }}">
    <!--====== Animate css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/vendor/aos/aos.css') }}">
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/css/default.css') }}">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/css/style.css') }}">
    <!--====== Swiper CSS ======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!--====== Header CSS ======-->
    <link rel="stylesheet" href="{{ asset('website/assets/css/HeaderPage.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/HomePage.css') }}">
    <link rel="stylesheet" href="{{ asset('website/assets/css/productDetails.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>


<body>
    <!--====== Start Overlay ======-->
    <div class="offcanvas__overlay"></div>
    <!--====== Start Sidemenu-wrapper-cart Area ======-->
    <div class="sidemenu-wrapper-cart" style="">
        <div class="sidemenu-content">
            <div class="widget widget-shopping-cart">
                <h4>Menu</h4>
                <div class="sidemenu-cart-close">
                    <img src="{{ asset('website/assets/images/close.png') }}" alt="Close" id="closeBtn"
                        style="cursor: pointer; width: 24px; height: 24px;">
                </div>
                <script>
                    document.getElementById("closeBtn").addEventListener("click", function() {
                        document.querySelector(".sidemenu-wrapper-cart").classList.remove("open");
                    });
                </script>
                <div class="sidebar-user d-flex align-items-center gap-3 px-3 py-3 border-bottom">
                    <div class="profile-wrapper">
                        @if (isset(Auth::user()->image))
                            <img src="{{ asset('website/assets/images/header-menu.png') }}" alt="User">
                        @else
                            <img src="{{ asset('images/profile-default.png') }}" alt="User">
                        @endif
                        <input type="file" id="cameraInput" accept="image/*" capture="environment"
                            style="display: none;">
                        <div class="camera-icon" onclick="document.getElementById('cameraInput').click()">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                    <div class="user-info">
                        <h6 class="mb-0 fw-semibold">
                            @if (Auth::user())
                                {{ Auth::user()->name }}
                            @endif
                        </h6>
                        <p class="small text-muted mb-1">
                            @if (Auth::user())
                                {{ Auth::user()->email }}
                            @endif
                        </p>
                        @if (Auth::user())
                            <a href="{{ route(name: 'profile.edit') }}" class="btn btn-outline-danger btn-sm">edit
                                profile</a>
                        @else
                            {{-- <a href="{{route('login')}}" class="btn btn-outline-danger btn-sm">Login</a> --}}
                            <a href="{{ route(name: 'login') }}" class="btn btn-outline-danger btn-sm">Login</a>
                        @endif
                    </div>
                </div>
                <div class="sidebar px-3">
                    <div class="category-section mb-3">
                        <h6 class="fw-bold"
                            style="font-family: 'Source Sans 3', sans-serif;top: 15px;position: relative;">
                            <img src="{{ asset('website/assets/images/categories.png') }}" alt="Icon"
                                style="width: 16px; height: 16px; margin-right: 8px;">
                            Categories
                        </h6>
                        <ul class="list-unstyled category-list"
                            style="font-family: 'Source Sans 3', sans-serif;top: 23px;position: relative;">
                            @foreach ($categories as $cat)
                                {{-- <li><a href="{{ route('view.category', $cat->id) }}">{{$cat->name}}</a></li> --}}
                                <li>
                                    <a href="{{ route('view.category', $cat->id) }}" class="category"
                                        data-target="#filters-trophies">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="filters-trophies" class="filter-block d-none"
                        style="font-family: 'Source Sans 3', sans-serif;">
                        <div class="filter-section">
                            <h6><img src="{{ asset('website/assets/images/price.png') }}" alt="Icon"
                                    style="width: 20px; height: 20px; margin-right: 8px;"> Price</h6>
                            @foreach ($priceRanges as $i => $price)
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox"
                                        value="{{ $price }}" id="price{{ $i }}">
                                    <label class="form-check-label"
                                        for="price{{ $i }}">{{ $price }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h6> <img src="{{ asset('website/assets/images/colorPallets.png') }}" alt="Icon"
                                    style="width: 20px; height: 20px; margin-right: 8px;"> Colours</h6>
                            @foreach ($allColors as $i => $color)
                                <div class="form-check">
                                    <input class="form-check-input color-filter" type="checkbox"
                                        value="{{ $color }}" id="color{{ $i }}">
                                    <label class="form-check-label"
                                        for="color{{ $i }}">{{ ucfirst($color) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="filter-section">
                            <h6><img src="{{ asset('website/assets/images/sizes.png') }}" alt="Icon"
                                    style="width: 20px; height: 20px; margin-right: 8px;"> Sizes</h6>
                            @foreach ($sizes as $size)
                                <div class="form-check">
                                    <input class="form-check-input size-filter" type="checkbox"
                                        value="{{ strtolower($size) }}" id="size{{ $size }}">
                                    <label class="form-check-label"
                                        for="size{{ $size }}">{{ $size }}</label>
                                </div>
                            @endforeach
                        </div>

                    </div>


                    <div id="filters-samman" class="filter-block d-none">
                        <h6 class="fw-semibold mt-3">Price</h6>
                        <div class="form-check square-check">
                            <input class="form-check-input" type="checkbox" id="price1">
                            <label class="form-check-label" for="price1">₹100 - ₹500</label>
                        </div>
                        <div class="form-check square-check">
                            <input class="form-check-input" type="checkbox" id="price2">
                            <label class="form-check-label" for="price2">₹500 - ₹1000</label>
                        </div>
                        <h6 class="fw-semibold mt-3">Colours</h6>
                        <div class="form-check square-check">
                            <input class="form-check-input" type="checkbox" id="color1">
                            <label class="form-check-label" for="color1">Black</label>
                        </div>
                        <div class="form-check square-check">
                            <input class="form-check-input" type="checkbox" id="color2">
                            <label class="form-check-label" for="color2">Golden</label>
                        </div>
                    </div>
                </div>
                <div class="sidebar-footer mt-auto px-3">
                    <ul class="list-unstyled" style="position: relative;top: 10px;">
                        <li><i class="fas fa-box"></i> Shopping & Orders</li>
                        <li><i class="fas fa-paint-brush"></i> Customization & Support</li>
                        <li><i class="fas fa-cog"></i> Settings</li>
                        @if (Auth::user())
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="text-decoration: none; color: inherit;">
                                    <i class="fas fa-sign-out-alt"></i> Log out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.category').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.dataset.target;
                const target = document.querySelector(targetId);
                if (target.classList.contains('d-none')) {
                    document.querySelectorAll('.filter-block').forEach(el => el.classList.add('d-none'));
                    target.classList.remove('d-none');
                } else {
                    target.classList.add('d-none');
                }
            });
        });
    </script>
    <!--====== Start Header Section ======-->
    <header class="header-area">
        <div class="header-navigation style-one" style="height: 125px;">
            <div class="container">
                <div class="primary-menu" style="padding-top: 23px;">
                    <div class="site-branding d-lg-none d-block">
                        <a href="{{ route('Websitehome') }}" class="brand-logo"><img
                                src="{{ asset('website/assets/images/TH-Logo.png') }}" alt="Logo"></a>
                    </div>
                    <div class="nav-inner-menu">
                        <div class="logo-wrap d-none d-lg-block">
                            <a href="{{ route('Websitehome') }}">
                                <img src="{{ asset('website/assets/images/TH-Logo.png') }}" alt="Company Logo"
                                    style="height: 60px;">
                            </a>
                        </div>
                        <div class="pesco-nav-main">
                            <div class="pesco-nav-menu">
                                {{-- <div class="nav-search mb-40 d-block d-lg-none">
                                    <div class="form-group">
                                        <input type="search" class="form_control" placeholder="Search Here"
                                            name="search">
                                        <button class="search-btn"><i class="far fa-search"></i></button>
                                    </div>
                                </div> --}}
                                <div class="pesco-tabs style-three d-block d-lg-none">
                                    <ul class="nav nav-tabs mb-30" role="tablist">
                                        <li>
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#nav1" role="tab">Menu</button>
                                        </li>
                                        <li>
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav2"
                                                role="tab">Category</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="nav1">
                                            <nav class="main-menu">
                                                <ul>
                                                    <li class="menu-item"><a
                                                            href="{{ route('Websitehome') }}">Home</a></li>

                                                    <li class="menu-item has-children"><a
                                                            href="{{ route('about.us') }}#about-us">About Us</a>
                                                        {{-- <ul class="sub-menu">
                                                            <li><a href="blogs.html">Our Blog</a></li>
                                                            <li><a href="blog-details.html">Blog Details</a></li>
                                                        </ul> --}}
                                                    </li>
                                                    {{-- <li class="menu-item has-children"><a href="{{route('pages')}}">Pages</a>
                                                        <ul class="sub-menu">
                                                            <li><a href="{{ route('about.us') }}#about-us">About Us</a></li>
                                                            <li><a href="faq.html">Faqs</a></li>
                                                        </ul>
                                                    </li> --}}
                                                    <li class="menu-item has-children"><a
                                                            href="{{ route('gallery') }}">Photo Gallery</a>

                                                    </li>
                                                    <li class="menu-item"><a
                                                            href="{{ route('contact') }}">Contact</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="tab-pane fade" id="nav2">
                                            <div class="categori-dropdown-item">
                                                <ul>
                                                    @foreach ($categories as $cat)
                                                        <li><a
                                                                href="{{ route('view.category', $cat->id) }}">{{ $cat->name }}</a>
                                                        </li>
                                                    @endforeach
                                                    {{-- <li><a href="shops.html"><img
                                                                src="{{ asset('website/assets/images/icon/denim.png') }}"
                                                                alt="Jeans">Denim Jeans</a></li>
                                                    <li><a href="shops.html"><img
                                                                src="{{ asset('website/assets/images/icon/suit.png') }}"
                                                                alt="Suit">Casual Suit</a></li>
                                                    <li><a href="shops.html"><img
                                                                src="{{ asset('website/assets/images/icon/dress.png') }}"
                                                                alt="Dress">Summer Dress</a></li>
                                                    <li><a href="shops.html"><img
                                                                src="{{ asset('website/assets/images/icon/sweaters.png') }}"
                                                                alt="Sweaters">Sweaters</a></li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <nav class="main-menu d-none d-lg-block"
                                    style="font-family: 'Source Sans 3', sans-serif;">
                                    <ul style="padding-left: 0px;">
                                        <li class="menu-item"><a href="{{ route('Websitehome') }}">HOME</a></li>
                                        <li class="menu-item"><a href="{{ route('about.us') }}#about-us">ABOUT US</a>
                                        </li>
                                        <li class="menu-item has-children">
                                            <a href="#">CATEGORIES <i class="fa fa-angle-down"
                                                    aria-hidden="true"></i></a>
                                            <ul class="sub-menu">
                                                @foreach ($categories as $cat)
                                                    <li><a
                                                            href="{{ route('view.category', $cat->id) }}">{{ $cat->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li class="menu-item"><a href="{{ route('gallery') }}">PHOTO GALLERY</a></li>
                                        <li class="menu-item"><a href="{{ route('contact') }}">CONTACT</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nav-right-item style-one">
                        <ul style="gap: 8px;">
                            <li>
                                {{-- <div class="search-container position-relative">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Search products..." autocomplete="off">
                                    <div id="searchResults" class="position-absolute w-100 mt-1"
                                        style="z-index: 1000; background: #fff; border: 1px solid #ddd; border-radius: 4px; max-height: 300px; overflow-y: auto;">
                                    </div>
                                </div> --}}
                            </li>
                            <li>
                                <a href="{{ route('wishlist') }}"
                                    class="wishlist-btn d-lg-block d-none position-relative">
                                    <img src="{{ asset('website/assets/images/whishlist.png') }}" alt="Wishlist"
                                        style="width: 20px; height: 20px;">
                                    {{-- @if (isset($wishlist_count) && $wishlist_count > 0) --}}
                                    <span class="pro-count wishlist-count"
                                        style="top: 4px;right: -5px;">{{ $wishlist_count ?? 0 }}</span>
                                    {{-- @endif --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cartPage') }}" class="icon-btn position-relative">
                                    <img src="{{ asset('website/assets/images/cart.png') }}" alt="Cart"
                                        style="width: 20px; height: 20px;">
                                    {{-- @if (isset($cart_items) && $cart_items > 0) --}}
                                    <span class="pro-count">{{ $cart_items }}</span>
                                    {{-- @endif --}}
                                </a>
                                <div class="position-absolute" style="right: 85px; top: 100px;">

                                    @if (session('error'))
                                        <div id="failMessage" class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div id="successMessage" class="alert"
                                            style="background: #FF9E8B;border:2px solid #DE2300;z-index:999;">
                                            <b style="color:black;"> {{ session('success') }}</b>
                                        </div>
                                    @endif

                                </div>
                            </li>
                            <li>
                                <div class="cart-button d-flex align-items-center">
                                    <div class="icon">
                                        <img src="{{ asset('website/assets/images/sidebar.png') }}" alt="Menu"
                                            style="width: 20px; height: 20px;">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="navbar-toggler d-block d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--====== End Header Section ======-->
    <!--====== Profile Image Camera Script ======-->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('cameraInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const img = document.querySelector('.profile-wrapper img');
                img.src = URL.createObjectURL(file);
            }
        });

        $(document).ready(function() {
            setTimeout(function() {
                $("#successMessage, #failMessage").fadeOut('slow');
            }, 3000);


            document.querySelectorAll('.wishlist-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const productId = this.dataset.productId;
                    const isWishlisted = this.classList.contains('text-danger');

                    if (!{{ Auth::check() ? 'true' : 'false' }}) {
                        alert('Please log in to manage your wishlist.');
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    const url = isWishlisted ?
                        '{{ route('wishlist.remove', ['id' => ':id']) }}'.replace(':id',
                            productId) :
                        '{{ route('wishlist.add') }}';
                    const method = isWishlisted ? 'DELETE' : 'POST';
                    const body = isWishlisted ? {} : {
                        product_id: productId
                    };

                    fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify(body),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.classList.toggle('text-danger');
                                alert(data.message);
                            } else {
                                alert(data.message || 'An error occurred.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating your wishlist.');
                        });
                });
            });
        });
    </script>
</body>

</html> --}}
