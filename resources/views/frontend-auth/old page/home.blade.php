@extends('auth.layout')

@section('main-section')

<!-- <div class="form-group">
    <button class="button-29" role="button" href="{{url('/login&register')}}">Login</button>
    <button class="button-30" role="button" href="{{url('/login&register')}}">Register</button>
    <button class="button-31" role="button" href="{{ url('/logout') }}">Logout</button>
</div> -->

<!-- featured section -->
<section class = "featured section-py" id = "featured">
    <div class = "container">
        <span class = "section-name">
            Featured
        </span>
        <h2 class = "section-title">
            <span>Featured </span> Destination
        </h2>

        <div class = "gallery">
            <div class = "single-place">
                <div class = "{{ asset('user/single-place-img') }}">
                    <img src = "images/place-1.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>Paris, France</p>
                    <p>4 Listing</p>
                </div>
            </div>

            <div class = "single-place">
                <div class = "{{ asset('user/single-place-img') }}">
                    <img src = "images/place-2.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>Australia</p>
                    <p>13 Listing</p>
                </div>
            </div>

            <div class = "single-place">
                <div class = "{{ asset('user/single-place-img') }}">
                    <img src = "images/place-3.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>San Francisco, USA</p>
                    <p>20 Listing</p>
                </div>
            </div>

            <div class = "single-place">
                <div class = "{{ asset('user/single-place-img') }}">
                    <img src = "images/place-4.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>London, UK</p>
                    <p>4 Listing</p>
                </div>
            </div>

            <div class = "single-place">
                <div class = "single-place-img">
                    <img src = "images/place-5.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>Bangkok, Thailand</p>
                    <p>11 Listing</p>
                </div>
            </div>

            <div class = "single-place">
                <div class = "single-place-img">
                    <img src = "images/place-6.jpg" alt = "places">
                    <span class = "display-icon">
                        <i class = "fas fa-search"></i>
                    </span>
                </div>
                <div class = "single-place-info">
                    <p>Rome, Italy</p>
                    <p>3 Listing</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of featured section -->

<!-- tour section -->
<!-- <section class = "tour section-py" id = "tour">
    <div class = "container">
        <span class = "section-name">
            Special Offers
        </span>
        <h2 class = "section-title">
            <span>Top</span> Tour Packages
        </h2>

        <div class = "tour-wrapper">
            <div class = "card">
                <img src = "{{ asset('user/images/place-7.jpg') }}" alt = "tour places">
                <div class = "card-body">
                    <div class = "tour-place">
                        <h2 class = "normal-text">Paris, France</h2>
                        <h2 class = "tour-price">$200</h2>
                    </div>
                    <div class = "rating">
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "far fa-star"></i></span>
                        8
                    </div>
                    <h6 class = "rating-text">Rating</h6>
                    <p class = "normal-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt incidunt quam consequuntur quia beatae minima quos non?</p>
                    <p class = "normal-para">2 days 3 nights</p>
                    <hr>
                </div>
                <div class = "card-footer">
                    <span class = "normal-para">
                        <i class = "fas fa-map"></i> Paris, France
                    </span>
                    <button class = "btn-green">
                        Discover
                    </button>
                </div>
            </div>

            <div class = "card">
                <img src = "{{ asset('user/images/place-8.jpg') }}" alt = "tour places">
                <div class = "card-body">
                    <div class = "tour-place">
                        <h2 class = "normal-text">Berlin, Germany</h2>
                        <h2 class = "tour-price">$200</h2>
                    </div>
                    <div class = "rating">
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "far fa-star"></i></span>
                        8
                    </div>
                    <h6 class = "rating-text">Rating</h6>
                    <p class = "normal-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt incidunt quam consequuntur quia beatae minima quos non?</p>
                    <p class = "normal-para">2 days 3 nights</p>
                    <hr>
                </div>
                <div class = "card-footer">
                    <span class = "normal-para">
                        <i class = "fas fa-map"></i> Berlin, Germany
                    </span>
                    <button class = "btn-green">
                        Discover
                    </button>
                </div>
            </div>

            <div class = "card">
                <img src = "{{ asset('user/images/place-9.jpg') }}" alt = "tour places">
                <div class = "card-body">
                    <div class = "tour-place">
                        <h2 class = "normal-text">Roma, Italy</h2>
                        <h2 class = "tour-price">$200</h2>
                    </div>
                    <div class = "rating">
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "far fa-star"></i></span>
                        8
                    </div>
                    <h6 class = "rating-text">Rating</h6>
                    <p class = "normal-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt incidunt quam consequuntur quia beatae minima quos non?</p>
                    <p class = "normal-para">2 days 3 nights</p>
                    <hr>
                </div>
                <div class = "card-footer">
                    <span class = "normal-para">
                        <i class = "fas fa-map"></i> Roma, Italy
                    </span>
                    <button class = "btn-green">
                        Discover
                    </button>
                </div>
            </div>

            <div class = "card">
                <img src = "{{ asset('user/images/place-10.jpg') }}" alt = "tour places">
                <div class = "card-body">
                    <div class = "tour-place">
                        <h2 class = "normal-text">Paris, France</h2>
                        <h2 class = "tour-price">$200</h2>
                    </div>
                    <div class = "rating">
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "far fa-star"></i></span>
                        8
                    </div>
                    <h6 class = "rating-text">Rating</h6>
                    <p class = "normal-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt incidunt quam consequuntur quia beatae minima quos non?</p>
                    <p class = "normal-para">2 days 3 nights</p>
                    <hr>
                </div>
                <div class = "card-footer">
                    <span class = "normal-para">
                        <i class = "fas fa-map"></i> Paris, France
                    </span>
                    <button class = "btn-green">
                        Discover
                    </button>
                </div>
            </div>

            <div class = "card">
                <img src = "{{ asset('user/images/place-11.jpg') }}" alt = "tour places">
                <div class = "card-body">
                    <div class = "tour-place">
                        <h2 class = "normal-text">Leshan, China</h2>
                        <h2 class = "tour-price">$200</h2>
                    </div>
                    <div class = "rating">
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "fas fa-star"></i></span>
                        <span><i class = "far fa-star"></i></span>
                        8
                    </div>
                    <h6 class = "rating-text">Rating</h6>
                    <p class = "normal-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt incidunt quam consequuntur quia beatae minima quos non?</p>
                    <p class = "normal-para">2 days 3 nights</p>
                    <hr>
                </div>
                <div class = "card-footer">
                    <span class = "normal-para">
                        <i class = "fas fa-map"></i> Leshan, China
                    </span>
                    <button class = "btn-green">
                        Discover
                    </button>
                </div>
            </div>

        </div>
    </div>
</section> -->
<!-- end tour section -->

<!-- numscroller -->
<section class = "facts section-py">
    <div class = "container">
        <h2>Some Fun Facts</h2>
        <p class = "normal-para">More than 6000 websites hosted</p>
        <div class = "fact-wrapper">
            <div class = "single-data">
                <span class='numscroller' data-min='1' data-max='6000' data-delay='20' data-increment='5'>0</span>
                <span class = "numscroller-text">Happy Customers</span>
            </div>
            <div class = "single-data">
                <span class='numscroller' data-min='1' data-max='9600' data-delay='20' data-increment='5'>0</span>
                <span class = "numscroller-text">Destination</span>
            </div>
            <div class = "single-data">
                <span class='numscroller' data-min='1' data-max='12000' data-delay='20' data-increment='5'>0</span>
                <span class = "numscroller-text">Hotels</span>
            </div>
            <div class = "single-data">
                <span class='numscroller' data-min='1' data-max='5550' data-delay='20' data-increment='5'>0</span>
                <span class = "numscroller-text">Restaurants</span>
            </div>
        </div>
    </div>
</section>
<!-- end of numscroller -->

<!-- blog section -->
<section class = "blog section-py" id = "blog">
    <div class = "container">
        <span class = "section-name">
            Recent Blog
        </span>
        <h2 clas = "section-title">
            <span>Tips</span> & Articles
        </h2>

        <div class = "blog-wrapper">
            <!-- single blog card -->
            <div class = "card">
                <img src = "{{ asset('user/images/blog-img-1.jpg') }}" alt = "blog image">
                <div class = "card-body">
                    <p class = "normal-text">Tips, Travel</p>
                    <a href = "#" class = "normal-title blog-link">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam, exercitationem repudiandae? Ad!</a>
                    <p class = "normal-text">August 12, 2018 Guest Author</p>
                    <span class = "normal-text">
                        <i class = "fas fa-comment-alt"></i> 3
                    </span>
                </div>
            </div>
            <!-- end of single blog card -->
            <!-- single blog card -->
            <div class = "card">
                <img src = "{{ asset('user/images/blog-img-2.jpg') }}" alt = "blog image">
                <div class = "card-body">
                    <p class = "normal-text">Tips, Travel</p>
                    <a href = "#" class = "normal-title blog-link">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam, exercitationem repudiandae? Ad!</a>
                    <p class = "normal-text">August 12, 2018 Guest Author</p>
                    <span class = "normal-text">
                        <i class = "fas fa-comment-alt"></i> 3
                    </span>
                </div>
            </div>
            <!-- end of single blog card -->
            <!-- single blog card -->
            <div class = "card">
                <img src = "{{ asset('user/images/blog-img-3.jpg') }}" alt = "blog image">
                <div class = "card-body">
                    <p class = "normal-text">Tips, Travel</p>
                    <a href = "#" class = "normal-title blog-link">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam, exercitationem repudiandae? Ad!</a>
                    <p class = "normal-text">August 12, 2018 Guest Author</p>
                    <span class = "normal-text">
                        <i class = "fas fa-comment-alt"></i> 3
                    </span>
                </div>
            </div>
            <!-- end of single blog card -->
            <!-- single blog card -->
            <div class = "card">
                <img src = "{{ asset('user/images/blog-img-4.jpg') }}" alt = "blog image">
                <div class = "card-body">
                    <p class = "normal-text">Tips, Travel</p>
                    <a href = "#" class = "normal-title blog-link">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam, exercitationem repudiandae? Ad!</a>
                    <p class = "normal-text">August 12, 2018 Guest Author</p>
                    <span class = "normal-text">
                        <i class = "fas fa-comment-alt"></i> 3
                    </span>
                </div>
            </div>
            <!-- end of single blog card -->
        </div>
    </div>
</section>
<!-- end of blog section -->

<!-- newsletter section -->
<section class = "newsletter section-py">
    <div class = "container">
        <div class = "newsletter-wrapper">
            <h2>Subscribe to our Newsletter</h2>
            <p class = "normal-para">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Recusandae enim praesentium culpa laborum fuga dicta voluptatem voluptate minima voluptatum maiores accusamus reiciendis veniam omnis eos voluptates, magnam veritatis doloribus velit!</p>
            <form class = "subscribe-form">
                <div class = "form-element">
                    <input type = "email" class = "form-control" placeholder="Enter email address">
                </div>
                <div class = "form-element">
                    <input type = "submit" class = "form-control" value = "Subscribe">
                </div>
            </form>
        </div>
    </div>
</section>
<!-- end of newsletter section -->

<!-- testimonial section -->
<section class = "testimonial section-py">
    <div class = "container">
        <div class = "testimonial-wrapper">
            <!-- testimonial left -->
            <div class = "testimonial-left">
                <span class = "section-name">Best Directory Website</span>
                <h2 class = "section-title">
                    <span>Why</span> Choose Us?
                </h2>
                <p class = "normal-para">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus ipsum iusto fugit architecto nesciunt recusandae, officia, maiores possimus, soluta eos non dolor hic accusamus? Libero dolor vero odit, cupiditate aliquam ipsa non optio quaerat voluptates rerum deleniti ducimus dicta veniam?
                </p>
                <p class = "normal-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt exercitationem pariatur nostrum laudantium repudiandae quis?</p>
                <button type = "button" class = "btn-circle">Read More</button>
            </div>
            <!-- testimonial right -->
            <div class = "testimonial-right">
                <span class = "section-name">Testimony</span>
                <h2 class = "section-title">
                    <span>Our</span> Guests Says
                </h2>
                <div class = "test-slider">
                    <!-- single testimonial -->
                    <div class = "test-single">
                        <div class = "test-img">
                            <img src = "images/person-1.jpg" alt = "guest person">
                            <span class = "quote-icon">
                                <i class = "fas fa-quote-left"></i>
                            </span>
                        </div>
                        <div class = "text-content">
                            <p class = "normal-para">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quasi iure iste consequuntur reprehenderit neque obcaecati voluptatibus eaque explicabo? Doloremque?
                            </p>
                            <div class = "about-guest">
                                <p>Dennis Green</p>
                                <p>Guest from America</p>
                            </div>
                        </div>
                    </div>
                    <!-- end of single testimonial -->
                    <!-- single testimonial -->
                    <div class = "test-single">
                        <div class = "test-img">
                            <img src = "images/person-2.jpg" alt = "guest person">
                            <span class = "quote-icon">
                                <i class = "fas fa-quote-left"></i>
                            </span>
                        </div>
                        <div class = "text-content">
                            <p class = "normal-para">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quasi iure iste consequuntur reprehenderit neque obcaecati voluptatibus eaque explicabo? Doloremque?
                            </p>
                            <div class = "about-guest">
                                <p>Dennis Green</p>
                                <p>Guest from America</p>
                            </div>
                        </div>
                    </div>
                    <!-- end of single testimonial -->
                    <!-- single testimonial -->
                    <div class = "test-single">
                        <div class = "test-img">
                            <img src = "images/person-3.jpg" alt = "guest person">
                            <span class = "quote-icon">
                                <i class = "fas fa-quote-left"></i>
                            </span>
                        </div>
                        <div class = "text-content">
                            <p class = "normal-para">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto quasi iure iste consequuntur reprehenderit neque obcaecati voluptatibus eaque explicabo? Doloremque?
                            </p>
                            <div class = "about-guest">
                                <p>Dennis Green</p>
                                <p>Guest from America</p>
                            </div>
                        </div>
                    </div>
                    <!-- end of single testimonial -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of testimonial section -->

@endsection
