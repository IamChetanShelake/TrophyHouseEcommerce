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

        img {
            max-width: 200% !important;
        }

        .gallery-title {
            /* text-align: center;
        font-size: 36px;
        font-weight: 700;
        color: #d32f2f;
        margin-bottom: 20px; */
        }

        .gallery-container {
            display: flex;
            align-items: flex-end;
            gap: 20px;
            margin: 0 auto;
            max-width: 1200px;
            padding: 0 20px;
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
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            align-items: flex-end;
        }

        .gallery-item.large {
            flex: 1;
            height: 492px;
            width: 470px;
        }

        .gallery-item.small {
            flex: 1;
            height: 318px;
            width: 283px;
        }

        .gallery-item:hover {
            /* transform: scale(1.03);
        box-shadow: 0 5px 10px rgba(255, 152, 0, 0.3); */
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-item a {
            width: 100%;
            height: 100%;
        }

        .gallery-additional {
            display: flex;
            flex-wrap: wrap;
            gap:20px;
            margin-top: 20px;
        }

        .gallery-additional .gallery-item {
            height: 318px;
            width: 283px;
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
                height: 400px;
                width: 380px;
            }

            .gallery-item.small {
                height: 250px;
                width: 230px;
            }

            .gallery-additional .gallery-item {
                height: 250px;
                width: 230px;
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
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .gallery-item.large {
                height: 350px;
                width: 330px;
            }

            .gallery-item.small {
                height: 200px;
                width: 180px;
            }

            .gallery-additional {
                grid-template-columns: 1fr;
            }

            .gallery-additional .gallery-item {
                height: 200px;
                width: 180px;
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
                height: 250px;
                width: 230px;
            }

            .gallery-item.small {
                height: 150px;
                width: 130px;
            }

            .gallery-additional {
                grid-template-columns: 1fr;
            }

            .gallery-additional .gallery-item {
                height: 150px;
                width: 130px;
            }

        }
    </style>

    <section class="gallery-section">
        <div class="container">
            <div class="gallery-container">
                <div class="gallery-left">
                    <div class="gallery-text">
                        <h4 class="text-danger fw-bold">“From Our Gallery”</h4>
                        <p class="text-muted">"Icons, Achievements & Unforgettable Memories"</p>
                    </div>
                    <div class="gallery-item large">
                        <a href="{{ asset('gallery_images/' . $galleries[0]->image) }}" target="_blank">
                            <img src="{{ $galleries[0]->image ? asset('gallery_images/' . $galleries[0]->image) : asset('website/assets/images/default_trophy.png') }}"
                                alt="{{ $galleries[0]->title }}" title="{{ $galleries[0]->title }}"
                                style="width: 470px; height: 492px;">
                            <div class="gallery-caption">{{ $galleries[0]->title }}</div>
                        </a>
                    </div>
                </div>
                <div class="gallery-right">
                    <div>
                        <div class="gallery-item small">
                            <img src="{{ $galleries[1]->image ? asset('gallery_images/' . $galleries[1]->image) : asset('website/assets/images/default_trophy.png') }}"
                                alt="{{ $galleries[1]->title }}" title="{{ $galleries[1]->title }}"
                                style="width: 286px; height: 338px; margin-left: 177px;">
                        </div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[2]->image) }}" target="_blank">
                                <img src="{{ $galleries[2]->image ? asset('gallery_images/' . $galleries[2]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[2]->title }}" title="{{ $galleries[2]->title }}"
                                    style="width: 396px; height: 318px; margin-left: 179px; padding-top: 28px;">
                                <div class="">{{ $galleries[2]->title }}</div>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[3]->image) }}" target="_blank">
                                <img src="{{ $galleries[3]->image ? asset('gallery_images/' . $galleries[3]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[3]->title }}" title="{{ $galleries[3]->title }}"
                                    style="width: 385px; height: 336px; margin-left: 34px;">
                                <div class="">{{ $galleries[3]->title }}</div>
                            </a>
                        </div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[4]->image) }}" target="_blank">
                                <img src="{{ $galleries[4]->image ? asset('gallery_images/' . $galleries[4]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[4]->title }}" title="{{ $galleries[4]->title }}"
                                    style="width: 274px; height: 318px; margin-left: 141px; padding-top: 28px;">
                                <div class="">{{ $galleries[4]->title }}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dynamic section for additional images -->
            @if (count($galleries) > 5)
                <div class="gallery-additional">
                    @foreach ($galleries as $index => $gallery)
                        @if ($index >= 5)
                            <div class="gallery-item">
                                <a href="{{ asset('gallery_images/' . $gallery->image) }}" target="_blank">
                                    <img src="{{ $gallery->image ? asset('gallery_images/' . $gallery->image) : asset('website/assets/images/default_trophy.png') }}"
                                        alt="{{ $gallery->title }}" title="{{ $gallery->title }}"
                                        style="margin-left: 140px;">
                                    <div class="">{{ $gallery->title }}</div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection
