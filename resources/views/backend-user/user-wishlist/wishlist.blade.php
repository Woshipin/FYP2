@extends('backend-user.newlayout')

@section('newuser-section')

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- New Card Slider CSS Important --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    {{-- New Card --}}
    <link rel="stylesheet" href="{{ asset('new/card/card.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset ('new/style.css') }}"> --}}

    {{-- New Card Ui With Slider --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .swiper-slide {
            background: linear-gradient(to bottom right, #ffffff, #f0f0f0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            padding: 0;
            margin: 0 10px;
            width: 300px;
            height: 500px;
            display: flex;
            flex-direction: column;
        }

        .swiper-slide:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.07);
        }

        .swiper-slide .image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .swiper-slide .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-slide .content {
            padding: 1.5rem;
            background: #ffffff;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .swiper-slide .content h3 {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            height: 5rem;
            /* 增加高度 */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* 增加到3行 */
            -webkit-box-orient: vertical;
            line-height: 1.3;
            /* 添加行高以改善可读性 */
        }

        .swiper-slide .content p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            height: 5rem;
        }

        .swiper-slide .content .stars {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .swiper-slide .content .stars i {
            font-size: 16px;
            color: gold;
            margin-right: 2px;
        }

        .swiper-slide .content .concert-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .swiper-slide .content .btn,
        .swiper-slide .content .btn-danger {
            padding: 8px 16px;
            font-size: 0.9rem;
            border-radius: 50px;
            min-width: 90px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .swiper-slide .content .btn {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border: none;
        }

        .swiper-slide .content .btn:hover {
            background: linear-gradient(135deg, #e083eb, #e5475c);
            transform: translateY(-2px);
        }

        .swiper-slide .content .btn-danger {
            background-color: #ff4d4d;
            color: white;
            border: none;
        }

        .swiper-slide .content .btn-danger:hover {
            background-color: #e03d3d;
            transform: translateY(-2px);
        }

        #price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 5px 10px;
            border-radius: 8px;
        }

        .swiper-wrapper {
            display: flex;
            align-items: stretch;
        }

        @media (min-width: 768px) {
            .swiper-slide {
                flex: 0 0 300px;
            }
        }
    </style>

    {{-- User Resort Wishilist Card Ui With Slider --}}
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;">
        <div class="bradcumbContent">
            <h2>Wishlist Resort</h2>
        </div>
    </section>

    <br>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($resortWishlists->count() > 0)
                    @foreach ($resortWishlists as $resortWishlist)
                        <div class="swiper-slide slide">
                            <span class="price" id="price">${{ $resortWishlist->resort->price }}</span>

                            <div class="image"
                                style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                @if ($resortWishlist->resort->images->count() > 0)
                                    <img src="{{ asset('images/' . $resortWishlist->resort->images->first()->image) }}"
                                        class="d-block w-100" alt="Resort Image"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="color: #777;">No Image</span>
                                @endif
                            </div>

                            <div class="content">
                                <h3>{{ $resortWishlist->resort->name }}</h3>
                                <p>{{ $resortWishlist->resort->description }}</p>
                                <div class="stars">
                                    @if (isset($resortRatings[$resortWishlist->resort->id]['averageRating']) &&
                                            $resortRatings[$resortWishlist->resort->id]['averageRating'] > 0)
                                        @php $averageRating = $resortRatings[$resortWishlist->resort->id]['averageRating']; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $averageRating)
                                                <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                            @elseif ($i - 0.5 <= $averageRating)
                                                <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                            @else
                                                <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                            @endif
                                        @endfor
                                        <span>({{ number_format($averageRating, 1) }})</span>
                                    @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                        @endfor
                                    @endif
                                </div>
                                <div class="concert-info"
                                    style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                                    @if ($resortWishlist->status == 0)
                                        <a href="{{ url('Resortdetail/' . $resortWishlist->resort->id) . '/view' }}"
                                            class="btn">Book Now</a>
                                        <form action="{{ url('/wishlist/remove/' . $resortWishlist->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">Delete</button>
                                        </form>
                                    @else
                                        <a href="#" class="btn" id="closed">Closed</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="margin-top:40px; font-size:24px; display:block">No Resort Found</p>
                @endif
            </div>
            <br><br>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <hr>

    {{-- User Hotel Wishilist Card Ui With Slider --}}
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;">
        <div class="bradcumbContent">
            <h2>Wishlist Hotel</h2>
        </div>
    </section>

    <br>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($hotelWishlists->count() > 0)
                    @foreach ($hotelWishlists as $hotelWishlist)
                        <div class="swiper-slide slide">
                            <span class="price" id="price">${{ $hotelWishlist->hotel->price }}</span>

                            <div class="image"
                                style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                @if ($hotelWishlist->hotel->images->count() > 0)
                                    <img src="{{ asset('images/' . $hotelWishlist->hotel->images->first()->image) }}"
                                        class="d-block w-100" alt="Hotel Image"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="color: #777;">No Image</span>
                                @endif
                            </div>

                            <div class="content">
                                <h3>{{ $hotelWishlist->hotel->name }}</h3>
                                <p>{{ $hotelWishlist->hotel->description }}</p>
                                <div class="stars">
                                    @if (isset($hotelRatings[$hotelWishlist->hotel->id]['averageRating']) &&
                                            $hotelRatings[$hotelWishlist->hotel->id]['averageRating'] > 0)
                                        @php $averageRating = $hotelRatings[$hotelWishlist->hotel->id]['averageRating']; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $averageRating)
                                                <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                            @elseif ($i - 0.5 <= $averageRating)
                                                <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                            @else
                                                <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                            @endif
                                        @endfor
                                        <span>({{ number_format($averageRating, 1) }})</span>
                                    @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                        @endfor
                                    @endif
                                </div>
                                <div class='concert-info'>
                                    @if ($hotelWishlist->status == 0)
                                        <div class="concert-action-container" style="display: flex; align-items: center;">
                                            <a href="{{ url('Hoteldetail/' . $hotelWishlist->id) . '/view' }}"
                                                class="btn">Book Now</a>

                                            <form action="{{ url('/wishlist/remove/hotel/' . $hotelWishlist->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger"
                                                    style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="#" class="btn" id="closed">Closed</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="margin-top:40px; font-size:24px; display:block">No Wishlist Hotel Found</p>
                @endif
            </div>
            <br><br>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <hr>

    {{-- User Restaurant Wishilist Card Ui With Slider --}}
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;">
        <div class="bradcumbContent">
            <h2>Wishlist Restaurant</h2>
        </div>
    </section>

    <br>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($restaurantWishlists->count() > 0)
                    @foreach ($restaurantWishlists as $restaurantWishlist)
                        <div class="swiper-slide slide">
                            <span class="price" id="price">${{ $restaurantWishlist->restaurant->price }}</span>

                            <div class="image"
                                style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                @if ($restaurantWishlist->restaurant->images->count() > 0)
                                    <img src="{{ asset('images/' . $restaurantWishlist->restaurant->images->first()->image) }}"
                                        class="d-block w-100" alt="Restaurant Image"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span style="color: #777;">No Image</span>
                                @endif
                            </div>

                            <div class="content">
                                <h3>{{ $restaurantWishlist->restaurant->name }}</h3>
                                <p>{{ $restaurantWishlist->restaurant->description }}</p>
                                <div class="stars">
                                    @if (isset($restaurantRatings[$restaurantWishlist->restaurant->id]['averageRating']) &&
                                            $restaurantRatings[$restaurantWishlist->restaurant->id]['averageRating'] > 0)
                                        @php $averageRating = $restaurantRatings[$restaurantWishlist->restaurant->id]['averageRating']; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $averageRating)
                                                <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                            @elseif ($i - 0.5 <= $averageRating)
                                                <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                            @else
                                                <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                            @endif
                                        @endfor
                                        <span>({{ number_format($averageRating, 1) }})</span>
                                    @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                        @endfor
                                    @endif
                                </div>
                                <div class='concert-info'>
                                    @if ($restaurantWishlist->status == 0)
                                        <div class="concert-action-container" style="display: flex; align-items: center;">
                                            <a href="{{ url('Restaurantdetail/' . $restaurantWishlist->id) . '/view' }}"
                                                class="btn">Book Now</a>

                                            <form
                                                action="{{ url('/wishlist/remove/restaurant/' . $restaurantWishlist->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger"
                                                    style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="#" class="btn" id="closed">Closed</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="margin-top:40px; font-size:24px; display:block">No Wishlist Restaurant Found</p>
                @endif
            </div>
            <br><br>
            <div class="swiper-pagination"></div>
        </div>
    </section>


    <!-- Link Swiper's JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    {{-- Card Slider JS --}}
    <script>
        // Initialize Swiper
        var swiper = new Swiper('.room-slider', {
            // Specify your swiper options here
            loop: true, // Enable looping
            slidesPerView: 'auto', // 设置为 'auto'，让 swiper 根据容器的宽度自动确定每次滑动的距离
            pagination: {
                el: '.swiper-pagination', // Pagination container
                clickable: true, // Enable clickable pagination bullets
            },
            autoplay: {
                delay: 2000, // Delay between transitions in milliseconds
                disableOnInteraction: false, // Enable/disable autoplay on user interaction
            },
        });
    </script>

    {{-- Toastr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                }
            }).showToast();
        @elseif (Session::has('fail'))
            Toastify({
                text: "{{ Session::get('fail') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 10000,
                    style: {
                        background: "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            @endforeach
        @endif
    </script>

@endsection
