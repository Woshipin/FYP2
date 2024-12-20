@extends('frontend-auth.newlayout')

@section('frontend-section')

    <!-- 引入 Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <!-- Community Detail CSS -->
    <style>
        h1 {
            color: #2c3e50;
        }

        .slider {
            position: relative;
            overflow: hidden;
            height: 400px;
            margin: 20px 0;
        }

        .slider-inner {
            display: flex;
            transition: transform 0.3s ease-in-out;
            height: 100%;
        }

        .slider-item {
            flex: 0 0 100%;
            height: 100%;
        }

        .slider-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 2px solid #000;
            /* Added black border */
        }

        .slider-nav {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .slider-nav-item {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #fff;
            opacity: 0.5;
            cursor: pointer;
        }

        .slider-nav-item.active {
            opacity: 1;
        }

        .community-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        .detail-item h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            .slider {
                height: 300px;
            }
        }
    </style>

    <div class="slider">
        <div class="slider-inner">
            @foreach ($community->multipleImages as $image)
                <div class="slider-item">
                    <img src="{{ $image->full_image_path }}" alt="Community Image">
                </div>
            @endforeach
        </div>
        <div class="slider-nav">
            @foreach ($community->multipleImages as $index => $image)
                <div class="slider-nav-item {{ $index == 0 ? 'active' : '' }}"></div>
            @endforeach
        </div>
    </div>

    <div class="community-details">
        <div class="detail-item">
            <h3>{{ $community->name }}</h3>
            <p>{{ $community->description }}</p>
        </div>
        <div class="detail-item">
            <h3>Cultural</h3>
            <p>{{ $community->cultural }}</p>
        </div>
        <div class="detail-item">
            <h3>Category</h3>
            <p>{{ $community->category }}</p>
        </div>
    </div>

    <br><br>

    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- 引入 Slick Slider JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script>
        jQuery(document).ready(function($) {
            $('.slider-inner').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                adaptiveHeight: true,
                autoplay: true,
                autoplaySpeed: 2000 // 2秒自动滑动一次
            });
        });
    </script>

@endsection
