  <footer class="footer-main text-black"
      style="background: linear-gradient(90deg, #fff7dc, #FFDE57); font-family: 'Source Sans 3', sans-serif;">

      <div class="container py-5"style="font-family: 'Source Sans 3', sans-serif;">
          <div class="row d-flex justify-content-between gy-4">
              <!-- Logo & Tagline -->
              <div class="col-lg-2 col-md-6 col-sm-12">
                  <img src="{{ asset('website/assets/images/TH-Logo.png') }}" alt="Trophy House" style="width: 150px;">
                  <p class="mt-3 mb-1">Celebrate the moment, cherish the memory.<br>Trophy House is where victories live
                      on.</p>
                  <p><strong>From Our Hands to Your Victory</strong></p>
                  <div class="d-flex gap-3 mt-3">
                      <a href="#"><img src="{{ asset('website/assets/images/footer/Group71.png') }}"
                              width="30" class="rounded-circle shadow"></a>
                      <a href="#"><img src="{{ asset('website/assets/images/footer/Group72.png') }}"
                              width="30" class="rounded-circle shadow"></a>
                      <a href="#"><img src="{{ asset('website/assets/images/footer/Group79.png') }}"
                              width="30" class="rounded-circle shadow"></a>
                  </div>
              </div>

              <!-- Direct Links -->
              <div class="col-lg-2 col-md-6 col-sm-12">
                  <h5 class="fw-bold position-relative pb-2">Direct Links
                      <span class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-danger"></span>
                  </h5>
                  <ul class=" main-menu list-unstyled mt-3">
                      <li class="mb-2"><i class="fas fa-caret-right me-2"></i><a href="{{ route('Websitehome') }}"
                              class="text-black text-decoration-none">HOME</a></li>
                      <li class="mb-2"><i class="fas fa-caret-right me-2"></i><a href="{{ route('about.us') }}"
                              class="text-black text-decoration-none">ABOUT US</a></li>
                      <li class="mb-2"><i class="fas fa-caret-right me-2"></i><a href="{{ route('viewproducts') }}"
                              class="text-black text-decoration-none">PRODUCTS</a></li>
                      <li class="mb-2"><i class="fas fa-caret-right me-2"></i><a href="{{ route('contact') }}"
                              class="text-black text-decoration-none">CONTACT US</a></li>


                      {{-- <li>
                          <select class="">
                              <i class="fas fa-caret-right me-2"></i>
                              <option value="">Pages</option>
                              @foreach ($pages as $page)
                                  <option class="text-black text-decoration-none"
                                      href="{{ route('pageDetail', $page->id) }}">{{ $page->title }}</option>
                              @endforeach
                          </select>

                      </li> --}}

                  </ul>

              </div>
         

              <!-- Address -->
              <div class="col-lg-2 col-md-6 col-sm-12">
                  <h5 class="fw-bold position-relative pb-2">Address
                      <span class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-danger"></span>
                  </h5>
                  <ul class="list-unstyled mt-3">
                      <li class="mb-3 d-flex align-items-start">
                          <i class="fas fa-map-marker-alt me-2 mt-1"></i>
                          <span class="text-black">Space cosmos, old Mumbai Agra Road, Beside Canara Bank, opp. Meher Bus Stop, Ashok Stambh, Nashik 422002</span>
                      </li>
                      <li class="mb-3 d-flex align-items-start">
                          <i class="fas fa-envelope me-2 mt-1"></i>
                          <a href="mailto:Trophyhouse@gmail.com" class="text-black text-decoration-none">trophyhousensk1@gmail.com </a>
                      </li>
                      <li class="d-flex align-items-start">
                          <i class="fas fa-phone me-2 mt-1"></i>
                          <span class="text-black">9423962242, 9423962042, 9404076742</span>
                      </li>
                  </ul>
              </div>

                   {{-- pages --}}
              <div class="col-lg-3 col-md-6 col-sm-12">
                  <h5 class="fw-bold position-relative pb-2">Pages
                      <span class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-danger"></span>
                  </h5>
                  <ul>
                      @foreach ($pages as $page)
                          <li class="mb-2 mt-3">
                              <a href="{{ route('pageDetail', $page->id) }}"
                                  class="text-black text-decoration-none"><i class="fas fa-caret-right me-2"></i>{{ strtoupper($page->title) }}</a>
                          </li>
                      @endforeach
                  </ul>
              </div>

              <!-- Contact Form -->
              <div class="col-lg-2 col-md-6 col-sm-12">
                  <h5 class="fw-bold position-relative pb-2">Get In Touch
                      <span class="position-absolute bottom-0 start-0 w-25 border-bottom border-2 border-danger"></span>
                  </h5>
                  <p class="mt-3 mb-2 text-black">We are here for you, How can we help?</p>
                  <form action="{{ route('contact.store') }}" method="POST">
                      @csrf
                      <div class="row gx-2">
                          <div class="col-12 col-md-6 mb-2">
                              <input type="text" name="name" class="form-control form-control-sm"
                                  placeholder="Name" style="background: transparent; border: 1px solid red;" required>
                          </div>
                          <div class="col-12 col-md-6 mb-2">
                              <input type="email" name="email" class="form-control form-control-sm"
                                  placeholder="Email ID" style="background: transparent; border: 1px solid red;"
                                  required>
                          </div>
                      </div>
                      <div class="mb-2">
                          <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Write a Message"
                              style="background: transparent; border: 1px solid red;" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-outline-danger btn-sm btn-danger px-4 rounded-pill"
                          style="color:white">Send</button>
                  </form>
              </div>
          </div>
      </div>
  </footer>




  <!--====== Back To Top  ======-->
  {{-- <div class="back-to-top" ><i class="far fa-angle-up"></i></div> --}}
  <!--====== Jquery js ======-->
  <script src="{{ asset('website/assets/vendor/jquery-3.7.1.min.js') }}"></script>
  <!--====== Bootstrap js ======-->
  <script src="{{ asset('website/assets/vendor/popper/popper.min.js') }}"></script>
  <!--====== Bootstrap js ======-->
  <script src="{{ asset('website/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <!--====== Slick js ======-->
  <script src="{{ asset('website/assets/vendor/slick/slick.min.js') }}"></script>
  <!--====== Magnific js ======-->
  <script src="{{ asset('website/assets/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
  <!--====== Nice-select js ======-->
  <script src="{{ asset('website/assets/vendor/nice-select/js/jquery.nice-select.min.js') }}"></script>
  <!--====== Jquery Ui js ======-->
  <script src="{{ asset('website/assets/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
  <!--====== SimplyCountdown js ======-->
  <script src="{{ asset('website/assets/vendor/simplyCountdown.min.js') }}"></script>
  <!--====== Aos js ======-->
  <script src="{{ asset('website/assets/vendor/aos/aos.js') }}"></script>
  <!--====== Main js ======-->
  <script src="{{ asset('website/assets/js/theme.js') }}"></script>
  
  <script>
      window.addEventListener('load', function() {
          const preloader = document.getElementById('preloader');
          preloader.style.display = 'none';
      });
  </script>
  <script>
      $(document).ready(function() {
          setTimeout(function() {
              $("#successMessage, #failMessage").fadeOut('slow');
          }, 2000);
      });
  </script>
  <script>
    // Force page reload on back/forward cache navigation
    window.addEventListener("pageshow", function (event) {
        if (event.persisted || (window.performance && performance.navigation.type === 2)) {
            window.location.reload();
        }
    });
</script>
  </body>

  </html>
