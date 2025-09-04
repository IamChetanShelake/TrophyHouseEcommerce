@section('title', 'Trophy House - Category')
@extends('website.layout.master')
@section('content')
    <style>
        .subcategory-box {
            transition: transform 0.3s ease;
        }

        .subcategory-box:hover {
            transform: scale(1.08);
            /* adjust scale factor as needed */
        }
    </style>
    <main class="main-bg" style="background-color: white;">
        <!-- Category Section -->
        <section class="category-section" style="background-color: white;">
            <div class="container mt-5">
                <h2 class="mb-4 text-center"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    {{ $category->name }}
                </h2>
                <h4 class="text-center mb-5"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    "Sub-categories"
                </h4>
                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                    {{-- <!-- All Products Tab -->
                    <div class="text-center subcategory-box" data-subcategory-id="all">
                        <div class="card p-2 subcategory-tab" data-subcategory-id="all" style="cursor: pointer; width: 100px; border: none;">
                            <img src="{{ asset('images/all-products.png') }}" alt="All Products" style="max-height: 100px; object-fit: contain;" class="img-fluid mb-2">
                            <h6 class="mb-0">All Products</h6>
                        </div>
                    </div> --}}
                    @foreach ($subcategories as $sub)
                        <div class="text-center subcategory-box" data-subcategory-id="{{ $sub->id }}">
                            <div class="card p-2 subcategory-tab" data-subcategory-id="{{ $sub->id }}"
                                style="cursor: pointer; width: 100px; border: none;">
                                <img src="{{ asset('sub-category_images/' . $sub->image) }}" alt="{{ $sub->title }}"
                                    style="max-height: 100px; object-fit: contain;" class="img-fluid mb-2">
                                <div class="yellow-base"></div>
                                <h6 class="mb-0">{{ $sub->title }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="trophy-section py-5" style="background-color: white;">
            <div class="container-fluid">
                <h4 class="text-center mb-5"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    Products
                </h4>
                <div class="row justify-content-center text-center py-5"
                    style="background: linear-gradient(90deg, #fff7dc, #FFDE57);">
                    <p class="text-center text-danger fw-bold d-none" id="no-products-msg">
                        <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                        Product Not Found
                    </p>
                    <div class="trophy-card-wrapper position-relative">
                        <div class="row justify-content-center text-center position-relative" id="products-wrapper">
                            @foreach ($products as $prod)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 top-pick-product"
                                    data-subcategory-id="{{ $prod->sub_category_id }}">
                                    <div class="card trophy-card text-center shadow-md">
                                        <a href="{{ route('productDetail', $prod->id) }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                                    class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: contain;padding:10px;" />
                                                <div class="trophy-hover-bar">
                                                    <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                        data-product-id="{{ $prod->id }}" title="Toggle Wishlist"></i>
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
                                                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                    </form>
                                                    {{-- <i class="fas fa-share icon-toggle"></i> --}}
                                                    <i class="fas fa-share icon-toggle share-icon"
                                                        data-share-link="{{ route('productDetail', $prod->id) }}"></i>
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
            </div>
        </section>

        <!-- JavaScript -->
        <script>
            document.querySelectorAll('.subcategory-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const subcatId = this.dataset.subcategoryId;
                    const wrapper = document.getElementById('products-wrapper');
                    const noProductsMsg = document.getElementById('no-products-msg');
                    const productDetailUrl = "{{ url('/productDetail') }}";
                    if (subcatId === 'all') {
                        // Show all products
                        noProductsMsg.classList.add('d-none');
                        document.querySelectorAll('.top-pick-product').forEach(product => {
                            product.style.display = 'block';
                        });
                    } else {
                        // Fetch subcategory products
                        fetch(`/subcategory-products/${subcatId}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content
                                }
                            })
                            .then(response => {
                                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                                return response.json();
                            })
                            .then(data => {
                                wrapper.innerHTML = ''; // Clear existing products

                                if (data.products && data.products.length > 0) {
                                    noProductsMsg.classList.add('d-none');
                                    data.products.forEach(prod => {
                                        wrapper.innerHTML += `
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 top-pick-product" data-subcategory-id="${prod.sub_category_id}">
                                            <div class="card trophy-card text-center shadow-md">
                                                <a href="/ProductDetail/${prod.id}">
                                                    <div class="position-relative">
                                                        <img src="/product_images/${prod.image}" class="img-fluid" style="height:150px; object-fit:contain;padding:10px;">
                                                        <div class="trophy-hover-bar">
                                                            <i class="fas fa-heart icon-toggle wishlist-toggle ${prod.is_in_wishlist ? 'text-danger' : ''}" 
   data-product-id="${prod.id}" 
   title="Toggle Wishlist">
</i>
                                                            <form action="/add-to-cart" method="POST">
                                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                                                <input type="hidden" name="product_id" value="${prod.id}">
                                                                 <input type="hidden" name="variant_id" value="${prod.variants && prod.variants.length > 0 ? prod.variants[0].id : ''}">
    <input type="hidden" name="color" value="${prod.variants && prod.variants.length > 0 
        ? (
            Array.isArray(prod.variants[0].color) 
            ? prod.variants[0].color[0] 
            : (
                typeof prod.variants[0].color === 'string' && prod.variants[0].color.startsWith('[') 
                ? JSON.parse(prod.variants[0].color)[0] 
                : prod.variants[0].color
              )
          ) 
        : ''}">
                                                                <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                            </form>
                                                            
                                                            <i class="fas fa-share icon-toggle share-icon"
   data-share-link="${productDetailUrl}/${prod.id}"></i>

                                                        </div>
                                                    </div>
                                                    <div class="card-body py-2">
                                                        <p class="mb-1">${prod.title}</p>
                                                        <p class="text-danger fw-bold">${prod.variants && prod.variants.length > 0 ? prod.variants[0].discounted_price : 'N/A'} Rs</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>`;
                                    });
                                } else {
                                    noProductsMsg.classList.remove('d-none');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching products:', error);
                                noProductsMsg.classList.remove('d-none');
                            });
                    }
                });
            });
        </script>



    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const wishlistCountElement = document.querySelector('.wishlist-count');

            document.addEventListener('click', function(e) {
                const button = e.target.closest('.wishlist-toggle');
                if (!button) return;

                e.preventDefault();
                e.stopPropagation(); // Prevent parent link navigation

                const productId = button.dataset.productId;
                const isWishlisted = button.classList.contains('text-danger');

                // Check if user is authenticated
                if (!{{ Auth::check() ? 'true' : 'false' }}) {
                    alert('Please log in to manage your wishlist.');
                    window.location.href = '{{ route('login') }}';
                    return;
                }

                // Prepare the request
                const url = isWishlisted ?
                    '/wishlist/get-item/' + productId :
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
                            return fetch('{{ route('wishlist.remove', ['id' => ':id']) }}'.replace(
                                ':id', wishlistItemId), {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            }).then(response => response.json());
                        } else {
                            // Product added successfully
                            button.classList.add('text-danger');
                            updateWishlistCount(data.count);
                            alert(data.message);
                            return Promise.resolve(data);
                        }
                    })
                    .then(data => {
                        if (isWishlisted && data.success) {
                            button.classList.remove('text-danger');
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

            function updateWishlistCount(count) {
                if (wishlistCountElement) {
                    wishlistCountElement.textContent = count || 0;
                }
            }
        });
    </script>

@endsection
