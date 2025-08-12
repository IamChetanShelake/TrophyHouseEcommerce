@extends('website.layout.master')
@section('content')

    <main class="main-bg" style="background-color: white;">
        <!-- Products Section -->
        <section class="trophy-section py-5" style="background-color: white;">
            <div class="container-fluid">
                <h2 class="text-center mb-5"
                    style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                    Products
                </h2>
                <p class="text-center text-danger fw-bold d-none" id="no-products-msg">
                    <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt="">
                    Product Not Found
                </p>
                <div class="row justify-content-center text-center py-5" style="background: linear-gradient(90deg, #fff7dc, #FFDE57);">
                    <div class="trophy-card-wrapper position-relative">
                        <div class="row justify-content-center text-center position-relative" id="products-wrapper">
                            @foreach ($products as $prod)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4"
                                   >
                                    <div class="card trophy-card text-center shadow-md">
                                        <a href="{{ route('productDetail', $prod->id) }}">
                                            <div class="position-relative">
                                                <img src="{{ asset('product_images/' . $prod->image) }}" alt="Trophy"
                                                    class="img-fluid"
                                                    style="height: 150px; width: 100%; object-fit: contain;" />
                                                <div class="trophy-hover-bar">
                                                    <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                                                        data-product-id="{{ $prod->id }}" title="Toggle Wishlist"></i>
                                                    <form action="{{ route('cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $prod->id }}">
                                                        <button type="submit" class="add-to-cart-btn">Add To Cart</button>
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
            </div>
        </section>
    </main>
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
@endsection
