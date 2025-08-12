@extends('website.layout.master')
@section('content')
    <style>
        /* Sidebar Styling */
        .sidebar-filter {
            background: #fff;
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 10px;
            font-family: 'Source Sans 3', sans-serif;
             height: 1050px;
            overflow-y: auto
        }

        .sidebar-filter h6 {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-filter .filter-section+.filter-section {
            border-top: 1px solid #e0e0e0;
            margin-top: 20px;
            padding-top: 20px;
        }

        .sidebar-filter .form-check {
            margin-bottom: 8px;
        }

        .sidebar-filter .form-check-label {
            font-weight: 400;
            font-size: 14px;
            color: #333;
        }

        .sidebar-filter .active-category {
            color: #e63946;
            font-weight: 600;
        }

        /* Product Card Styling */
        .trophy-card {
            border: 1px solid #f5f5f5;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            /*padding: 10px;*/
            background: white;
        }

        .trophy-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .trophy-hover-bar {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 5px;
            /*margin:14px 25px;*/
        }

        .trophy-hover-bar i,
        .trophy-hover-bar .add-to-cart-btn {
            cursor: pointer;
            font-size: 14px;
        }

        .add-to-cart-btn {
            background: #e63946;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .product-id {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        /* Filter Button Styling */
        .filter-btn {
            border: 1px solid #e6bebe;
            border-radius: 12px;
            padding: 6px 45px;
            background-color: white;
            color: #333;
            font-weight: 500;
            transition: 0.3s ease;
            box-shadow: -1px 2px 3px #00000038;
        }

        .filter-btn:hover {
            /* background: #ffe8ae; */
            background: linear-gradient(to right, #fff8e1, #FFDE57);
            color: #000;
        }

        .filter-btn.active {
            background: linear-gradient(to right, #fff8e1, #FFDE57);
            color: #222;
            font-weight: 600;
        }

        #clearFiltersBtn:active {
            background-color: #86111d;
        }

        @media (max-width: 991px) {
            .responsive-wrapper {
                display: flex;
                flex-direction: column;
            }

            .filter-bar-section {
                order: 1;
            }

            .sidebar-section {
                display: none;
            }

            .products-section {
                order: 3;
            }

            .sidebar-filter {
                display: none;
            }

            .main-bg {
                background-color: #f8f9fa;

            }

            .card.trophy-card {
                margin-left: 52px !important;
            }

        }

        @media (max-width: 380px) {
            .card.trophy-card {
                margin-left: 25px !important;
            }
        }

        /* pagination styling  */
        <style>.custom-pagination-wrapper nav {
            display: flex;
            justify-content: center;
        }

        .pagination {
            gap: 10px;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination .page-link {
            color: #333;
            font-weight: 600;
            border: none;
            background: transparent;
            box-shadow: none;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(to bottom right, #ffed8b, #ffd966);
            color: #d00000;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-weight: 700;
            padding: 6px 18px;
        }

        .text-muted {

            display: none;
        }

        . .pagination .page-link:hover {
            background: rgba(255, 238, 144, 0.3);
            border-radius: 8px;
        }
    </style>

    </style>

    <main class="main-bg" style="background-color: white;">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-2 px-2 py-4">
                    <div class="sidebar-filter">
                        <!-- Categories -->
                        <div class="filter-section">
                            <h6>
                                <img src="{{ asset('website/assets/images/categories.png') }}" alt="Icon"
                                    style="width: 16px; height: 16px; margin-right: 8px;">
                                Categories
                            </h6>
                            <ul class="list-unstyled">
                                @foreach ($categories as $cat)
                                    <li class="mb-1 d-flex gap-2">
                                        <input class="form-check-input category-filter" type="checkbox"
                                            value="{{ $cat->id }}" id="category{{ $cat->id }}">
                                        <label for="category{{ $cat->id }}" class="form-check-label category-link"
                                            data-category-id="{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Price -->
                        <div class="filter-section">
                            <h6><img src="{{ asset('website/assets/images/price.png') }}" alt="Icon"
                                    style="width: 20px; height: 20px; margin-right: 8px;"> Price</h6>
                            @foreach ($priceRanges as $i => $price)
                                <div class="form-check">
                                    <input class="form-check-input price-filter" type="checkbox" value="{{ $price }}"
                                        id="price{{ $i }}">
                                    <label class="form-check-label"
                                        for="price{{ $i }}">{{ $price }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Colours -->
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

                        <!-- Sizes -->

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

                        <!-- Clear Filters Button -->
                        <div class="text-start mt-3">
                            <button class="btn btn-sm btn-outline-danger" id="clearFiltersBtn">Clear All Filters</button>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="col-lg-10 px-2 py-4">
                    <h2 class="mb-4" id="selected-category-title"
                        style="color: #e63946; font-family: 'Source Sans 3', sans-serif; font-weight: bold;">
                        All Products
                    </h2>

                    <!-- Subcategory Buttons -->
                    <div id="subcategory-buttons" class="mb-4 d-flex flex-wrap gap-2 justify-content-center">
                        @foreach ($categories as $cat)
                            @foreach ($cat->subcategories as $subcat)
                                <button class="btn filter-btn subcategory-btn" data-category-id="{{ $cat->id }}"
                                    data-subcategory-id="{{ $subcat->id }}">
                                    {{ $subcat->title }}
                                </button>
                            @endforeach
                        @endforeach
                    </div>

                    <p class="text-center text-danger fw-bold d-none" id="no-products-msg">
                        <img src="{{ asset('images/dummyTrophy.jpg') }}" style="width:60px;" alt=""> Product Not
                        Found
                    </p>

                    <div class="row" id="products-wrapper"
                        style="margin-left:-9px !important; margin-right:27px !important;">
                        @foreach ($products as $prod)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-3 mb-4 product-box"
                                data-category-id="{{ $prod->category_id }}"
                                data-subcategory-id="{{ $prod->sub_category_id }}"
                                data-price="{{ $prod->variants->first()->discounted_price ?? 0 }}"
                                data-colors="{{ implode(',', $prod->variants->pluck('color')->flatten()->unique()->toArray()) }}"
                                data-sizes="{{ implode(',', $prod->variants->pluck('size')->unique()->toArray()) }}">
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
                                                    <input type="hidden" name="product_id" value="{{ $prod->id }}">
                                                     <input type="hidden" name="variant_id" value="{{ $prod->variants->first()->id ?? '' }}">
                                                    <button type="submit" class="add-to-cart-btn">Add To Cart</button>
                                                </form>
                                                <i class="fas fa-share icon-toggle"></i>
                                            </div>
                                        </div>
                                        <div class="card-body py-2">
                                            <p class="mb-1 product-id"> {{ $prod->title }}</p>
                                            <p class="mb-0 text-danger fw-bold">
                                                {{ $prod->variants->first()->discounted_price ?? 'N/A' }} Rs
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>


                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryInputs = document.querySelectorAll('.category-filter');
            const priceInputs = document.querySelectorAll('.price-filter');
            const colorInputs = document.querySelectorAll('.color-filter');
            const sizeInputs = document.querySelectorAll('.size-filter');
            const subcategoryButtons = document.querySelectorAll('.subcategory-btn');
            const products = document.querySelectorAll('.product-box');
            const categoryTitle = document.getElementById('selected-category-title');
            const clearFiltersBtn = document.getElementById('clearFiltersBtn');

            let selectedSubcategory = null;

            function parsePriceRange(range) {
                const clean = range.replace(/[₹,\s]/g, '');
                if (clean.toLowerCase().includes('above')) return [5000, Infinity];
                return clean.split('-').map(Number);
            }

            function filterProducts() {
                const selectedCategories = Array.from(categoryInputs).filter(cb => cb.checked).map(cb => cb.value);
                const selectedPrices = Array.from(priceInputs).filter(cb => cb.checked).map(cb => cb.value);
                const selectedColors = Array.from(colorInputs).filter(cb => cb.checked).map(cb => cb.value
                    .toLowerCase());
                const selectedSizes = Array.from(sizeInputs).filter(cb => cb.checked).map(cb => cb.value
                    .toLowerCase());

                let anyVisible = false;

                products.forEach(prod => {
                    const catId = prod.getAttribute('data-category-id');
                    const subcatId = prod.getAttribute('data-subcategory-id');
                    const price = parseFloat(prod.getAttribute('data-price'));
                    const colors = prod.getAttribute('data-colors').toLowerCase().split(',');
                    const sizes = prod.getAttribute('data-sizes').toLowerCase().split(',');

                    const matchCategory = selectedCategories.length === 0 || selectedCategories.includes(
                        catId);
                    const matchSubcategory = !selectedSubcategory || selectedSubcategory === subcatId;
                    const matchPrice = selectedPrices.length === 0 || selectedPrices.some(range => {
                        const [min, max] = parsePriceRange(range);
                        return price >= min && price <= max;
                    });
                    const matchColor = selectedColors.length === 0 || selectedColors.some(c => colors
                        .includes(c));
                    const matchSize = selectedSizes.length === 0 || selectedSizes.some(selectedLabel => {
                        return sizes.some(actualSize => {
                            const sizeNum = parseFloat(actualSize);

                            if (selectedLabel === 'below 5 inch') return sizeNum < 5;
                            if (selectedLabel === '5-8 inch') return sizeNum >= 5 &&
                                sizeNum <= 8;
                            if (selectedLabel === '8-10 inch') return sizeNum > 8 &&
                                sizeNum <= 10;
                            if (selectedLabel === '10-12 inch') return sizeNum > 10 &&
                                sizeNum <= 12;
                            if (selectedLabel === '12-15 inch') return sizeNum > 12 &&
                                sizeNum <= 15;
                            if (selectedLabel === '15-18 inch') return sizeNum > 15 &&
                                sizeNum <= 18;
                            if (selectedLabel === '18-24 inch') return sizeNum > 18 &&
                                sizeNum <= 24;
                            if (selectedLabel === '24-36 inch') return sizeNum > 24 &&
                                sizeNum <= 36;
                            if (selectedLabel === '36 inch and above') return sizeNum > 36;

                            return false;
                        });
                    });


                    if (matchCategory && matchSubcategory && matchPrice && matchColor && matchSize) {
                        prod.style.display = 'block';
                        anyVisible = true;
                    } else {
                        prod.style.display = 'none';
                    }
                });

                document.getElementById('no-products-msg').classList.toggle('d-none', anyVisible);

            }

            function updateVisibleSubcategories() {
                const selectedCategories = Array.from(categoryInputs).filter(cb => cb.checked).map(cb => cb.value);
                subcategoryButtons.forEach(button => {
                    const btnCatId = button.getAttribute('data-category-id');
                    if (selectedCategories.length === 0 || selectedCategories.includes(btnCatId)) {
                        button.style.display = 'inline-block';
                    } else {
                        button.style.display = 'none';
                    }
                });
            }

            subcategoryButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    selectedSubcategory = this.getAttribute('data-subcategory-id');
                    categoryTitle.textContent = this.textContent;
                    filterProducts();
                });
            });

            [...categoryInputs, ...priceInputs, ...colorInputs, ...sizeInputs].forEach(input => {
                input.addEventListener('change', filterProducts);
            });

            categoryInputs.forEach(input => {
                input.addEventListener('change', updateVisibleSubcategories);
            });

            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function() {
                    [...categoryInputs, ...priceInputs, ...colorInputs, ...sizeInputs].forEach(cb => cb
                        .checked = false);
                    selectedSubcategory = null;
                    categoryTitle.textContent = 'All Products';
                    updateVisibleSubcategories();
                    filterProducts();
                });
            }

            filterProducts();
            updateVisibleSubcategories();
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
@endsection
