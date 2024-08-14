<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete responsive hotel agency website design</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- custome css file link -->
    <link rel="stylesheet" href="{{ asset('new/style.css') }}">

    {{-- Footer CSS --}}
    <link rel="stylesheet" href="{{ asset('new/stylefooter.css') }}">

    {{-- Card Detail --}}
    <link rel="stylesheet" href="{{ asset('new/card/style1.css') }}">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- Toastr CSS --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    {{-- Comment CSS --}}
    <!-- Styles -->
    <link href="{{ asset('new/comment/css/app.css') }}" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- 引入ScrollReveal库 -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="path/to/scrollreveal.css">
    <link rel="stylesheet" href="path/to/swiper.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- Nav CSS --}}
    <style>
        .navbar a {
            color: black;
            /* 默认颜色 */
            text-decoration: none;
        }

        .navbar a.active {
            color: orange;
            /* 当前页面的颜色 */
        }
    </style>

</head>

<body>

    <!-- header section starts -->
    <header>

        <div id="menu-bar" class="fas fa-bars"></div>

        <a href="{{ url('/') }}" class="logo"><span>SUC Travel Website</span></a>

        <nav class="navbar">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/allResort') }}" class="{{ request()->is('allResort*') ? 'active' : '' }}">Resort</a>
            <a href="{{ url('/allHotel') }}" class="{{ request()->is('allHotel*') ? 'active' : '' }}">Hotel</a>
            <a href="{{ url('/allRestaurant') }}"
                class="{{ request()->is('allRestaurant*') ? 'active' : '' }}">Restaurant</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact us</a>
            <a href="{{ url('/comment') }}" class="{{ request()->is('comment') ? 'active' : '' }}">Comment us</a>

            @auth
                @php
                    $id = Auth::user()->id;
                @endphp
                <a href="{{ url('/users/dashboard/' . $id) }}"
                    class="{{ request()->is('users/dashboard/' . $id) ? 'active' : '' }}">My Dashboard</a>
                <a class="btn" href="{{ url('/logout') }}">Logout</a>
            @endauth

            @guest
                <a class="btn" href="{{ url('/login') }}"><i class="fas fa-user" id="login-btn"></i>Login</a>
            @endguest
        </nav>

        {{-- <div class="icons">
            <i class="fas fa-search" id="search-btn"></i>
            <i class="fas fa-user" id="login-btn"></i>
        </div>

        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form> --}}

    </header>
    <!-- header section ends -->

    <!-- login form container -->
    <div class="login-form-container">
        <i class="fas fa-times" id="form-close"></i>
        <form action="">
            <h3>Login</h3>
            <input type="email" class="box" placeholder="Enter Your Email">
            <input type="password" class="box" placeholder="Enter Your Password">
            <input type="submit" value="login now" class="btn">
            <input type="checkbox" id="remmember">
            <label for="remember">Remember Me</label>
            <p>Forget Password?<a href="">Click Here</a></p>
            <p>Don't have Any Account?<a href="">Register Now</a></p>
        </form>
    </div>

    @yield('frontend-section')

    <br><br><br><br><br><br>

    <!-- Footer Section Starts -->
    {{-- <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>About Us</h3>
                <p>AAA</p>
            </div>
            <div class="box">
                <h3>Branch Location</h3>
                <a href="">USA</a>
                <a href="">USA</a>
                <a href="">USA</a>
                <a href="">USA</a>
                <a href="">USA</a>
                <a href="">USA</a>
            </div>
            <div class="box">
                <h3>Website Page Link</h3>
                <a href="">Home</a>
                <a href="">Booking</a>
                <a href="">Package</a>
                <a href="">Services</a>
                <a href="">Gallery</a>
                <a href="">Contact</a>
            </div>
            <div class="box">
                <h3>Website Page Link</h3>
                <a href="">Facebook</a>
                <a href="">Instagram</a>
                <a href="">Twitter</a>
                <a href="">Line</a>
                <a href="">Tiktok</a>
                <a href="">WhatApps</a>
            </div>
        </div>
        <h1 class="credit">Created By <span>Southern Website Sign</span> | All Rights Reserved!!</h1>
    </section> --}}

    <footer>
        <div class="waves">
            <div class="wave" id="wave1"></div>
            <div class="wave" id="wave2"></div>
            <div class="wave" id="wave3"></div>
            <div class="wave" id="wave4"></div>
        </div>

        <ul class="social_icon">
            <li><a href=""><ion-icon name="logo-facebook"></ion-icon></a></li>
            <li><a href=""><ion-icon name="logo-instagram"></ion-icon></a></li>
            <li><a href=""><ion-icon name="logo-whatsapp"></ion-icon></a></li>
            <li><a href=""><ion-icon name="logo-twitter"></ion-icon></a></li>
            <!-- <li><a href=""></a></li> -->
        </ul>

        <ul class="menu">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/allResort') }}">Resort</a></li>
            <li><a href="{{ url('/allHotel') }}">Hotel</a></li>
            <li><a href="{{ url('/allRestaurant') }}">Restaurant</a></li>
            <li><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>

        <p>@2023 Online Tutorials | All Rights Reserved</p>

    </footer>
    <!-- Footer Section Ends -->

    <!-- custome js file link -->
    <script src="{{ asset('new/main.js') }}"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    {{-- Review Swiper Function --}}
    {{-- <script>
        // Your JavaScript code that initializes Swiper
        var swiper = new Swiper(".review-slider", {
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    </script> --}}

    {{-- <script>
        // Your JavaScript code that initializes Swiper
        var swiper = new Swiper(".brand-slider", {
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            breakpoints: {
                450: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                991: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 5,
                },
            },
        });
    </script> --}}

    {{-- Footer JS --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    {{-- Card JS --}}
    {{-- <script src="{{ asset ('new/card/script.js') }}"></script> --}}

    {{-- Comment JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('new/comment/js/main.js') }}"> --}}

    {{-- Toastr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- // <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}

</body>

</html>
