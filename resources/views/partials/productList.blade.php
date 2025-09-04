<div class="row">
    @forelse($products as $prod)
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="{{ $prod->image_url }}" class="card-img-top" alt="{{ $prod->title }}">
                <div class="card-body">
                    <h5>{{ $prod->title ?? 'n/a' }}</h5>
                    <p>₹{{ $prod->variants->first()->discounted_price ?? ($prod->variants->first()->price ?? 'n/a') }}</p>
                </div>
            </div>
        </div>
    @empty
        <p>No products found in this range.</p>
    @endforelse
</div>
