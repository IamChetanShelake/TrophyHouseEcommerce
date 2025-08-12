@extends('website.layout.master')
@section('content')

<style>
  .gallery-section {
    padding: 40px 0;
    background: #fff7f0;
    font-family: 'Source Sans 3', sans-serif;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .gallery-title {
    text-align: center;
    font-size: 36px;
    font-weight: 700;
    color: #d32f2f;
    margin-bottom: 20px;
  }

  .gallery-container {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    margin: 0 auto;
    max-width: 1200px; /* Controls overall width with vacant side space */
    padding: 0 20px; /* Adds vacant space on sides */
  }

  .gallery-left {
    flex: 0 0 25%;
    max-width: 25%;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .gallery-right {
    flex: 0 0 75%;
    max-width: 75%;
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two columns */
    gap: 20px; /* Equal gap between images */
    align-items: flex-end;
    position: absolute;
    right: 100px;

  }

  .gallery-item {
    /* position: relative;
    overflow: hidden;
    border-radius: 12px;
    border: 3px solid #ffd54f;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease; */
  }

  .gallery-item.large {
       height: 470px;
    width: 492px;
  }

  .gallery-item.small {
    flex: 1;
    height: 235px; /* Matches the smaller image height in the screenshot */
  }

  .gallery-item:hover {
    transform: scale(1.03);
    box-shadow: 0 5px 10px rgba(255, 152, 0, 0.3);
  }

  .gallery-item img {
    width: 100%;
    height: 492px;
    max-width: 1200px;
    object-fit: cover;
    display: block;
  }

  .gallery-item a {
    display: block;
    width: 100%;
    height: 100%;
  }

  .gallery-caption {
    position: absolute;
    bottom: 5px;
    left: 5px;
    color: #fff;
    background: rgba(0, 0, 0, 0.6);
    padding: 3px 6px;
    border-radius: 3px;
    font-size: 12px;
  }

  @media (max-width: 1024px) {
    .gallery-title {
      font-size: 32px;
    }
    .gallery-container {
      max-width: 900px;
      gap: 15px;
      padding: 0 15px;
    }
    .gallery-item.large {
      height: 300px;
    }
    .gallery-item.small {
      height: 300px;
    }
  }

  @media (max-width: 768px) {
    .gallery-title {
      font-size: 24px;
    }
    .gallery-container {
      flex-direction: column;
      align-items: center;
      max-width: 600px;
      padding: 0 10px;
    }
    .gallery-left {
      flex: 0 0 100%;
      max-width: 100%;
      flex-direction: column;
      align-items: center;
    }
    .gallery-right {
      flex: 0 0 100%;
      max-width: 100%;
      grid-template-columns: 1fr; /* Single column on mobile */
      gap: 10px;
    }
    .gallery-item.large {
      height: 250px;
    }
    .gallery-item.small {
      height: 250px;
    }
  }

  @media (max-width: 480px) {
    .gallery-title {
      font-size: 20px;
    }
    .gallery-container {
      max-width: 350px;
      padding: 0 5px;
    }
    .gallery-left {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .gallery-right {
      gap: 5px;
    }
    .gallery-item.large {
      height: 200px;
    }
    .gallery-item.small {
      height: 120px;
    }
  }
</style>

<section class="gallery-section">
  <div class="container">
    {{-- <h3 class="gallery-title" style="color: #e63946; font-family: 'Times New Roman', serif; font-weight: bold;">Photo Gallery</h3> --}}
    <div class="gallery-container">
      <div class="gallery-left">
        <div class="gallery-text">
          <h4 class="text-danger fw-bold">“From Our Gallery”</h4>
          <p class="text-muted">"Icons, Achievements & Unforgettable Memories"</p>
        </div>
        <div class="gallery-item large">
          <a href="{{ asset('gallery_images/' . $galleries[0]->image) }}" target="_blank">
            <img src="{{ $galleries[0]->image ? asset('gallery_images/' . $galleries[0]->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $galleries[0]->title }}" title="{{ $galleries[0]->title }}">
            <div class="gallery-caption">{{ $galleries[0]->title }}</div>
          </a>
        </div>
      </div>
      <div class="gallery-right">
         @foreach($galleries->slice(1)->chunk(2) as $chunk)
            <div>
                @foreach($chunk as $gallery)
                    <div class="gallery-item small">
                        <a href="{{ asset('gallery_images/' . $gallery->image) }}" target="_blank">
                            <img src="{{ asset('gallery_images/' . $gallery->image) }}"
                                 alt="{{ $gallery->title }}"
                                 title="{{ $gallery->title }}"
                                 style="height: 220px; width: 100%; object-fit: cover;">
                            <div class="gallery-caption">{{ $gallery->title }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
        {{-- <div>
          <div class="gallery-item small">
            <a href="{{ asset('gallery_images/' . $galleries[1]->image) }}" target="_blank">
              <img src="{{ $galleries[1]->image ? asset('gallery_images/' . $galleries[1]->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $galleries[1]->title }}" title="{{ $galleries[1]->title }}" style="height: 248px; width: 232px;">
              <div class="gallery-caption">{{ $galleries[1]->title }}</div>
            </a>
          </div>
          <div class="gallery-item small">
            <a href="{{ asset('gallery_images/' . $galleries[2]->image) }}" target="_blank">
              <img src="{{ $galleries[2]->image ? asset('gallery_images/' . $galleries[2]->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $galleries[2]->title }}" title="{{ $galleries[2]->title }}" style="height: 204px;margin-top: 63px;">
              <div class="gallery-caption">{{ $galleries[2]->title }}</div>
            </a>
          </div>
        </div>
        <div>
          <div class="gallery-item small">
            <a href="{{ asset('gallery_images/' . $galleries[3]->image) }}" target="_blank">
              <img src="{{ $galleries[3]->image ? asset('gallery_images/' . $galleries[3]->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $galleries[3]->title }}" title="{{ $galleries[3]->title }}">
              <div class="gallery-caption">{{ $galleries[3]->title }}</div>
            </a>
          </div>
          <div class="gallery-item small">
            <a href="{{ asset('gallery_images/' . $galleries[4]->image) }}" target="_blank">
              <img src="{{ $galleries[4]->image ? asset('gallery_images/' . $galleries[4]->image) : asset('website/assets/images/default_trophy.png') }}" alt="{{ $galleries[4]->title }}" title="{{ $galleries[4]->title }}">
              <div class="gallery-caption">{{ $galleries[4]->title }}</div>
            </a>
          </div>
        </div>
         --}}
      </div>
    </div>
  </div>
</section>

@endsection