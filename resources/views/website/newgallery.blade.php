@section('title', 'Trophy House - Gallery')
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

        .gallery-item {
            position: relative;
        }

        .gallery-item a {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* Hover Overlay Effects */
        .gallery-hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 20px;
            text-align: center;
            z-index: 10;
        }

        .gallery-item:hover .gallery-hover-overlay {
            opacity: 1;
        }

        /* Specific positioning for images with margins */
        .gallery-item.small:nth-child(1) .gallery-hover-overlay {
            left: 177px;
            width: 286px;
            height: 338px;
        }

        .gallery-item.small:nth-child(2) .gallery-hover-overlay {
            left: 179px;
            top: 28px;
            width: 396px;
            height: 318px;
        }

        .gallery-item.small:nth-child(3) .gallery-hover-overlay {
            left: 34px;
            width: 385px;
            height: 336px;
        }

        .gallery-item.small:nth-child(4) .gallery-hover-overlay {
            left: 141px;
            top: 28px;
            width: 274px;
            height: 318px;
        }

        .gallery-additional .gallery-item .gallery-hover-overlay {
            left: 140px;
        }

        /* More specific selectors for nested structure */
        .gallery-right>div:nth-child(1)>.gallery-item:nth-child(1) .gallery-hover-overlay {
            left: 177px !important;
            width: 286px !important;
            height: 338px !important;
        }

        .gallery-right>div:nth-child(1)>.gallery-item:nth-child(2) .gallery-hover-overlay {
            left: 179px !important;
            top: 28px !important;
            width: 396px !important;
            height: 318px !important;
        }

        .gallery-right>div:nth-child(2)>.gallery-item:nth-child(1) .gallery-hover-overlay {
            left: 34px !important;
            width: 385px !important;
            height: 336px !important;
        }

        .gallery-right>div:nth-child(2)>.gallery-item:nth-child(2) .gallery-hover-overlay {
            left: 141px !important;
            top: 28px !important;
            width: 274px !important;
            height: 318px !important;
        }

        .gallery-hover-title {
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
        }

        .gallery-hover-description {
            color: white;
            font-size: 16px;
            font-weight: 400;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.9);
            line-height: 1.5;
            max-width: 90%;
            word-wrap: break-word;
            max-height: 120px;
            overflow: hidden;
            padding-right: 5px;
            position: relative;
        }

        /* Auto-scrolling animation for long descriptions */
        .gallery-hover-description.long-text {
            animation: autoScroll 8s linear infinite;
        }

        @keyframes autoScroll {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        /* Pause animation on hover */
        .gallery-hover-description.long-text:hover {
            animation-play-state: paused;
        }

        /* Custom scrollbar for description */
        .gallery-hover-description::-webkit-scrollbar {
            width: 4px;
        }

        .gallery-hover-description::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .gallery-hover-description::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
        }

        .gallery-hover-description:empty {
            display: none;
        }

        /* Responsive adjustments for hover overlay */
        @media (max-width: 768px) {
            .gallery-hover-overlay {
                padding: 15px;
            }

            .gallery-hover-title {
                font-size: 16px;
                margin-bottom: 6px;
            }

            .gallery-hover-description {
                font-size: 12px;
                max-height: 80px;
            }
        }

        @media (max-width: 480px) {
            .gallery-hover-overlay {
                padding: 10px;
            }

            .gallery-hover-title {
                font-size: 14px;
                margin-bottom: 4px;
            }

            .gallery-hover-description {
                font-size: 11px;
                max-height: 60px;
            }
        }

        .gallery-additional {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .gallery-additional .gallery-item {
            height: 318px;
            width: 283px;
        }

        /* Large screens (up to 1200px) */

        @media (max-width: 1024px) {
            .gallery-title {
                font-size: 32px;
            }

            .gallery-container {
                max-width: 900px;
                gap: 15px;
                padding: 0 15px;
            }

            .gallery-item.large,
            .gallery-item.small {
                height: auto;
            }
        }

        @media (max-width: 768px) {
            .gallery-container {
                flex-direction: column;
                align-items: center;
            }

            .gallery-left,
            .gallery-right {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .gallery-right {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .gallery-item.large,
            .gallery-item.small {
                width: 100% !important;
                height: auto !important;
            }

            .gallery-item img {
                width: 100% !important;
                height: auto !important;
                object-fit: contain;
            }

            .gallery-additional {
                justify-content: center;
            }

            .gallery-additional .gallery-item {
                width: 100% !important;
                height: auto !important;
            }

            img {
                max-width: 100% !important;
            }

            .header-navigation.style-one {
                padding: 10px 0;
                width: 100% !important;
            }

            :root {
                --swiper-navigation-size: 40px;
                width: 100% !important;
            }
        }

        @media (max-width: 480px) {
            .gallery-title {
                font-size: 20px;
            }

            .gallery-container {
                max-width: 100%;
                padding: 0 10px;
            }

            .gallery-item img {
                padding: 4px !important;
                margin: 0 !important;
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
                            <div class="gallery-hover-overlay">
                                <div class="gallery-hover-title">{{ $galleries[0]->title }}</div>
                                <div class="gallery-hover-description long-text">
                                    {{ $galleries[0]->description ?? 'No description available' }}</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="gallery-right">
                    <div>
                        <div class="gallery-item small">
                            <img src="{{ $galleries[1]->image ? asset('gallery_images/' . $galleries[1]->image) : asset('website/assets/images/default_trophy.png') }}"
                                alt="{{ $galleries[1]->title }}" title="{{ $galleries[1]->title }}"
                                style="width: 286px; height: 338px; margin-left: 177px;">
                            <div class="gallery-hover-overlay">
                                <div class="gallery-hover-title">{{ $galleries[1]->title }}</div>
                                <div class="gallery-hover-description long-text">
                                    {{ $galleries[1]->description ?? 'No description available' }}</div>
                            </div>
                        </div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[2]->image) }}" target="_blank">
                                <img src="{{ $galleries[2]->image ? asset('gallery_images/' . $galleries[2]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[2]->title }}" title="{{ $galleries[2]->title }}"
                                    style="width: 396px; height: 318px; margin-left: 179px; padding-top: 28px;">
                                <div class="gallery-hover-overlay">
                                    <div class="gallery-hover-title">{{ $galleries[2]->title }}</div>
                                    <div class="gallery-hover-description long-text">
                                        {{ $galleries[2]->description ?? 'No description available' }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[3]->image) }}" target="_blank">
                                <img src="{{ $galleries[3]->image ? asset('gallery_images/' . $galleries[3]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[3]->title }}" title="{{ $galleries[3]->title }}"
                                    style="width: 385px; height: 336px; margin-left: 34px;">
                                <div class="gallery-hover-overlay">
                                    <div class="gallery-hover-title">{{ $galleries[3]->title }}</div>
                                    <div class="gallery-hover-description long-text">
                                        {{ $galleries[3]->description ?? 'No description available' }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="gallery-item small">
                            <a href="{{ asset('gallery_images/' . $galleries[4]->image) }}" target="_blank">
                                <img src="{{ $galleries[4]->image ? asset('gallery_images/' . $galleries[4]->image) : asset('website/assets/images/default_trophy.png') }}"
                                    alt="{{ $galleries[4]->title }}" title="{{ $galleries[4]->title }}"
                                    style="width: 274px; height: 318px; margin-left: 141px; padding-top: 28px;">
                                <div class="gallery-hover-overlay">
                                    <div class="gallery-hover-title">{{ $galleries[4]->title }}</div>
                                    <div class="gallery-hover-description long-text">
                                        {{ $galleries[4]->description ?? 'No description available' }}</div>
                                </div>
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
                                    <div class="gallery-hover-overlay">
                                        <div class="gallery-hover-title">{{ $gallery->title }}</div>
                                        <div class="gallery-hover-description long-text">
                                            {{ $gallery->description ?? 'No description available' }}</div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection
