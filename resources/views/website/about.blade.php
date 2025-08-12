@extends('website.layout.master')
@section('content')
    <!--====== Main Bg  ======-->
    <main class="main-bg" style="background-color: white;">

        <!--====== start About us Section ======-->

        <!-- About Us Section -->
        <section class="about-us-section py-5">
            <div class="container">
                <p class="text-center"
                    style="font-size: 36px; font-weight: 700; color: #e03c3c; font-family: 'Times New Roman', serif;">
                    About Us
                </p>

                <!-- List View -->
                <div id="aboutus-list-view">
                    <div class="row align-items-start">
                        <div class="col-md-7 pb-0 position-relative"
                            style="font-family: 'Source Sans 3', sans-serif; text-align: justify; top: 29px;">
                            <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}" alt="Decorative Bottom"
                                class="position-absolute bottom-0 start-0 trophy-bg d-none d-md-block"
                                style="z-index: 0; width: 200px; opacity: 17.8;top:97px">
                            <div style="position: relative; z-index: 1;">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>
                            </div>

                        </div>


                        <div class="col-md-5 pb-0">
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about1.png') }}"
                                        alt="Trophy Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Craftsmanship That Lasts</span>

                                    <button class="btn aboutus-arrow" data-id="1">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="height: 30px;">
                                    </button>
                                </div>
                            </div>
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about2.png') }}" alt="Gear Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Fully Custom, Fully You</span>

                                    <button class="btn aboutus-arrow" data-id="2">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="    height: 30px;">
                                    </button>
                                </div>
                            </div>
                            <div class="about-card d-flex align-items-center">
                                <div class="icon-box">
                                    <img src="{{ asset('website/assets/images/homePage/about3.png') }}"
                                        alt="Delivery Icon">
                                </div>
                                <div class="text-box d-flex justify-content-between align-items-center w-100">
                                    <span>Delivered With Confidence</span>

                                    <button class="btn aboutus-arrow" data-id="3">
                                        <img src="{{ asset('website/assets/images/homePage/arrow-fill.png') }}"
                                            alt="Back Arrow" class="aboutus-arrow" style="    height: 30px;">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail View -->
                <div id="aboutus-detail-view" class="p-4 bg-light d-none"
                    style="font-family: 'Times New Roman', Times, serif;">
                    <div class="d-flex justify-content-between align-items-start">
                        <strong id="aboutus-detail-title">Title</strong>
                        <button class="btn btn-sm rounded-circle bg-white text-dark border shadow"
                            onclick="aboutusBackToList()">&#8599;</button>
                    </div>
                    <p class="mt-2" id="aboutus-detail-desc"></p>
                </div>
                <!-- Section Templates (hidden) -->
                <div id="aboutus-sections" class="d-none">
                    <div id="aboutus-section-1" class="aboutus-section py-5">
                        <div class="container">
                            <div class="row align-items-start">
                                <!-- Left Column: Text Content -->
                                <div class="col-md-8 mb-4 mb-md-0"
                                    style="position: relative; z-index: 1; min-height: 250px;">
                                    <p>Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. </p>
                                    <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                        Ipsum passages, and more recently with desktop publishing software like Aldus
                                        PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the
                                        printing and typesetting industry. Contrary to popular belief, Lorem Ipsum is not
                                        simply random text. </p>
                                    <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. . </p>

                                    <!-- Trophy image BELOW the text -->
                                    <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                        alt="Decorative Bottom" class="position-absolute trophy-bg"
                                        style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                                </div>




                                <div class="col-md-4">
                                    <div class="custom-card-wrappers">

                                        <!-- Overlapping Circular Icon -->
                                        <div class="icon-boxs">
                                            <img src="{{ asset('website/assets/images/homePage/about1.png') }}"
                                                alt="Trophy Icon">
                                        </div>

                                        <div class="custom-cards">
                                            <!-- Back to List Button -->
                                            <button class="btn back-to-list-btn">
                                                <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                    alt="Back Arrow" class="back-to-list">
                                            </button>

                                            <h5 class="card-titles" style="font-family: 'Source Sans 3', sans-serif;">
                                                Craftsmanship That Lasts</h5>
                                            <h6 class="card-subtitles" style="font-family: 'Source Sans 3', sans-serif;">
                                                Celebrate success with quality that endures.</h6>
                                            <p class="card-texts"style="font-family: 'Source Sans 3', sans-serif;">
                                                At Trophy House, every trophy is a work of art — thoughtfully designed,
                                                precisely detailed, and expertly finished.
                                                We use only premium materials to ensure each piece not only looks
                                                exceptional but stands the test of time. Because a
                                                true achievement deserves more than a symbol — it deserves a lasting
                                                impression.
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div id="aboutus-section-2" class="aboutus-section">
                        <div class="row align-items-start">
                            <div
                                class="col-md-8 mb-4 mb-md-0"style="font-family: 'Source Sans 3', sans-serif;position: relative; z-index: 1; min-height: 250px;">
                                <p>Lorem Ipsum 2 is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>

                                <!-- Trophy image BELOW the text -->
                                <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                    alt="Decorative Bottom" class="position-absolute trophy-bg"
                                    style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                            </div>
                            <div class="col-md-4">

                                <div class="custom-card-wrappers">

                                    <!-- Overlapping Circular Icon -->
                                    <div class="icon-boxs">
                                        <img src="{{ asset('website/assets/images/homePage/about2.png') }}"
                                            alt="Trophy Icon">
                                    </div>

                                    <div class="custom-cards">
                                        <!-- Back to List Button -->
                                        <button class="btn back-to-list-btn">
                                            <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                alt="Back Arrow" class="back-to-list">
                                        </button>

                                        <h5 class="card-titles" style="font-family: 'Source Sans 3', sans-serif;">
                                            Craftsmanship That Lasts</h5>
                                        <h6 class="card-subtitles" style="font-family: 'Source Sans 3', sans-serif;">
                                            Celebrate success with quality that endures.</h6>
                                        <p class="card-texts" style="font-family: 'Source Sans 3', sans-serif;">
                                            At Trophy House, every trophy is a work of art — thoughtfully designed,
                                            precisely detailed, and expertly finished.
                                            We use only premium materials to ensure each piece not only looks exceptional
                                            but stands the test of time. Because a
                                            true achievement deserves more than a symbol — it deserves a lasting impression.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="aboutus-section-3" class="aboutus-section">
                        <div class="row align-items-start">
                            <div
                                class="col-md-8 mb-4 mb-md-0"style="font-family: 'Source Sans 3', sans-serif;position: relative; z-index: 1; min-height: 250px;">
                                <p>Lorem 3 Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. </p>
                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and
                                    typesetting industry. Contrary to popular belief, Lorem Ipsum is not simply random text.
                                </p>
                                <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                    has been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer took a galley of type and scrambled it to make a type specimen book. It has
                                    survived not only five centuries, but also the leap into electronic typesetting,
                                    remaining essentially unchanged. . </p>

                                <!-- Trophy image BELOW the text -->
                                <img src="{{ asset('website/assets/images/homePage/trophyy.png') }}"
                                    alt="Decorative Bottom" class="position-absolute trophy-bg"
                                    style="
                        z-index: 0;
                        width: 200px;
                        opacity: 17.08;
                        bottom: 0;
                        left: 0;
                        pointer-events: none;
                    ">
                            </div>
                            <div class="col-md-4">
                                <div class="custom-card-wrappers">

                                    <!-- Overlapping Circular Icon -->
                                    <div class="icon-boxs">
                                        <img src="{{ asset('website/assets/images/homePage/about3.png') }}"
                                            alt="Trophy Icon">
                                    </div>

                                    <div class="custom-cards">
                                        <!-- Back to List Button -->
                                        <button class="btn back-to-list-btn">
                                            <img src="{{ asset('website/assets/images/homePage/arrow.png') }}"
                                                alt="Back Arrow" class="back-to-list">
                                        </button>

                                        <h5 class="card-titles"style="font-family: 'Source Sans 3', sans-serif;">
                                            Craftsmanship That Lasts</h5>
                                        <h6 class="card-subtitles"style="font-family: 'Source Sans 3', sans-serif;">
                                            Celebrate success with quality that endures.</h6>
                                        <p class="card-texts"style="font-family: 'Source Sans 3', sans-serif;">
                                            At Trophy House, every trophy is a work of art — thoughtfully designed,
                                            precisely detailed, and expertly finished.
                                            We use only premium materials to ensure each piece not only looks exceptional
                                            but stands the test of time. Because a
                                            true achievement deserves more than a symbol — it deserves a lasting impression.
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Container -->
                <div id="aboutus-dynamic-content" class="mt-4"></div>
            </div>



        </section>


        <script>
            document.querySelectorAll('.aboutus-arrow').forEach(el => {
                el.addEventListener('click', function() {
                    const id = this.dataset.id;

                    // Hide the list view
                    document.getElementById('aboutus-list-view').classList.add('d-none');

                    // Clone and show the selected section
                    const section = document.getElementById('aboutus-section-' + id).cloneNode(true);
                    section.classList.remove('d-none');
                    section.classList.add('active');

                    const container = document.getElementById('aboutus-dynamic-content');
                    container.innerHTML = '';
                    container.appendChild(section);

                    // Add back button event
                    section.querySelector('.back-to-list').addEventListener('click', function() {
                        container.innerHTML = '';
                        document.getElementById('aboutus-list-view').classList.remove('d-none');
                    });
                });
            });
        </script>

        <style>
            .swiper {
                padding: 20px 88px;
            }

            .swiper-wrapper-container {
                overflow: hidden;
                width: 85%;
                max-width: 1200px;
                margin: 0 auto;
                position: relative;
            }

            .swiper {
                padding-left: 0;
                padding-right: 0;
            }

            .swiper-slide {
                display: flex;
                justify-content: center;
                align-items: stretch;
            }

            .testimonial-card {
                border: 2px solid #ffc107;
                padding: 20px 15px;
                background: white;
                position: relative;
                max-width: 400px;
                margin: auto;
                transition: all 0.3s ease-in-out;
                transform: scale(1);
            }

            .testimonial-card.active-center {
                background-color: #e63946;
                border: none;
                transform: scale(1.08);
                z-index: 2;
                padding: 30px 20px;
                transition: all 0.3s ease-in-out;
                margin-top: -11px;
            }

            /* .testimonial-card.active-center for this class i want to increses the height and width*/
            .testimonial-card.active-center .testimonial-quote-box {
                height: 200px;
                width: 100%;
                padding: 54px 14px 20px;
                bottom: 16px;
            }

            .testimonial-card.active-center .quote-img {
                filter: brightness(0) saturate(100%) invert(92%) sepia(13%) saturate(402%) hue-rotate(354deg) brightness(104%) contrast(100%);
            }

            .testimonial-img {
                position: absolute;
                top: -40px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 2;
            }

            .testimonial-img img {
                width: 91px;
                height: 91px;
                border: 5px solid white;
                position: relative;
                top: 58px;
            }

            .testimonial-quote-box {
                margin-top: 50px;
                padding: 40px 20px 20px;
                background-color: #ffc107;
                position: relative;
            }

            .quote-img-wrapper {
                position: absolute;
                top: -20px;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
            }

            .quote-img {
                width: 40px;
                height: 40px;
                position: absolute;
            }

            .start-quote {
                top: 6px;
                left: 64px;
            }

            .end-quote {
                top: 7px;
                right: 63px;
            }

            .swiper-button-prev,
            .swiper-button-next {
                color: #e63946;
            }

            .swiper-button-prev,
            .swiper-button-next {
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                width: 40px;
                height: 40px;
                color: transparent;
            }

            /* Custom left arrow image */
            .swiper-button-prev {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-left.png') }}');
            }

            /* Custom right arrow image */
            .swiper-button-next {
                background-image: url('{{ asset('website/assets/images/homePage/carousal-right.png') }}');
            }

            /* for background plate */
            .testimonials-section {
                position: relative;
                overflow: hidden;
            }

            .testimonials-bg-plate {
                position: absolute;
                bottom: -40px;
                left: 0;
                width: 100%;
                height: 50%;
                background-color: #FFF5DA;
                z-index: 0;
                overflow: hidden;
            }
        </style>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const swiper = new Swiper(".mySwiper", {
                    loop: true,
                    slidesPerView: 3,
                    centeredSlides: true,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    on: {
                        init: function() {
                            updateSlideClasses();
                        },
                        slideChangeTransitionEnd: function() {
                            updateSlideClasses();
                        }
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                            centeredSlides: true,
                        },
                        768: {
                            slidesPerView: 3,
                            centeredSlides: true,
                        }
                    }
                });

                function updateSlideClasses() {
                    document.querySelectorAll('.swiper-slide').forEach(slide => {
                        slide.querySelector('.testimonial-card')?.classList.remove('active-center');
                    });

                    const activeSlide = document.querySelector('.swiper-slide-active');
                    activeSlide?.querySelector('.testimonial-card')?.classList.add('active-center');
                }
            });
        </script>



    </main>
@endsection
