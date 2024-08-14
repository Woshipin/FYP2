<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Static Site </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="YOUR_CSRF_TOKEN_VALUE">
        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link rel = "stylesheet" href = "{{asset ('user/main.css') }}">
        <!-- Frontend All Resort -->
        <link rel="stylesheet" href="{{asset ('user/resort.css') }}">
        <!-- Slick CSS files -->
        <link rel = "stylesheet" href = "{{asset ('user/slick-1.8.1/slick/slick.css') }}">
        <link rel = "stylesheet" href = "{{asset ('user/slick-1.8.1/slick/slick-theme.css') }}">
        {{-- Toastr CSS --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

        <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> -->
    </head>
  <body>
    <!-- header -->
    <header class = "header" id = "home">
        <div class = "header-wrapper">
            <!-- navbar -->
            <div class = "navbar-wrapper">
                <nav class = "navbar container">
                    <div class = "brand-and-toggler container">
                        <a href = "{{ url('/home') }}" class = "navbar-brand">dirEngine.</a>
                        <button type = "button" class = "navbar-toggler" id = "navbar-toggler">
                            <span><i class = "fas fa-bars"></i> MENU</span>
                        </button>
                    </div>

                    <div class = "navbar-collapse">
                        <ul class = "navbar-nav container">
                            <li class = "nav-item">
                                <a href = "{{ url('/home') }}" class ="nav-link">Home</a>
                            </li>
                            <li class = "nav-item">
                                <a href = "{{ url('/about') }}" class ="nav-link">About</a>
                            </li>
                            <li class = "nav-item">
                                <a href = "{{ url('allResort') }}" class ="nav-link">Resort</a>
                            </li>
                            <li class = "nav-item">
                                <a href = "#featured" class ="nav-link">Hotel</a>
                            </li>
                            <li class = "nav-item">
                                <a href = "{{ url('allRestaurant') }}" class ="nav-link">Restaurant</a>
                            </li>
                            <li class = "nav-item">
                                <a href = "#contact" class ="nav-link">Contact</a>
                            </li>

                                @auth
                                    <li class="nav-item">
                                        <a class="button-31" role="button" href="{{ url('/logout') }}">Logout</a>
                                    </li>
                                @endauth

                                @guest
                                    <li class="nav-item">
                                        <a class="button-29" role="button" href="{{ url('/login-register') }}">Login</a>
                                    </li>
                                @endguest

                            <!-- <li class="nav-item">
                                <a class="button-31" role="button" href="{{ url('/logout') }}">Logout</a>
                            </li> -->
                            @php
                                $id = Auth::user()->id;
                            @endphp
                            <li class = "nav-item special-nav-btn">
                                <a href="{{ url('/users/dashboard/' . $id) }}" class="nav-link">My Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class = "banner">
                <div class = "container">
                    <h1 class = "banner-title">
                        <span>Explore</span> your amazing city
                    </h1>
                    <p class = "banner-text">Find great palces to stay, eat, shop, or visit from local experts</p>

                    <!-- <div class="form-group">
                        <button class="button-29" role="button" href="{{url('/login&register')}}">Login</button>
                        <button class="button-30" role="button" href="{{url('/login&register')}}">Register</button>
                        <button class="button-31" role="button" href="{{ url('/logout') }}">Logout</button>
                    </div> -->

                    <!-- <form class = "banner-form">
                        <div class = "form-element">
                            <input type = "text" class = "form-control" placeholder="Ex:food, service, hotel">
                        </div>
                        <div class = "form-element">
                            <select name = "places" class = "form-control">
                                <option value = "where">Where</option>
                                <option value = "USA">San Francisco USA</option>
                                <option value = "Germany">Berline Germany</option>
                                <option value = "UK">London United Kingdom</option>
                                <option value = "Italy">Paris Italy</option>
                            </select>
                        </div>
                        <div class = "form-element">
                            <input type = "submit" class = "banner-btn" value = "Search">
                        </div>
                    </form> -->
                    <!-- <p class = "banner-text">Or browse the highlights</p>
                    <div class = "banner-btns">
                        <button type = "button" class = "banner-btn">
                            <span><i class = "fas fa-utensils"></i></span> Restaurant
                        </button>
                        <button type = "button" class = "banner-btn">
                            <span><i class = "fas fa-hotel"></i></span> Hotel
                        </button>
                        <button type = "button" class = "banner-btn">
                            <span><i class = "fas fa-map-marker-alt"></i></span> Places
                        </button>
                        <button type = "button" class = "banner-btn">
                            <span><i class = "fas fa-shopping-cart"></i></span> Shopping
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </header>
    <!-- end of header -->

    @yield('main-section')

    <!-- footer -->
    <footer class = "footer section-py" id = "contact">
            <div class = "container">
                <div class = "footer-wrapper">
                    <div class = "footer-div footer-div-1">
                        <h2 class = "normal-title">dirEngine</h2>
                        <p class = "normal-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, magnam animi eligendi fugit beatae sint magni perspiciatis minus tempore eveniet commodi ea, impedit voluptates! Iusto odit nesciunt sunt architecto est?</p>
                        <div class = "social-icons">
                            <a href = "#">
                                <span><i class = "fab fa-twitter"></i></span>
                            </a>
                            <a href = "#">
                                <span><i class = "fab fa-facebook"></i></span>
                            </a>
                            <a href = "#">
                                <span><i class = "fab fa-instagram"></i></span>
                            </a>
                        </div>
                    </div>

                    <div class = "footer-div footer-div-2">
                        <h2 class = "normal-title">Information</h2>
                        <ul class = "footer-links">
                            <li><a href = "#">About</a></li>
                            <li><a href = "#">Service</a></li>
                            <li><a href = "#">Terms and Conditions</a></li>
                            <li><a href = "#">Become a partner</a></li>
                            <li><a href = "#">Best Price Guarantee</a></li>
                            <li><a href = "#">Privacy and Policy</a></li>
                        </ul>
                    </div>

                    <div class = "footer-div footer-div-3">
                        <h2 class = "normal-title">Customer Support</h2>
                        <ul class = "footer-links">
                            <li><a href = "#">FAQ</a></li>
                            <li><a href = "#">Payment Option</a></li>
                            <li><a href = "#">Booking Tips</a></li>
                            <li><a href = "#">How it works</a></li>
                            <li><a href = "#">Contact Us</a></li>
                        </ul>
                    </div>

                    <div class = "footer-div footer-div-4">
                        <h2 class = "normal-title">Have a Question?</h2>
                        <ul class = "footer-links">
                            <li class = "contact-single">
                                <span>
                                    <i class = "fas fa-map-marker-alt"></i>
                                </span>
                                <span>203 Fake St. Mountain View, San Francisco, California, USA</span>
                            </li>
                            <li class = "contact-single">
                                <span>
                                    <i class = "fas fa-phone"></i>
                                </span>
                                <span>+ 3844 2783 283</span>
                            </li>
                            <li class = "contact-single">
                                <span>
                                    <i class = "fas fa-envelope"></i>
                                </span>
                                <span>info@yourdomain.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class = "copyright-text">
                    <p>Copyright &copy; 2020 All rights reserved | This template is made with the help of Colorlib</p>
                </div>
            </div>
        </footer>
        <!-- end of footer -->

        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <!-- numscroller -->
        <script src = "{{asset ('user/numscroller-gh-pages/numscroller-1.0.js') }}"></script>
        <!-- Slick JS file -->
        <script src = "{{asset ('user/slick-1.8.1/slick/slick.min.js') }}"></script>
        <!-- Custom JS -->
        <script src = "{{asset ('user/script.js') }}"></script>
        {{-- Toastr JS --}}
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  </body>
</html>
