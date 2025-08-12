@extends('website.layout.master')
@section('content')

<style>
  .gallery-section {
    padding: 60px 0;
    background: #fff7f0;
    font-family: 'Source Sans 3', sans-serif;
  }

  .gallery-title {
    text-align: center;
    font-size: 36px;
    font-weight: 700;
    color: #d32f2f;
    margin-bottom: 40px;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 15px;
  }

  .gallery-grid-item {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    border: 3px solid #ffd54f;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
  }

  .gallery-grid-item:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 20px rgba(255, 152, 0, 0.3);
  }

  .gallery-grid-item img {
    width: 100%;
    display: block;
  }

  .gallery-grid-item a {
    display: block;
    width: 100%;
  }

  /* Optional: Random row spans for masonry feel */
  .tall {
    grid-row: span 2;
  }

  .wide {
    grid-column: span 2;
  }

  @media (max-width: 768px) {
    .gallery-title {
      font-size: 28px;
    }
    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    }
  }
</style>

<section class="gallery-section">
  <div class="container">
    <h3 class="text-center mb-5" style="color: #e63946; font-family: 'Times New Roman', serif; font-weight: bold;">Photo Gallery</h3>

    <div class="gallery-grid" >
      @foreach ($galleries as $index => $gallery)
        <div class="gallery-grid-item {{ ($index % 7 == 1 || $index % 7 == 4) ? 'tall' : (($index % 7 == 2 || $index % 7 == 6) ? 'wide' : '') }}">
          <a href="{{ asset('gallery_images/' . $gallery->image) }}" target="_blank">
            <img src="{{ $gallery->image ? asset('gallery_images/' . $gallery->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $gallery->title }}" title="{{ $gallery->title }}">
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
