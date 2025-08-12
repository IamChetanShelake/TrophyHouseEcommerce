@extends('website.layout.master')
@section('content')
    <section class="container py-4">
        <a href="{{ url()->previous() }}">
            <p class="text-danger mb-4" style="font-family: 'Times New Roman', Times, serif; font-size:36px; font-weight:700;">
                < Product details
            </p>
        </a>

        <div class="row gy-4">
            <div class="col-md-5 d-flex justify-content-center align-items-start">
                @if ($product->image)
                    <img src="{{ asset('product_images/' . $product->image) }}" alt="{{ $product->title }}" class="product-image img-fluid">
                @else
                    <img src="{{ asset('images/dummyTrophy.jpg') }}" alt="{{ $product->title }}" class="product-image img-fluid">
                @endif
            </div>

            <div class="col-md-7">
                <div class="row mb-4">
                    @php
                        $variants = $product->variants;
                        $firstVariant = $variants->first();
                        $basePrice = $firstVariant->price ?? 0;
                        $gst = $basePrice * 0.18;
                        $finalPrice = $basePrice + $gst;
                    @endphp

                    <div class="col-md-6">
                        <p class="fw-bold mb-3" style="font-family: 'Times New Roman', Times, serif; font-size:32px; font-weight:700;">
                             {{ $product->title }}
                        </p>
                        <p class="text-success mb-4" style="font-family:'Source Sans 3', sans-serif; font-size:16px;">In Stock</p>

                        <!-- Price + GST Display -->
                        <p class="mb-0" style="font-family:'Source Sans 3', sans-serif; font-size:20px;">
                            <strong>₹<span id="basePrice">{{ number_format($basePrice, 2) }}</span></strong>
                            <small class="text-muted">(excl. 18% GST)</small>
                        </p>
                        <p class="mb-3" style="font-family:'Source Sans 3', sans-serif; font-size:20px;">
                            ₹<span id="finalPrice">{{ number_format($finalPrice, 2) }}</span>
                            <small class="text-muted">(incl. ₹<span id="gstAmount">{{ number_format($gst, 2) }}</span> GST @18%)</small>
                        </p>

                        <!-- Sizes -->
                        <p class="mb-3"><strong>Sizes</strong></p>
                        <div class="d-flex flex-wrap mb-3" id="sizeOptions">
                            @foreach ($variants as $variant)
                                <div class="size-option {{ $loop->first ? 'active' : '' }}"
                                    onclick="selectSize(this, '{{ $variant->size }}', {{ $variant->price }}, {{ $variant->id }})">
                                    {{ $variant->size }} - inch
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quantity & Cart -->
                    <div class="col-md-6">
                        <div class="price-box position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0"><strong>Size: <span id="selectedSize">{{ $firstVariant->size ?? 'N/A' }}</span> - inch</strong></p>
                            </div>

                            <div class="d-flex align-items-center justify-content-start mb-3">
                                <!--<div class="d-flex align-items-center px-3 py-1" style="gap: 30px;border: 1px solid rgba(255, 214, 206, 1);">-->
                                <!--    <button class="btn btn-outline me-1" type="button" onclick="changeQty(-1)">−</button>-->
                                <!--    <span id="quantity">1</span>-->
                                <!--    <button class="btn btn-outline ms-1" type="button" onclick="changeQty(1)">+</button>-->
                                <!--</div>-->
                                <button class="btn wishlist-btn"  data-product-id="{{ $product->id }}">
                                    <span class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($product->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"  data-product-id="{{ $product->id }}" title="Toggle Wishlist" onclick="toggleWishlist(this)"></span>
                                   
                                    Add to Wishlist
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p style="font-family: Source Sans 3;" class="mb-0"><strong>Total Price</strong></p>
                                <p class="mb-0" style="margin-right: 20px;">
                                    <strong>₹<span id="totalPrice">{{ number_format($finalPrice, 2) }}</span></strong>
                                    <small class="text-muted">(incl. 18% GST)</small>
                                </p>
                            </div>

                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                <form action="{{ route('cart.add') }}" method="POST" id="cartForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="variant_id" id="selectedVariantId" value="{{ $firstVariant->id ?? '' }}">
                                    <input type="hidden" name="quantity" id="cartQuantity" value="1">
                                    <button type="submit" class="btn-size-style">Add to Cart</button>
                                </form>
                                <!--<button style="margin-left: 35px;" class="btn-size-style">Customization</button>-->
                            </div>

                            <!-- Toast Message -->
                            <div id="cartToast" class="cart-toast">
                                <img src="{{ asset('images/dummyTrophy.jpg') }}" alt="Trophy Icon">
                                <span>Added to cart</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="product-detail-title mb-3"><strong>Product Details</strong></h5>
                        <p class="product-detail-text mb-3">{!! $product->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trophy-section py-5" style="font-family: 'Times New Roman', serif;">
        <div class="container-fluid">
            <h3 class="mb-4" style="font-family: 'Source Sans 3', sans-serif; font-size: 24px; font-weight: bold; color: #333;padding-left:40px">
                Similar products you might like</h3>
            <div class="row justify-content-center text-center">
                <div class="trophy-card-wrapper position-relative" style="padding: 0px 50px 0px 50px;">
                    @if (count($similarProducts) > 4)
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @forelse ($similarProducts as $similarProduct)
                                    <div class="swiper-slide">
                                        <div class="col-12">
                                            <div class="card trophy-card zoom-on-hover text-center shadow-sm">
                                                <a href="{{ route('productDetail', $similarProduct->id) }}">
                                                    <div class="position-relative">
                                                        <img src="{{ asset('product_images/' . $similarProduct->image) }}" alt="{{ $similarProduct->title }}"
                                                            class="img-fluid" style="max-height: 150px; width: 100%; object-fit: contain;padding:10px;" />
                                                        <div class="trophy-hover-bar">
                                                            
                                                            <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($similarProduct->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                            data-product-id="{{ $similarProduct->id }}"
                                                            title="Toggle Wishlist"></i>
                                                            
                                                    
                                                            <form action="{{ route('cart.add') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $similarProduct->id }}">
                                                                 <input type="hidden" name="variant_id" value="{{ $similarProduct->variants->first()->id ?? '' }}">
                                                                <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                            </form>
                                                            <i class="fas fa-share icon-toggle"></i>
                                                        </div>
                                                    </div>
                                                    <div class="card-body py-2">
                                                        <p class="mb-1 product-id">{{ $similarProduct->title }}</p>
                                                        <p class="mb-0 text-danger fw-bold">
                                                            {{ $similarProduct->variants->first()->discounted_price ?? 'N/A' }} Rs
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-danger">No similar products available.</p>
                                @endforelse
                            </div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    @else
                        <div class="row justify-content-center text-center position-relative">
                            @forelse ($similarProducts as $similarProduct)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                                    <div class="card trophy-card zoom-on-hover text-center shadow-sm">
                                        <a href="{{ route('productDetail', $similarProduct->id) }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $similarProduct->image) }}" alt="{{ $similarProduct->title }}"
                                                    class="img-fluid" style="max-height: 150px; width: 100%; object-fit: contain;padding:10px;" />
                                                <div class="trophy-hover-bar">
                                                    <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($similarProduct->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                        data-product-id="{{ $similarProduct->id }}" title="Toggle Wishlist"></i>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $similarProduct->id }}">
                                                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                    </form>
                                                    <i class="fas fa-share icon-toggle"></i>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <p class="mb-1 product-id">{{ $similarProduct->title }}</p>
                                                <p class="mb-0 text-danger fw-bold">
                                                    {{ $similarProduct->variants->first()->discounted_price ?? 'N/A' }} Rs
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-danger">No similar products available.</p>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        let currentBasePrice = parseFloat("{{ $firstVariant->price ?? 0 }}");
        let currentQuantity = 1;

        function selectSize(element, size, price, variantId) {
            document.querySelectorAll('.size-option').forEach(el => el.classList.remove('active'));
            element.classList.add('active');

            currentBasePrice = parseFloat(price);
            const gst = currentBasePrice * 0.18;
            const finalPrice = currentBasePrice + gst;

            document.getElementById('selectedSize').innerText = size;
            document.getElementById('basePrice').innerText = currentBasePrice.toFixed(2);
            document.getElementById('gstAmount').innerText = gst.toFixed(2);
            document.getElementById('finalPrice').innerText = finalPrice.toFixed(2);
            document.getElementById('totalPrice').innerText = (finalPrice * currentQuantity).toFixed(2);
            document.getElementById('selectedVariantId').value = variantId;
        }

        function changeQty(delta) {
            currentQuantity = Math.max(1, currentQuantity + delta);
            document.getElementById('quantity').innerText = currentQuantity;
            document.getElementById('cartQuantity').value = currentQuantity;

            const gst = currentBasePrice * 0.18;
            const finalPrice = currentBasePrice + gst;
            document.getElementById('totalPrice').innerText = (finalPrice * currentQuantity).toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", function () {
            const wishlistButtons = document.querySelectorAll('.wishlist-toggle');
            const wishlistCountElement = document.querySelector('.wishlist-count');

            wishlistButtons.forEach(button => {
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

                    const url = isWishlisted ? '/wishlist/get-item/' + productId : '{{ route('wishlist.add') }}';
                    const method = isWishlisted ? 'GET' : 'POST';
                    const body = isWishlisted ? null : JSON.stringify({ product_id: productId });

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
                            const wishlistItemId = data.wishlist_item_id;
                            return fetch('{{ route('wishlist.remove', ['id' => ':id']) }}'.replace(':id', wishlistItemId), {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            }).then(response => response.json());
                        } else {
                            this.classList.add('text-danger');
                            updateWishlistCount(data.count);
                            alert(data.message);
                            return Promise.resolve(data);
                        }
                    })
                    .then(data => {
                        if (isWishlisted && data.success) {
                            this.classList.remove('text-danger');
                            updateWishlistCount(data.count);
                            alert(data.message);
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

            // Initialize Swiper if more than 4 products
            if (document.querySelector('.swiper-container')) {
                new Swiper('.swiper-container', {
                    slidesPerView: 4,
                    slidesPerGroup: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        320: { slidesPerView: 2, spaceBetween: 10, slidesPerGroup: 1 },
                        576: { slidesPerView: 3, spaceBetween: 15, slidesPerGroup: 1 },
                        768: { slidesPerView: 3, spaceBetween: 20, slidesPerGroup: 1 },
                        992: { slidesPerView: 4, spaceBetween: 20, slidesPerGroup: 1 }
                    }
                });
            }
        });
    </script>

    <style>
        .size-option {
            cursor: pointer;
            padding: 4px 1px;
            /*padding: 8px 16px;*/
            margin-right: 8px;
            border: 1px solid #ddd;
            border-radius: 11px;
            transition: all 0.3s;
        }
        .size-option.active {
            background-color: rgba(255, 197, 197, 0.5);
            color: #e63946;
            border-color: #e63946;
        }
        .btn-outline {
            border: 1px solid #ddd;
            background: rgba(235, 234, 234, 1);
            padding: 0px 10px;
            cursor: pointer;
            border-radius: 20px;
        }
        .btn-size-style {
            background-color: white;
            color: rgba(222, 35, 0, 1);
            border-color: rgba(222, 35, 0, 1);
            padding: 5px 20px;
            border-radius: 10px;
            cursor: pointer;
        }
        .cart-toast {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            z-index: 1000;
        }
        .cart-toast.show {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-toast img {
            width: 24px;
            height: 24px;
        }
        .swiper-button-prev,
        .swiper-button-next {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 40px;
            height: 40px;
        }
        .swiper-button-prev {
            background-image: url('{{ asset('website/assets/images/homePage/carousal-left.png') }}');
        }
        .swiper-button-next {
            background-image: url('{{ asset('website/assets/images/homePage/carousal-right.png') }}');
        }
        .swiper-button-prev::after,
        .swiper-button-next::after {
            content: '';
        }
    </style>
@endsection
