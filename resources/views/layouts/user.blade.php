<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
      integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- owl's stylesheet -->
    <link rel="stylesheet" href="{{asset('home_asset/css/owl/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('home_asset/css/owl/owl.theme.default.css')}}">

    <!-- main stylesheet -->
    <link rel="stylesheet" href="{{asset('home_asset/css/style.css')}}">

    @livewireStyles

    <!-- title -->
    <title>QuickCart || Details</title>
  </head>

  <body>
    <!-- header -->
    <header id="header">
      <div class="container">
        <div class="flex justify-content-between align-items-center position-relative">
          <!-- logo -->
          <div>
            <a class="logo" href="#!">
              <img src="{{asset('home_asset/img/logo.svg')}}" alt="">
              <span>QuickCart</span>
            </a>
          </div>

          <!-- search -->
          <div class="search-bar-wrap d-none d-md-block">
            @livewire('ProductSearchComponent')
          </div>

          <!-- cta buttons -->
          <div class="flex align-items-center gap-3">
            <a href="#!" class="cart-btn">
              <i class="fas fa-cart-plus"> </i>
            </a>

            <a href="#!" class="btn-sm d-none d-sm-inline">
              Sign In
            </a>
          </div>

          <!-- cart -->
          <div class="cart-wrap">
            <h6 class="cart-title">Cart</h6>

            <!-- cart item -->
            @livewire('CartComponent')
            
          </div>
        </div>
      </div>
    </header>

    <!-- navbar -->
    <nav class="navbar">
      <div class="container">
        <ul class="navlinks">
          <li>
            <a href="#!">Trending</a>
          </li>
          <li class="position-relative">
            <!-- dropdown toggler -->
            <a class="dropdown-btn" href="#!">
              <span>Categories</span>
              <i class="fa-solid fa-angle-down"></i>
            </a>

            <!-- dropdown links (driven from real categories) -->
            @php
              $navCategories = \App\Models\Category::all();
            @endphp
            <ul class="dropdown-links">
              @foreach ($navCategories as $category)
                <li>
                  <a href="{{ route('home', ['category' => $category->id]) }}">
                    {{ $category->category_name }}
                  </a>
                </li>
              @endforeach
            </ul>
          </li>

          <li>
            <a href="#!">Discounts</a>
          </li>
          <li>
            <a href="#!">Gift Collections</a>
          </li>
          <li>
            <a href="#!">Stores</a>
          </li>
        </ul>

        <!-- mobile search bar -->
        <div class="search-bar-wrap d-block d-md-none">
          <form action="" method="">
            <div class="search-bar">
              <input type="text" name="query" placeholder="Search Product..." required>
              <div class="search-icon">
                <i class="fas fa-search"></i>
              </div>
            </div>
          </form>
        </div>

        <!-- nav toggler -->
        <div class="nav-toggler d-block d-md-none">
          <a href="#!">
            <i class="fas fa-bars"></i>
          </a>
        </div>
      </div>
    </nav>

    <!-- main contents -->
    <main>
        @yield('home')


        <!-- flash sale -->
        @livewire('FlashSellCountdownComponent')

    </main>

    <!-- footer -->
    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <a class="logo" href="#!">
              <img src="{{asset('home_asset/img/logo.svg')}}" alt="">
              <span>QuickCart</span>
            </a>

            <p class="mt-3">Where brands meets happiness. Customer smile is our first priority.</p>
          </div>

          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <ul class="footer-links">
              <li>
                <p class="title">About Us</p>
              </li>
              <li>
                <a href="#!">About QuickCart</a>
              </li>
              <li>
                <a href="#!">Career</a>
              </li>
              <li>
                <a href="#!">Sponsors</a>
              </li>
              <li>
                <a href="#!">Campaigns</a>
              </li>
            </ul>
          </div>

          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <ul class="footer-links">
              <li>
                <p class="title">Stores</p>
              </li>
              <li>
                <a href="#!">Nick's Tshirt</a>
              </li>
              <li>
                <a href="#!">Vlads Sports</a>
              </li>
              <li>
                <a href="#!">IQ 360</a>
              </li>
              <li>
                <a href="#!">Decor Plus+</a>
              </li>
            </ul>
          </div>

          <div class="col-md-6 col-lg-3">
            <ul class="footer-links">
              <li>
                <p class="title">Important</p>
              </li>
              <li>
                <a href="#!">Privacy</a>
              </li>
              <li>
                <a href="#!">Cookie Policy</a>
              </li>
              <li>
                <a href="#!">Terms & Conditions</a>
              </li>
              <li>
                <a href="#!">Refund Policy</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- javaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>

    <!-- owl carousel -->
    <script src="{{asset('home_asset/js/jquery.min.js')}}"></script>
    <script src="{{asset('home_asset/js/owl.carousel.min.js')}}"></script>

    <!-- main js -->
    <script src="{{asset('home_asset/js/app.js')}}"></script>
    @livewireScripts

    <!-- owl carousel init -->
    <script>
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        autoplay: true,
        responsive: {
          0: {
            items: 1
          }
        }
      })
    </script>
  </body>

</html>