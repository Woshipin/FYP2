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
        .btn-danger {
            background-color: red;
            color: white;
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 1rem;
            background: red color: #fff;
            padding: .6rem 1rem;
            border: .2rem solid var(--red);
        }

        .btn {
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 1rem;
            /* margin: 10px; */
            background: var(--orange);
            color: #fff;
            padding: .6rem 1rem;
            border: .2rem solid var(--orange);
            /* cursor: pointer; */
            /* font-size: 1.7rem; */
        }

        .btn:hover {
            background: rgba(255, 165, 0, .2);
            color: var(--orange);
        }

        #price {
            color: #000;
            /* 使用深黑色（十六进制颜色代码） */
            font-size: 150%;
        }

        #closed {
            border-radius: 8px;
            /* 调整按钮的边框半径 */
            color: black;
            /* 设置按钮的文字颜色为黑色 */
            background-color: silver;
            /* 设置按钮的背景颜色为银灰色 */
            padding: 8px 16px;
            /* 可选：调整按钮的内边距以增加按钮的大小 */
        }

        .swiper-slide.slide {
            /* background-color: black;
                                                            color: gold; */
            border-radius: 10px;
            padding: 20px;
        }

        /* 基础样式 */
        .room .slide {
            flex: 0 0 100%;
            margin-bottom: 2rem;
            background: linear-gradient(to bottom right, silver, #f0f0f0, #000000);
            border-radius: 10px;
            padding: 20px;
        }

        .room .slide .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .room .slide .content {
            padding: 1.5rem;
        }

        .room .slide .content h3 {
            font-size: 2rem;
        }

        .room .slide .content p {
            font-size: 1.4rem;
            line-height: 1.6;
        }

        .room .slide .content .stars i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        /* 媒体查询：调整样式以适应不同屏幕尺寸 */
        @media screen and (min-width: 768px) {
            .room .slide {
                flex: 0 0 calc(33.333% - 2rem);
                margin: 1rem;
            }

            .room .slide .content {
                padding: 2rem;
            }

            .room .slide .content h3 {
                font-size: 2.5rem;
            }

            .room .slide .content p {
                font-size: 1.6rem;
            }

            .room .slide .content .stars i {
                font-size: 1.7rem;
            }
        }
    </style>

    {{-- User Resort Wishilist Card Ui With Slider --}}
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;">
        <div class="bradcumbContent">
            {{-- <p>See what's new</p> --}}
            <h2>Wishilist Resort</h2>
        </div>
    </section>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($resortWishlists->count() > 0)
                    @foreach ($resortWishlists as $resortWishlist)
                        <div class="swiper-slide slide">
                            <div class="image">
                                <span class="price" id="price">${{ $resortWishlist->resort->price }}</span>
                                <img src="{{ asset('images/' . $resortWishlist->resort->image) }}" alt="">
                            </div>
                            <div class="content">
                                <h3>{{ $resortWishlist->resort->name }}</h3>
                                <p>{{ $resortWishlist->resort->description }}</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class='concert-info'>
                                    @if ($resortWishlist->status == 0)
                                        <div class="concert-action-container" style="display: flex; align-items: center;">
                                            {{-- <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p> --}}
                                            <a href="{{ url('Resortdetail/' . $resortWishlist->id) . '/view' }}"
                                                class="btn" id="viewresort{{ $resortWishlist->id }}">Book Now</a>
                                            <form action="{{ url('/wishlist/remove/' . $resortWishlist->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger"
                                                    id="deleteResort{{ $resortWishlist->id }}"
                                                    style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed" class="concert-action">Closed</a>
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
            {{-- <p>See what's new</p> --}}
            <h2>Wishilist Hotel</h2>
        </div>
    </section>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($hotelWishlists->count() > 0)
                    @foreach ($hotelWishlists as $hotelWishlist)
                        <div class="swiper-slide slide">
                            <div class="image">
                                {{-- <span class="price" id="price">${{ $resortWishlist->resort->price }}</span> --}}
                                <img src="{{ asset('images/' . $hotelWishlist->hotel->image) }}" alt="">
                            </div>
                            <div class="content">
                                <h3>{{ $hotelWishlist->hotel->name }}</h3>
                                <p>{{ $hotelWishlist->hotel->description }}</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class='concert-info'>
                                    @if ($hotelWishlist->status == 0)
                                        <div class="concert-action-container" style="display: flex; align-items: center;">
                                            {{-- <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p> --}}
                                            <a href="{{ url('Hoteldetail/' . $hotelWishlist->id) . '/view' }}"
                                                class="btn" id="viewhotel{{ $hotelWishlist->id }}">Book Now</a>

                                            <form action="{{ url('/wishlist/remove/hotel/' . $hotelWishlist->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger"
                                                    id="viewhotel{{ $hotelWishlist->id }}"
                                                    style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed" class="concert-action">Closed</a>
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
            {{-- <p>See what's new</p> --}}
            <h2>Wishilist Restaurant</h2>
        </div>
    </section>

    <section class="room" id="room">
        <div class="swiper room-slider">
            <div class="swiper-wrapper">
                @if ($restaurantWishlists->count() > 0)
                    @foreach ($restaurantWishlists as $restaurantWishlist)
                        <div class="swiper-slide slide">
                            <div class="image">
                                {{-- <span class="price" id="price">${{ $resortWishlist->resort->price }}</span> --}}
                                <img src="{{ asset('images/' . $restaurantWishlist->restaurant->image) }}" alt="">
                            </div>
                            <div class="content">
                                <h3>{{ $restaurantWishlist->restaurant->name }}</h3>
                                <p>{{ $restaurantWishlist->restaurant->description }}</p>
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <div class='concert-info'>
                                    @if ($restaurantWishlist->status == 0)
                                        <div class="concert-action-container" style="display: flex; align-items: center;">
                                            {{-- <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p> --}}
                                            <a href="{{ url('Restaurantdetail/' . $restaurantWishlist->id) . '/view' }}"
                                                class="btn" id="viewrestaurant{{ $restaurantWishlist->id }}">Book
                                                Now</a>

                                            <form
                                                action="{{ url('/wishlist/remove/restaurant/' . $restaurantWishlist->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger"
                                                    id="deleteRestaurant{{ $restaurantWishlist->id }}"
                                                    style="margin-left: 10px;">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed"
                                            class="concert-action">Closed</a>
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

    {{-- <script>
        // Initialize Swiper
        var swiper = new Swiper('.room-slider', {
            // Specify your swiper options here
            loop: true, // Enable looping
            slidesPerView: 'auto', // 设置为 'auto'，让 swiper 根据容器的宽度自动确定每次滑动的距离
            pagination: {
                el: '.swiper-pagination', // Pagination container
                type: 'bullets', // 设置分页器类型为圆点型
                clickable: true, // 允许点击圆点进行切换
            },
            autoplay: {
                delay: 2000, // Delay between transitions in milliseconds
                disableOnInteraction: false, // Enable/disable autoplay on user interaction
            },
            on: {
                init: function () {
                    // 自定义渲染分数
                    var total = this.slides.length - 1; // 总共的点点数量
                    var visibleFraction = Math.min(total, 5); // 最多显示5个点点
                    var paginationEl = document.querySelector('.swiper-pagination');
                    paginationEl.innerHTML = ''; // 清空原有的分页器内容
                    for (var i = 0; i < visibleFraction; i++) {
                        // 添加新的圆点
                        var bullet = document.createElement('span');
                        bullet.className = 'swiper-pagination-bullet';
                        paginationEl.appendChild(bullet);
                    }
                }
            }
        });
    </script> --}}

    {{-- <script>
        // Initialize Swiper
        var swiper = new Swiper('.room-slider', {
            // Specify your swiper options here
            loop: true, // Enable looping
            slidesPerView: 'auto', // 设置为 'auto'，让 swiper 根据容器的宽度自动确定每次滑动的距离
            pagination: {
                el: '.swiper-pagination', // Pagination container
                type: 'bullets', // 设置分页器类型为圆点型
                clickable: true, // 允许点击圆点进行切换
            },
            autoplay: {
                delay: 2000, // Delay between transitions in milliseconds
                disableOnInteraction: false, // Enable/disable autoplay on user interaction
            },
            on: {
                init: function() {
                    // 只显示 5 个圆点
                    var visibleFraction = 5;
                    var paginationEl = document.querySelector('.swiper-pagination');
                    paginationEl.innerHTML = ''; // 清空原有的分页器内容
                    for (var i = 0; i < visibleFraction; i++) {
                        // 添加新的圆点
                        var bullet = document.createElement('span');
                        bullet.className = 'swiper-pagination-bullet';
                        paginationEl.appendChild(bullet);
                    }
                }
            }
        });
    </script> --}}

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
