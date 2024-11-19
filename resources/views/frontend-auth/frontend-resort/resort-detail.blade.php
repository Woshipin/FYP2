@extends('frontend-auth.newlayout')

@section('frontend-section')

    {{-- Button CSS --}}
    <style>
        /* Style the WhatsApp icon */
        .btn-success {
            background-color: #25D366;
            padding: 12px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .btn-success i {
            font-size: 20px;
            color: white;
        }

        .btn-success:hover {
            background-color: #128C7E;
        }

        .btn-info {
            background-color: #FF0000;
            padding: 12px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .btn-info i {
            font-size: 20px;
            color: white;
        }

        .btn-info:hover {
            background-color: #E60000;
        }
    </style>

    {{-- Responsible UI CSS --}}
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
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
            height: 500px;
            max-width: 100%;
            margin: auto;
        }

        .img-display {
            width: 100%;
            height: 500px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .swiper {
            width: 100%;
            height: 500px;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%; /* 使用100%高度确保图片填充整个容器 */
            object-fit: contain; /* 使用 contain 确保图片完整显示 */
        }

        /* New style for image placeholder */
        .img-placeholder {
            width: 100%;
            height: 500px; /* 调整高度以适应页面 */
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: #666;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        /* Ensure images take full width of the container */
        .swiper-slide img {
            width: 100%;
            height: 100%; /* 使用100%高度确保图片填充整个容器 */
            object-fit: contain; /* 使用 contain 确保图片完整显示 */
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .product-imgs,
            .img-display,
            .swiper,
            .swiper-slide img,
            .img-placeholder {
                height: 300px; /* 调整高度以适应页面 */
            }
        }

        @media (max-width: 480px) {
            .product-imgs,
            .img-display,
            .swiper,
            .swiper-slide img,
            .img-placeholder {
                height: 200px; /* 调整高度以适应页面 */
            }
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

        .rating-css input+label {
            font-size: 60px;
            text-shadow: 1px 1px 0 #8f8420;
            cursor: pointer;
        }

        .rating-css input:checked+label~label {
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

            .rating-css input+label {
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

            .rating-css input+label {
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

    <style>
        /* 为了使全景图像填满容器 */
        .photosphere-container {
            width: 100%;
            height: 400px;
            /* 调整高度以适应你的需要 */
        }

        /* 左中右三列布局 */
        .columns {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .column {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .column:not(:last-child) {
            margin-right: 20px;
        }

        @media (max-width: 768px) {
            .columns {
                flex-direction: column;
            }

            .column:not(:last-child) {
                margin-right: 0;
                margin-bottom: 20px;
            }
        }
    </style>

    {{-- Img 360 View --}}
    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    {{-- Mutliple Image Silder CSS and JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    {{-- toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <br>

    <div class="container">
        <div class="card">
            {{-- Mutliple Image --}}
            <div class="product-imgs">
                <div class="img-display">
                    <div class="swiper img-showcase">
                        <div class="swiper-wrapper">
                            @if ($resort->images->isNotEmpty())
                                @foreach ($resort->images as $image)
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
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

            <div id="pannellumModal"
                style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000;">
                <div id="panorama" style="width: 100%; height: 100%;"></div>
                <button onclick="close360View()"
                    style="position: absolute; top: 10px; right: 10px; padding: 10px; background: #fff; border: none; cursor: pointer;">Close</button>
            </div>

            <div class="product-content">
                <h2 class="product-title">{{ $resort->name }}</h2>
                <a href="#" class="product-link">Visit Resort</a>

                <br><br>

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
                    <p class="last-price">Resort Type: {{ $resort->type }}/day</p>
                    <p class="last-price">Resort Price: RM{{ $resort->price }}/day</p>
                    <p class="new-price">Resort Phone Number: {{ $resort->phone }}</p>
                    <p class="new-price">Resort Contact Email: {{ $resort->email }}</p>
                </div>

                <hr>

                <div class="product-detail">
                    <h2>About this Resort address and description:</h2>
                    <h3 class="new-price">Resort Country: {{ $resort->country }}</h3>
                    <h3 class="new-price">Resort State: {{ $resort->state }}</h3>
                    <h3>Resort Address: {{ $resort->location }}</h3>
                    <h3>Resort Description: {{ $resort->description }}</h3>
                </div>

                <div class="purchase-info">
                    <a href="{{ url('bookingresort/' . $resort->id) }}" class="btn btn-primary"><i
                            class="fas fa-calendar-check"></i>&nbsp;Booking</a>
                    <a href="{{ route('resorts.comment', ['id' => $resort->id]) }}" class="btn btn-secondary"><i
                            class="fas fa-comment"></i>&nbsp;Comment</a>
                    <a href="https://wa.me/601110801649" target="_blank" class="btn-success"><i
                            class="fab fa-whatsapp"></i></a>
                    <a href="{{ route('resorts.contact', ['id' => $resort->id]) }}" class="btn-info"><i
                            class="far fa-envelope"></i></a>
                </div>
            </div>
        </div>

        <!-- 左中右三列布局 -->
        <div class="columns">
            <div class="column">
                <h3>Column 1</h3>
                <p>This is the content of the first column.</p>
            </div>
            <div class="column">
                <h3>Column 2</h3>
                <p>This is the content of the second column.</p>
            </div>
            <div class="column">
                <h3>Column 3</h3>
                <p>This is the content of the third column.</p>
            </div>
        </div

        <!--Add Resort Rating Modal -->
        <div class="add-rating-css">
            <form action="{{ route('resortratings') }}" method="POST">
                @csrf

                <input type="hidden" name="rateable_id" value="{{ $resort->id }}">
                <input type="hidden" name="rateable_name" value="{{ $resort->name }}">
                <input type="hidden" name="rateable_type" value="{{ $resort->type }}">

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
            <center><iframe src="{{ $resort->map }}" width="100%" height="450"></iframe></center>
        </div>

        <br><br>>
    </div>

    <!-- 引入 Photo Sphere Viewer 库 -->
    <script src="https://cdn.jsdelivr.net/npm/photo-sphere-viewer/dist/photo-sphere-viewer.min.js"></script>

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

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- New Toastr --}}
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
