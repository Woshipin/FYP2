@extends('frontend-auth.newlayout')

@section('frontend-section')

    {{-- Button CSS --}}
    <style>
        /* Style the WhatsApp icon */
        .btn-success {
            background-color: white;
            padding: 12px;
            border-radius: 50%;
        }

        .btn-success i {
            font-size: 20px;
            color: green;
        }

        .btn-success i:hover {
            font-size: 24px;
            color: white;
        }

        .btn-info {
            background-color: white;
            padding: 12px;
            border-radius: 50%;
        }

        .btn-info i {
            font-size: 20px;
            color: red;
        }

        .btn-info i:hover {
            font-size: 24px;
            color: white;
        }
    </style>

    {{-- Responsible UI CSS --}}
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .product-price {
            margin-bottom: 20px;
        }

        .product-price p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .product-price .last-price {
            font-weight: bold;
        }

        .product-price .new-price {
            font-style: italic;
        }

        hr {
            border: 1px solid #000;
            margin: 20px 0;
        }

        .product-detail {
            margin-bottom: 20px;
            color: #333;
        }

        .product-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #004080;
        }

        .product-detail p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
            color: black;
        }

        .product-detail h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: black;
        }

        @media (max-width: 600px) {
            .product-price p,
            .product-detail p {
                font-size: 14px;
            }

            .product-detail h2 {
                font-size: 20px;
            }

            .product-detail h3 {
                font-size: 16px;
            }
        }
    </style>

    {{-- Mutliple Image UI CSS --}}
    <style>
        .product-imgs {
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        .img-display {
            width: 100%;
            overflow: hidden;
        }

        .swiper {
            width: 100%;
            height: auto;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* New style for image placeholder */
        .img-placeholder {
            width: 100%;
            height: 300px;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #666;
            border: 1px solid #ddd;
        }
    </style>

    {{-- Rating CSS --}}
    <style>
        .rating-css {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .rating-css div {
            color: #ffe400;
            font-size: 30px;
            font-family: sans-serif;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            padding: 20px 0;
        }

        .rating-css input {
            display: none;
        }

        .rating-css input + label {
            font-size: 60px;
            text-shadow: 1px 1px 0 #8f8420;
            cursor: pointer;
        }

        .rating-css input:checked + label ~ label {
            color: #b4afaf;
        }

        .rating-css label:active {
            transform: scale(0.8);
            transition: 0.3s ease;
        }

        .star-icon {
            display: flex;
            gap: 5px;
        }

        .submit-button {
            display: flex;
            justify-content: center;
        }

        .submit-button button {
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .rating-css div {
                font-size: 20px;
            }

            .rating-css input + label {
                font-size: 40px;
            }

            .submit-button button {
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .rating-css div {
                font-size: 18px;
            }

            .rating-css input + label {
                font-size: 30px;
            }

            .star-icon {
                gap: 3px;
            }

            .submit-button button {
                margin-top: 15px;
            }
        }
    </style>

    {{-- toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    {{-- Mutliple Image Silder CSS and JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .product-price {
            margin-bottom: 20px;
        }

        .product-price p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .product-price .last-price {
            font-weight: bold;
        }

        .product-price .new-price {
            font-style: italic;
        }

        hr {
            border: 1px solid #000;
            margin: 20px 0;
        }

        .product-detail {
            margin-bottom: 20px;
            color: #333;
            /* 主要文本颜色，可以根据需要调整 */
        }

        .product-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #004080;
            /* 深蓝色，可以根据需要调整 */
        }

        .product-detail p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
            color: black;
            /* 中灰色，可以根据需要调整 */
        }

        .product-detail h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: black;
            /* 深绿色，可以根据需要调整 */
        }


        /* 添加响应式设计样式 */
        @media (max-width: 600px) {

            /* 在小屏幕上进行调整 */
            .product-price p,
            .product-detail p {
                font-size: 14px;
            }

            .product-detail h2 {
                font-size: 20px;
            }

            .product-detail h3 {
                font-size: 16px;
            }
        }
    </style>

    <br><br><br><br><br><br>

    <div class="card-wrapper">
        <div class="card">

            {{-- Mutliple Image --}}
            <div class="product-imgs">
                <div class="img-display">
                    <div class="swiper img-showcase">
                        <div class="swiper-wrapper">
                            @if($restaurants->images->isNotEmpty())
                                @foreach ($restaurants->images as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('images/' . $image->image) }}" alt="resort image"
                                            onclick="show360Image('{{ asset('images/' . $image->image) }}')"
                                            style="max-width: 100%; height: auto;">
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <div class="img-placeholder">No Image</div>
                                </div>
                            @endif
                        </div>

                        <!-- 分页导航 -->
                        <div class="swiper-pagination"></div>

                        <!-- 导航按钮 -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

            <!-- 模态窗口，用于显示360度视图 -->
            <div id="pannellumModal"
                style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000;">
                <div id="panorama" style="width: 100%; height: 100%;"></div>
                <button onclick="close360View()"
                    style="position: absolute; top: 10px; right: 10px; padding: 10px; background: #fff; border: none; cursor: pointer;">Close</button>
            </div>

            <!-- card right -->
            <div class="product-content">
                <h2 class="product-title">{{ $restaurants->name }}</h2>
                <a href="#" class="product-link">Visit Restaurant</a>

                <br><br>

                <!-- Restaurant Rating 显示评分 -->
                <div class="show-rating-css">
                    <div class="star-icon">
                        @if ($averageRating)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $averageRating)
                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                @elseif ($i - 0.5 <= $averageRating)
                                    <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                @else
                                    <i class="far fa-star" style="font-size: 20px;"></i>
                                @endif
                            @endfor
                            <span>({{ $averageRating }})</span>
                        @elseif ($singleRating)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $singleRating)
                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                @elseif ($i - 0.5 <= $singleRating)
                                    <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                @else
                                    <i class="far fa-star" style="font-size: 20px;"></i>
                                @endif
                            @endfor
                            <span>({{ $singleRating }})</span>
                        @else
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                            @endfor
                        @endif
                    </div>
                </div>

                <div class="product-price">
                    <p class="last-price">Restaurant Open Date: {{ $restaurants->date }}</p>
                    <p class="new-price">Restaurant Open Time: {{ $restaurants->time }}</p>
                    <p class="new-price">Restaurant Phone Number: {{ $restaurants->phone }}</p>
                    <p class="new-price">Restaurant Contact Email: {{ $restaurants->email }}</p>
                </div>

                <hr>

                <div class="product-detail">
                    <h2>About this Restaurant address and description:</h2>
                    <h3 class="new-price">Restaurant Country: {{ $restaurants->country }}</h3>
                    <h3 class="new-price">Restaurant State: {{ $restaurants->state }}</h3>
                    <h3>Restaurant Address: {{ $restaurants->address }}</h3>
                    <h3>Restaurant Description: {{ $restaurants->description }}</h3>
                </div>

                <div class="purchase-info">
                    <a href="{{ url('booking/' . $restaurants->id) }}" class="btn"><i
                            class="fas fa-calendar-check"></i>&nbsp;Booking</a>
                    <a href="{{ route('restaurants.comment', ['id' => $restaurantId]) }}" class="btn m2"><i
                            class="fas fa-comment"></i>&nbsp;Comment</a>
                    <a href="https://wa.me/601110801649" target="_blank" class="btn-success"><i
                            class="fab fa-whatsapp"></i></a>
                    <a href="{{ route('restaurants.contact', ['id' => $restaurantId]) }}" class="btn-info"><i
                            class="far fa-envelope"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!--Add Restaurant Rating Modal -->
    <div class="add-rating-css">
        <form action="{{ route('restaurantratings') }}" method="POST">
            @csrf

            <input type="hidden" name="rateable_id" value="{{ $restaurants->id }}">
            <input type="hidden" name="rateable_name" value="{{ $restaurants->name }}">
            <input type="hidden" name="rateable_type" value="{{ $restaurants->type }}">

            <div class="rating-css">
                <div class="star-icon">
                    <input type="radio" value="1" name="rating" id="rating1">
                    <label for="rating1" class="fa fa-star"></label>
                    <input type="radio" value="2" name="rating" id="rating2">
                    <label for="rating2" class="fa fa-star"></label>
                    <input type="radio" value="3" name="rating" id="rating3">
                    <label for="rating3" class="fa fa-star"></label>
                    <input type="radio" value="4" name="rating" id="rating4">
                    <label for="rating4" class="fa fa-star"></label>
                    <input type="radio" value="5" name="rating" id="rating5">
                    <label for="rating5" class="fa fa-star"></label>

                    <button type="submit" class="btn btn-primary" style="float: right;">Add Rating</button>
                </div>
            </div>
        </form>
    </div>

    <hr>

    <div id="map">
        <center><iframe src="{{ $restaurants->map }}" width="100%" height="450" frameborder="0" style="border:0"
                allowfullscreen></iframe></center>
    </div>

    <br><br>

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

    {{-- Mutliple Image Slider JS --}}
    <script>
        var swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

    {{-- Img 360 View JS --}}
    <script>
        // 显示360度视图
        function show360Image(imageUrl) {
            document.getElementById('pannellumModal').style.display = 'block';
            pannellum.viewer('panorama', {
                type: 'equirectangular',
                panorama: imageUrl,
                autoLoad: true
            });
        }

        // 关闭360度视图
        function close360View() {
            document.getElementById('pannellumModal').style.display = 'none';
        }
    </script>

    {{-- Multiple image --}}
    {{-- <script>
        const imgs = document.querySelectorAll('.img-select a');
        const imgBtns = [...imgs];
        let imgId = 1;

        imgBtns.forEach((imgItem) => {
            imgItem.addEventListener('click', (event) => {
                event.preventDefault();
                imgId = imgItem.dataset.id;
                slideImage();
            });
        });

        function slideImage() {
            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        }

        window.addEventListener('resize', slideImage);
    </script> --}}

@endsection
