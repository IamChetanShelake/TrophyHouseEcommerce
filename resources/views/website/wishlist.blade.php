@section('title', 'Trophy House - Wishlist')
@extends('website.layout.master')
@section('content')
    <main class="main-bg" style="background-color: #fff9e6;">
        <!--====== Start Page Banner Section ======-->
        <section class="page-banner-section py-5">
            <div class="container position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="page-banner-content">
                            <h1 class="mb-3" style="font-family: 'Times New Roman', serif; color: #e63946; font-size: 36px; font-weight: bold;">
                                Your Wishlist
                            </h1>
                            <nav aria-label="breadcrumb" style="font-family: 'Source Sans 3', sans-serif;">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('Websitehome') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <!-- <div class="shape shape-one">
                    <img src="{{ asset('website/assets/images/shape/curved-arrow.png') }}" alt="Curved Arrow" class="img-fluid">
                </div> -->
            </div>
        </section>
        <!--====== End Page Banner Section ======-->

        <!--====== Start Wishlist Section ======-->
        <section class="wishlist-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wishlist-wrapper" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                            <div class="table-responsive">
                                <table class="table wishlist-table">
                                    <thead>
                                        <tr style="font-family: 'Source Sans 3', sans-serif; background-color: #fff8dc; color: #333;">
                                            <th scope="col"><i class="fas fa-image me-2"></i> Image</th>
                                            <th scope="col"><i class="fas fa-tshirt me-2"></i> Product Details</th>
                                            <th scope="col"><i class="fas fa-sack-dollar me-2"></i> MRP</th>
                                            <th scope="col"><i class="fas fa-trash me-2"></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($wishlistItems as $item)
                                            <tr data-wishlist-id="{{ $item->id }}" style="font-family: 'Source Sans 3', sans-serif;">
                                                <td>
                                                    <div class="product-img">
                                                        <img src="{{ asset('product_images/' . $item->product->image) }}"
                                                             alt="{{ $item->product->title }}"
                                                             style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-info">
                                                        <h5 class="mb-1">
                                                            <a href="#"
                                                               style="color: #333; text-decoration: none;">Code - {{ $item->product->title }}
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-0" style="font-size: 14px;">
                                                            <!--{!! Str::limit($item->product->description, 50) !!}-->
                                                            {{$item->product->category->name }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="price" style="color: #e63946; font-weight: 600;">
                                                        <span class="currency">₹</span>
                                                        <span class="unit-price">{{ $item->product->variants->first()->price ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                
                                                <td>
                                                    <button class="btn btn-sm btn-danger cart-remove" data-wishlist-id="{{ $item->id }}"
                                                            style="background: #e63946; border: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5" style="font-family: 'Source Sans 3', sans-serif; color: #666;">
                                                    Your wishlist is empty. <a href="{{ route('Websitehome') }}" style="color: #e63946;">Explore products now!</a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="wishlist-footer text-end mt-4" style="font-family: 'Source Sans 3', sans-serif;">
                                <form action="{{ route('wishlist.proceedToCart') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary theme-btn"
                                            style="background: #e63946; border: none; color: white; padding: 10px 20px; border-radius: 20px;">
                                        Proceed to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--====== End Wishlist Section ======-->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quantity controls
            document.querySelectorAll('.quantity-down').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.quantity');
                    let quantity = parseInt(input.value);
                    if (quantity > 1) {
                        quantity--;
                        input.value = quantity;
                        updateQuantity(this.closest('tr').dataset.wishlistId, quantity);
                    }
                });
            });

            document.querySelectorAll('.quantity-up').forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('.quantity');
                    let quantity = parseInt(input.value);
                    quantity=quantity+1;
                    input.value = quantity;
                    updateQuantity(this.closest('tr').dataset.wishlistId, quantity);
                });
            });

            // Remove from wishlist
            document.querySelectorAll('.cart-remove').forEach(button => {
                button.addEventListener('click', function () {
                    const wishlistId = this.dataset.wishlistId;
                    removeFromWishlist(wishlistId, this.closest('tr'));
                });
            });

            function updateQuantity(wishlistId, quantity) {
                fetch('{{ route('wishlist.updateQuantity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        wishlist_item_id: wishlistId,
                        quantity: quantity,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            function removeFromWishlist(wishlistId, row) {
                if (confirm('Are you sure you want to remove this item from your wishlist?')) {
                    fetch('{{ route('wishlist.remove', ['id' => ':id']) }}'.replace(':id', wishlistId), {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                             updateWishlistCount(data.count);
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                document.querySelector('tbody').innerHTML = `
                                    <tr>
                                        <td colspan="5" class="text-center py-5" style="font-family: 'Source Sans 3', sans-serif; color: #666;">
                                            Your wishlist is empty. <a href="{{ route('Websitehome') }}" style="color: #e63946;">Explore products now!</a>
                                        </td>
                                    </tr>
                                `;
                            }
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });
        function updateWishlistCount(count) {
    const wishlistCountElement = document.querySelector('.wishlist-count');
    if (wishlistCountElement) {
        wishlistCountElement.textContent = count || 0;
    }
}
    </script>

    <style>
        .page-banner-section {
            background: linear-gradient(to right, #fff8e1, #ffd9c7);
            position: relative;
            overflow: hidden;
        }

        .page-banner-content .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb-item a:hover {
            color: #e63946;
        }

        .breadcrumb-item.active {
            color: #e63946;
            font-weight: 600;
        }

        .shape-one img {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
            opacity: 0.3;
            z-index: 0;
        }

        .wishlist-section {
            background: #fff9e6;
        }

        .wishlist-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .wishlist-table thead th {
            font-weight: 600;
            font-size: 16px;
            padding: 15px;
            border-bottom: 2px solid #facc15;
        }

        .wishlist-table tbody tr {
            transition: background-color 0.3s;
        }

        .wishlist-table tbody tr:hover {
            background-color: #fff8dc;
        }

        .wishlist-table td {
            vertical-align: middle;
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
        }

        .product-info h5 a:hover {
            color: #e63946;
        }

        .quantity-input .quantity-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            transition: all 0.3s;
            border-radius: 8px;
        }

        .quantity-input .quantity-btn:hover {
            background: #facc15;
            color: #e63946;
        }

        .quantity-input .quantity {
            border: 1px solid #facc15;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .cart-remove {
            transition: all 0.3s;
        }

        .cart-remove:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .theme-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .wishlist-table thead th {
                font-size: 14px;
                padding: 10px;
            }

            .wishlist-table td {
                padding: 10px;
            }

            .product-img img {
                width: 60px;
                height: 60px;
            }

            .product-info h5 {
                font-size: 16px;
            }

            .quantity-input .quantity-btn {
                width: 35px;
                height: 35px;
            }

            .quantity-input .quantity {
                width: 45px;
                font-size: 14px;
            }

            .wishlist-footer {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .wishlist-table {
                font-size: 14px;
            }

            .wishlist-table thead {
                display: none;
            }

            .wishlist-table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #f1f1f1;
                border-radius: 8px;
                padding: 10px;
            }

            .wishlist-table tbody td {
                display: block;
                text-align: center;
                border: none;
                padding: 5px;
            }

            .wishlist-table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #e63946;
                display: block;
                margin-bottom: 5px;
            }

            .quantity-input {
                justify-content: center;
            }
        }
    </style>
@endsection