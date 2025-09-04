@foreach ($products as $prod)
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 top-pick-product">
        <div class="card trophy-card text-center shadow-md">
            <a href="{{ route('productDetail', $prod->id) }}">
                <div class="position-relative">
                    <img src="{{ asset('product_images/' . $prod->image) }}" alt="{{ $prod->title }}" class="img-fluid"
                        style="height: 150px; width: 100%; object-fit: contain; padding:10px;" />

                    <div class="trophy-hover-bar mt-1 d-flex justify-content-around">
                        <!-- Wishlist -->
                        <i class="fas fa-heart icon-toggle wishlist-toggle {{ in_array($prod->id, $wishlist_product_ids ?? []) ? 'text-danger' : '' }}"
                            data-product-id="{{ $prod->id }}" title="Toggle Wishlist"></i>

                        <!-- Add to Cart -->
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $prod->id }}">
                            <input type="hidden" name="variant_id" value="{{ $prod->variants->first()->id ?? '' }}">
                            <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                        </form>

                        <!-- Share -->
                        <i class="fas fa-share icon-toggle share-icon"
                            data-share-link="{{ route('productDetail', $prod->id) }}"></i>
                    </div>
                </div>

                <div class="card-body py-2">
                    <p class="mb-1 product-id">{{ Str::limit($prod->title, 25) }}</p>

                    <p class="mb-0 text-danger fw-bold">
                        @if ($prod->variants->count())
                            {{ $prod->variants->first()->discounted_price }} Rs
                        @else
                            N/A
                        @endif
                    </p>

                </div>
            </a>
        </div>
    </div>
@endforeach

@if ($products->isEmpty())
    <p class="text-center text-danger fw-bold">No products found in this range.</p>
@endif
