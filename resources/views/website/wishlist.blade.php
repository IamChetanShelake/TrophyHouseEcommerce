@extends('website.layout.master')
@section('content')
    <main class="main-bg" style="background-color: white;">
    <div class="container-fluid py-4"  style="padding-right:30px;">
 <!-- Top Bar -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('Websitehome') }}" style="text-decoration:none; color:#d62828; font-size:24px; margin-right:10px;">
            <i class="fas fa-chevron-left"></i>
        </a>
        <div class="d-flex align-items-center">
            <h2 style="color:#d62828; font-family:'Times New Roman', serif; font-weight:bold; margin:0; font-size:28px;">
                Wishlist
            </h2>
            <small style="font-family: 'Source Sans 3', sans-serif; color:#000; font-size:14px; margin-left:10px;">
                {{ $wishlistItems->count() }} Items
            </small>
        </div>
    </div>
    <div class="d-flex align-items-center">
        {{-- <label for="category" class="me-2 fw-bold" style="color:#d62828;">Categories: Tropies</label> --}}
        <select id="category" class="form-select"
                style="width:auto; border:5px solid #e6bebe; border-radius:12px; padding:4px 30px 4px 10px;">
            @foreach($categories as $cat)
                <option>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
</div>



        <!-- Wishlist Products -->
        @if($wishlistItems->isEmpty())
            <div class="text-center py-5" style="font-family: 'Source Sans 3', sans-serif; color: #666;">
                Your wishlist is empty. <a href="{{ route('Websitehome') }}" style="color: #e63946;">Explore products</a>
            </div>
        @else
            <div class="row g-3 wishlist-grid">
                @foreach ($wishlistItems as $item)
                    @php $prod = $item->product; @endphp
                    @if(!$prod) @continue @endif
                    <div class="col-6 col-sm-4 col-md-3 col-lg-custom">
                        <div class="card trophy-card text-center wishlist-card" data-wishlist-id="{{ $item->id }}">
                            <a href="{{ route('productDetail', $prod->id) }}" style="text-decoration:none; color:inherit;">
                                <div class="position-relative">
                                    <img src="{{ asset('product_images/' . $prod->image) }}" alt="{{ $prod->title }}"
                                         class="img-fluid wishlist-img" />
                                    {{-- <div class="card-overlay">
                                        <button type="button" class="delete-btn cart-remove" data-wishlist-id="{{ $item->id }}" title="Remove">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div> --}}
                                </div>
                                {{-- <div class="card-body py-2">
                                    <p class="mb-1 product-id">{{ $prod->title }}</p>
                                    <p class="mb-0 text-danger fw-bold">
                                        {{ $prod->variants->first()->discounted_price ?? $prod->variants->first()->price ?? 'N/A' }} Rs
                                    </p>
                                </div> --}}

                                <div class="card-body py-2">
                                    <!-- Action bar -->
    <div class="action-bar-overlay d-flex justify-content-between align-items-center mb-2 action-bar">
        <!-- Delete -->
        <button type="button" class="icon-btn right-btn cart-remove" data-wishlist-id="{{ $item->id }}" title="Remove">
            <i class="fas fa-trash"></i>
        </button>

        <!-- Add to Cart -->
        <a href="{{ route('cart.add', $prod->id) }}" class="add-cart-btn">
            Add to Cart
        </a>
        <!-- Left arrow -->
        <a href="#" class="icon-btn left-btn" title="View Details">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    <p class="mb-1 product-id">{{ $prod->title }}</p>

    

    <p class="mb-0 text-danger fw-bold">
        {{ $prod->variants->first()->discounted_price ?? $prod->variants->first()->price ?? 'N/A' }} Rs
    </p>
</div>

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Proceed to Cart -->
            <div class="text-end mt-4">
                <form action="{{ route('wishlist.proceedToCart') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary"
                            style="background: #e63946; border: none; padding: 10px 20px; border-radius: 20px;">
                        Proceed to Cart
                    </button>
                </form>
            </div>
        @endif
    </div>
</main>

<!-- JS: Remove Wishlist -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cart-remove').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const wishlistId = this.dataset.wishlistId;
            const card = document.querySelector('.wishlist-card[data-wishlist-id="'+wishlistId+'"]');
            if (confirm('Remove this item from wishlist?')) {
                fetch('{{ route('wishlist.remove', ['id' => ':id']) }}'.replace(':id', wishlistId), {
                    method: 'DELETE',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        card.remove();
                        if (!document.querySelector('.wishlist-card')) {
                            location.reload();
                        }
                    } else { alert(data.message); }
                });
            }
        });
    });
});
</script>

<!-- Styles -->
<style>
/* Custom 5-column grid */
.col-lg-custom {
    flex: 0 0 20%;
    max-width: 20%;
}
@media (max-width: 1199px) {
    .col-lg-custom { flex: 0 0 25%; max-width: 25%; }
}
@media (max-width: 991px) {
    .col-lg-custom { flex: 0 0 33.3333%; max-width: 33.3333%; }
}
@media (max-width: 767px) {
    .col-lg-custom { flex: 0 0 50%; max-width: 50%; }
}
@media (max-width: 480px) {
    .col-lg-custom { flex: 0 0 100%; max-width: 100%; }
}

/* Card styling */
.trophy-card {
    border: 1px solid #f5f5f5;
    border-radius: 8px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background: white;
}
.trophy-card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.08);
}
.wishlist-img {
    height: 150px;
    width: 100%;
    object-fit: contain;
    padding: 10px;
    background: #fff;
}
/* Hidden by default */
.action-bar-overlay {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
    gap: 8px;
}

/* Show on hover */
.wishlist-card:hover .action-bar-overlay {
    opacity: 1;
    visibility: visible;
}

/* Icon buttons */
.icon-btn {
    border: none;
    background: #e63946; /* red */
    color: #fff;
    border-radius: 0%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: transform 0.2s;
}

.icon-btn:hover {
    transform: scale(1.1);
}

/* Add to Cart button */
.add-cart-btn {
    background: #ffcc00; /* yellow */
    color: #000;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: bold;
    text-decoration: none;
    transition: transform 0.2s;
}
.nice-select:after {
    content: none !important; /* Pseudo-element ka content remove ho jayega */
}


.add-cart-btn:hover {
    background: #ffdb4d;
    text-decoration: none;
    color: #000;
}
</style> 
@endsection
