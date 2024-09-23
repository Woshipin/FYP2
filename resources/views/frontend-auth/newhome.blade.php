@extends('frontend-auth.newlayout')

@section('frontend-section')

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- HotelStatus Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('66e2c17903cc96af1475', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('hotelstatus');
        channel.bind('hotel-status', function() {
            window.location.reload();
        });
    </script>

    {{-- Pusher Disabled CSS --}}
    <style>
        .disabled {
            opacity: 0.5;
            /* Reduce opacity to indicate disabled state */
            pointer-events: none;
            /* Disable pointer events */
            cursor: not-allowed;
            /* Change cursor to "not allowed" when hovering */
            color: #989595;
            /* Change text color to indicate disabled state */
        }
    </style>

    {{-- New Card --}}
    <link rel="stylesheet" href="{{ asset('new/card/card.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('new-card-ui/assets/css/style.css') }}"> --}}

    {{-- New Card Ui With Slider --}}
    <style>
        .btn {
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 1rem;
            margin: 10px;
            background: var(--orange);
            color: #fff;
            padding: .8rem 3rem;
            border: .2rem solid var(--orange);
            cursor: pointer;
            font-size: 1.7rem;
        }

        .btn:hover {
            background: rgba(255, 165, 0, .2);
            color: black;
        }

        hr {
            border: none;
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .pin {
            /* background: #292a46; */
            background: black;
        }

        .review {
            background: black;
        }

        .box {
            background: white;
        }

        #wishlist {
            font-size: 20px;
            color: red;
            margin-right: 10px;
        }

        #wishlist:hover {
            color: rgb(255, 183, 0);
        }

        #price {
            color: #000;
            font-size: 150%;
            font-weight: bold;
        }

        #closed {
            border-radius: 8px;
            color: black;
            background-color: silver;
            padding: 5px 10px;
            font-size: 14px;
        }

        .swiper-slide.slide {
            border-radius: 10px;
            padding: 10px;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            height: 500px;
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .swiper-slide.slide:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.2);
            background-color: #f0f0f0;
        }

        .room .swiper-wrapper {
            display: flex;
            flex-direction: row;
        }

        .room .swiper-slide {
            flex: 0 0 auto;
        }

        .room .slide:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.2);
            background-color: #e0f7fa;
        }

        .room .image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .room .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .room .image img:hover {
            transform: scale(1.1);
        }

        .room .content {
            flex: 0 0 auto;
            height: 200px;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: left;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .room .content p {
            font-size: 14px;
            color: #333;
            margin: 0 0 5px 0;
            line-height: 1.2;
            text-align: left;
        }

        .room .content p#www {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }

        .room .stars {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .room .stars i {
            font-size: 16px;
            color: gold;
        }

        .room .concert-info {
            height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left;
        }

        .concert-action-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .concert-action-container .actions {
            display: flex;
            align-items: center;
        }

        .concert-action-container form {
            margin-right: 10px;
        }

        .btn {
            padding: 5px 10px;
            font-size: 14px;
        }

        @media screen and (min-width: 768px) {
            .room .slide {
                flex: 0 0 300px;
                margin: 0.6rem;
            }

            .room .image {
                height: 200px;
            }

            .room .content {
                padding: 15px;
            }

            .room .content h3 {
                font-size: 18px;
            }

            .room .content p {
                font-size: 14px;
            }

            .room .content .stars i {
                font-size: 16px;
            }
        }
    </style>

    {{-- New Gallery Ui With Slider --}}
    <style>
        body {
            color: #333;
            /* 主要文本颜色 */
            background-color: #fff;
            /* 背景颜色 */
        }

        .swiper-pagination {
            display: none;
        }

        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap");

        :root {
            --primary: #ec994b;
            --white: #ffffff;
            --bg: #f5f5f5;
        }

        html {
            font-size: 62.5%;
            font-family: "Montserrat", sans-serif;
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 1.3rem;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 1rem;
            background: #797979;
            transition: all 0.5s ease-in-out;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #222224;
        }

        ::-webkit-scrollbar-track {
            background: #f9f9f9;
        }

        body {
            font-size: 1.6rem;
            background: var(--bg);
        }

        .container {
            max-width: 124rem;
            padding: 0 1rem;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        .section-heading {
            font-size: 3rem;
            color: var(--primary);
            padding: 2rem 0;
        }

        #tranding {
            padding: 4rem 0;
        }

        @media (max-width:1440px) {
            #tranding {
                padding: 7rem 0;
            }
        }

        #tranding .tranding-slider {
            height: 52rem;
            padding: 2rem 0;
            position: relative;
        }

        @media (max-width:500px) {
            #tranding .tranding-slider {
                height: 45rem;
            }
        }

        .tranding-slide {
            width: 37rem;
            height: 42rem;
            position: relative;
        }

        @media (max-width:500px) {
            .tranding-slide {
                width: 28rem !important;
                height: 36rem !important;
            }

            .tranding-slide .tranding-slide-img img {
                width: 28rem !important;
                height: 36rem !important;
            }
        }

        .tranding-slide .tranding-slide-img img {
            width: 37rem;
            height: 42rem;
            border-radius: 2rem;
            object-fit: cover;
        }

        .tranding-slide .tranding-slide-content {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
        }

        .tranding-slide-content .food-price {
            position: absolute;
            top: 2rem;
            right: 2rem;
            color: var(--white);
        }

        .tranding-slide-content .tranding-slide-content-bottom {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            color: var(--white);
        }

        .food-rating {
            padding-top: 1rem;
            display: flex;
            gap: 1rem;
        }

        .rating ion-icon {
            color: var(--primary);
        }

        .swiper-slide-shadow-left,
        .swiper-slide-shadow-right {
            display: none;
        }

        .tranding-slider-control {
            position: relative;
            bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tranding-slider-control .swiper-button-next {
            left: 58% !important;
            transform: translateX(-58%) !important;
        }

        @media (max-width:990px) {
            .tranding-slider-control .swiper-button-next {
                left: 70% !important;
                transform: translateX(-70%) !important;
            }
        }

        @media (max-width:450px) {
            .tranding-slider-control .swiper-button-next {
                left: 80% !important;
                transform: translateX(-80%) !important;
            }
        }

        @media (max-width:990px) {
            .tranding-slider-control .swiper-button-prev {
                left: 30% !important;
                transform: translateX(-30%) !important;
            }
        }

        @media (max-width:450px) {
            .tranding-slider-control .swiper-button-prev {
                left: 20% !important;
                transform: translateX(-20%) !important;
            }
        }

        .tranding-slider-control .slider-arrow {
            background: var(--white);
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            left: 42%;
            transform: translateX(-42%);
            filter: drop-shadow(0px 8px 24px rgba(18, 28, 53, 0.1));
        }

        .tranding-slider-control .slider-arrow ion-icon {
            font-size: 2rem;
            color: #222224;
        }

        .tranding-slider-control .slider-arrow::after {
            content: '';
        }

        .tranding-slider-control .swiper-pagination {
            position: relative;
            width: 15rem;
            bottom: 1rem;
        }

        .tranding-slider-control .swiper-pagination .swiper-pagination-bullet {
            filter: drop-shadow(0px 8px 24px rgba(18, 28, 53, 0.1));
        }

        .tranding-slider-control .swiper-pagination .swiper-pagination-bullet-active {
            background: var(--primary);
        }
    </style>

    {{-- About CSS --}}
    <style>
        /* .about {
                                                                                        background-image: linear-gradient(#1f83c9, #b6dfd4, #1957ad);
                                                                                        padding: 20px;
                                                                                    } */

        .about .row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 3rem;
            /* 减小间距以适应较小屏幕 */
        }

        .about .row .image {
            flex: 1 1 100%;
            /* 将图片部分占据整行 */
            max-width: 100%;
            /* 图片宽度最大不超过容器宽度 */
        }

        .about .row .image img {
            width: 100%;
            height: auto;
            /* 图片高度自适应 */
        }

        .about .row .content {
            flex: 1 1 100%;
            /* 将内容部分占据整行 */
            max-width: 100%;
            /* 内容宽度最大不超过容器宽度 */
            margin-top: 2rem;
            /* 添加一些顶部间距 */
        }

        .about .row .content h3 {
            font-size: 2.5rem;
            /* 减小标题字体大小 */
            padding: 1.5rem 0;
            /* 减小标题上下内边距 */
        }

        .about .row .content p {
            font-size: 1.4rem;
            /* 减小段落字体大小 */
            padding: 1rem 0;
            /* 减小段落上下内边距 */
            line-height: 1.6;
            /* 调整行高 */
            color: black;
        }

        /* 媒体查询：调整样式以适应不同屏幕尺寸 */
        @media screen and (min-width: 768px) {
            .about .row {
                gap: 6rem;
                /* 恢复大屏幕下的间距 */
            }

            .about .row .image {
                flex: 1 1 30rem;
            }

            .about .row .content {
                flex: 1 1 51rem;
            }

            .about .row .content h3 {
                font-size: 3.5rem;
                padding: 2rem 0;
            }

            .about .row .content p {
                font-size: 1.6rem;
                padding: 1rem 0;
                line-height: 1.8;
            }
        }
    </style>

    {{-- Star Rating CSS --}}
    <style>
        .fa-star-outline {
            color: gold;
            font-size: 20px;
            position: relative;
        }

        .fa-star-outline::before {
            content: '\f005';
            /* Unicode for filled star */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: black;
            /* Border color */
            position: absolute;
            left: 0;
            top: 0;
            -webkit-text-stroke: 1px black;
            /* Creates border */
            z-index: -1;
            /* Places the border behind the star */
        }
    </style>

    {{-- AI Chat Bot CSS --}}
    <style>
        *,
        html {
            --primaryGradient: linear-gradient(93.12deg, #581B98 0.52%, #9C1DE7 100%);
            --secondaryGradient: linear-gradient(268.91deg, #581B98 -2.14%, #9C1DE7 99.69%);
            --primaryBoxShadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            --secondaryBoxShadow: 0px -10px 15px rgba(0, 0, 0, 0.1);
            --light: 300;
            --regular: 400;
            --semiBold: 600;
            --extraLight: 300;
            --italic: 300;
            --primary: #581B98;
            --botResponse: #00FFFF;
            --visitorMessage: #581B98;
            --visitorTextColor: #FFFFFF;
        }

        .chatbox__support {
            background: #f9f9f9;
            height: 600px;
            width: 500px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            position: fixed;
            bottom: 90px;
            right: 30px;
            display: none;
            z-index: 9999;
            flex-direction: column;
        }

        .chatbox--active {
            display: flex;
        }

        .chatbox__header {
            background: var(--primaryGradient);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: var(--primaryBoxShadow);
        }

        .chatbox__image--header {
            margin-right: 0px;
        }

        .chatbox__heading--header {
            font-size: 1.2rem;
            color: white;
        }

        .chatbox__description--header {
            font-size: .9rem;
            color: white;
        }

        .chatbox__messages {
            padding: 20px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .messages__item {
            margin-top: 10px;
            padding: 8px 12px;
            max-width: 70%;
            border-radius: 20px;
            word-wrap: break-word;
        }

        .messages__item--visitor {
            align-self: flex-end;
            background: var(--visitorMessage);
            color: var(--visitorTextColor);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .messages__item--operator {
            align-self: flex-start;
            background: var(--botResponse);
            color: black;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .chatbox__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            background: #f9f9f9;
            box-shadow: var(--secondaryBoxShadow);
        }

        .chatbox__footer img {
            width: 24px;
            height: 24px;
            margin: 0 10px;
            cursor: pointer;
        }

        .chatbox__footer input {
            flex-grow: 1;
            border: none;
            padding: 10px;
            border-radius: 30px;
            margin-right: 10px;
        }

        .chatbox__send--footer {
            color: white;
            background: #581B98;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
        }

        .chatbox__button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 10000;
        }

        .chatbox__button button {
            padding: 10px;
            background: white;
            border: none;
            outline: none;
            border-radius: 50%;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
    </style>

    {{-- More CSS --}}
    <style>
        /* =========== Discount ============ */
        .discount {
            position: relative;
            height: 60rem;
        }

        .discount .overlay {
            position: relative;
            height: 100%;
        }

        .discount .overlay::after {
            content: "";
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            background: var(--text-1);
            opacity: 0.5;
        }

        .discount video {
            object-fit: cover;
        }

        .discount .content {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            text-align: center;
        }

        .discount .content h1 {
            font-size: 5rem;
            color: var(--white);
            margin-bottom: 3rem;
        }

        .discount .content span {
            justify-content: center;
            border: 2px solid var(--white);
            border-radius: 50%;
            color: var(--white);
            font-size: 4rem;
            width: 7rem;
            height: 7rem;
            margin: 0 auto;
            cursor: pointer;
            margin-top: 3rem;
        }

        @media (max-width: 567px) {
            .discount {
                height: 50rem;
            }

            .discount .content {
                top: 50%;
                width: 100%;
            }

            .discount .content h1 {
                font-size: 3.5rem;
            }

            .discount .content .btn {
                padding: 1rem;
            }

            .discount .content span {
                font-size: 3rem;
                width: 5rem;
                height: 5rem;
            }
        }

        /* =========== Trip ============ */
        .trip {
            overflow: hidden;
        }

        .trip .title {
            text-align: center;
            margin-bottom: 7rem;
        }

        .trip .title h1 {
            font-size: 5rem;
            margin: 2rem;
        }

        .trip .title p {
            width: 50%;
            margin: 0 auto;
        }

        .trip .row {
            width: 95vw;
            position: relative;
        }

        .trip .swiper-container {
            width: 100%;
            height: 100%;
        }

        .trip .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 300px;
            height: 500px;
        }

        .trip .swiper-slide img {
            display: block;
            width: 100%;
        }

        .custom-next,
        .custom-prev {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--primary);
            color: var(--white);
            font-size: 2.5rem;
            border-radius: 50%;
            height: 4rem;
            width: 4rem;
            justify-content: center;
            cursor: pointer;
        }

        .custom-next {
            right: -60px;
        }

        .custom-prev {
            left: -60px;
        }

        .custom-pagination {
            position: absolute;
            bottom: -10%;
            left: 50%;
            transform: translateX(-50%);
        }

        .swiper-pagination-bullet {
            width: 30px;
            height: 7px;
            border-radius: 5px;
        }

        .swiper-pagination-bullet-active {
            background-color: var(--primary);
        }

        .swiper-pagination-bullet:not(:last-child) {
            margin-right: 10px;
        }

        .trip .explore {
            text-align: center;
            margin-top: 8rem;
        }

        @media (max-width: 1200px) {

            .custom-next,
            .custom-prev {
                top: -15%;
                transform: translateY(0%);
            }

            .custom-next {
                right: 10px;
            }

            .custom-prev {
                left: auto;
                right: 70px;
            }
        }

        @media (max-width: 768px) {
            .trip .title p {
                width: 90%;
            }

            .trip .swiper-slide {
                height: 400px;
            }
        }

        @media (max-width: 768px) {
            .trip .title h1 {
                font-size: 4rem;
            }
        }

        /* =========== More ============ */
        .travel-section .travel-title {
            margin-bottom: 5rem;
        }

        .travel-section .travel-title p {
            margin-top: 2rem;
        }

        .travel-section .travel-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
        }

        .travel-section .travel-tours {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 9rem;
        }

        .travel-section .travel-content .travel-btn {
            display: block;
            text-align: center;
            background-color: #ffcc00;
            /* 根据图二中的按钮颜色 */
            color: #000;
            /* 按钮文字颜色 */
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .travel-section .travel-tours h3 {
            margin: 1rem 0;
        }

        .travel-section img {
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .travel-section .travel-container {
                grid-template-columns: 1fr;
            }
        }

        /* =========== Contact ============ */
        /* 独立的 newsletter 样式，确保不影响其他样式 */
        .newsletter-section {
            background-color: #1b2a41;
            /* 深蓝色 */
            height: 30rem;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .newsletter-container {
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 5rem;
        }

        .newsletter-content h2,
        .newsletter-content p {
            color: #ffffff;
            /* 白色 */
        }

        .newsletter-content h2 {
            margin-bottom: 2rem;
            font-size: 3rem;
        }

        .newsletter-form {
            display: flex;
            justify-content: flex-end;
        }

        .newsletter-input-group {
            position: relative;
            width: 90%;
        }

        .newsletter-input-group input {
            width: 100%;
            outline: none;
            border: none;
            padding: 1.5rem 0;
            text-indent: 1rem;
            font-size: 1.7rem;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .newsletter-input-group button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 1rem;
            outline: none;
            border: none;
            background-color: #1b2a41;
            color: #ffffff;
            padding: 0.8rem 3rem;
            font-size: 1.7rem;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
        }

        @media (max-width: 767px) {
            .newsletter-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .newsletter-form {
                justify-content: center;
            }
        }

        @media (max-width: 567px) {
            .newsletter-section {
                height: 40rem;
                padding-bottom: 10rem;
            }
        }

        /* =========== Contact Us ============ */
        .contact .title {
            text-align: center;
            margin-bottom: 5rem;
        }

        .contact .title p {
            width: 60%;
            margin: 2rem auto 0;
        }

        .location {
            height: 500px;
        }

        .location iframe {
            width: 100%;
            height: 100%;
        }

        @media (max-width: 567px) {
            .contact .title p {
                width: 90%;
            }

            .location {
                height: 350px;
            }
        }

        /* =========== Preloader ============ */

        .loader {
            position: fixed;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999999;
            background-color: var(--white);
        }

        .loader img {
            width: 20rem;
            height: 20rem;
        }

        img,
        video {
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- 3D Card CSS -->
    <style>
        .card-3D {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 50px;
            background-color: black;
        }

        .box-3D {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            width: 150px;
            height: 200px;
            transform-style: preserve-3d;
            animation: animate 20s linear infinite;
            margin-top: 20px;
            /* Add space between the heading and the 3D box */
        }

        .box-3D:hover {
            animation-play-state: paused;
        }

        @keyframes animate {
            0% {
                transform: perspective(1000px) rotateY(0deg);
            }

            100% {
                transform: perspective(1000px) rotateY(360deg);
            }
        }

        .box-3D span {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform-origin: center;
            transform-style: preserve-3d;
            transform: rotateY(calc(var(--i) * 36deg)) translateZ(450px);
            -webkit-box-reflect: below 2px linear-gradient(transparent, transparent, rgba(4, 4, 4, 0.267));
        }

        .box-3D span img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: 0.5s;
            border-radius: 15px;
            border: 4px double rgb(0, 0, 0);
        }

        img:hover {
            transform: translateY(-2px);
        }

        .heading {
            display: flex;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
            /* Add space between the heading and the 3D box */
        }

        .heading span {
            /* margin-bottom: 100px; */
            margin: 50px 5px;
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .box-3D {
                max-width: 300px;
                height: 180px;
            }

            .box-3D span {
                transform: rotateY(calc(var(--i) * 36deg)) translateZ(100px);
            }
        }

        @media (max-width: 480px) {
            .heading {
                font-size: 1.5rem;
            }

            .box-3D {
                max-width: 200px;
                height: 150px;
            }

            .box-3D span {
                transform: rotateY(calc(var(--i) * 36deg)) translateZ(75px);
            }
        }
    </style>

    {{-- Home Text CSS --}}
    <style>
        .awaits {
            color: white;
            font-size: 20px;
        }
    </style>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- ------------------------------------------------------- CSS Area End ------------------------------------------------------ --}}

    {{-- AI Chat Bot --}}
    <div class="container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="chatbot/images/image.png" alt="image">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">Chat support</h4>
                        <p class="chatbox__description--header">Ask us anything about our services</p>
                    </div>
                </div>
                <div class="chatbox__messages" id="content-box"></div>
                <div class="chatbox__footer">
                    <input type="text" id="chat-input" placeholder="Write a message...">
                    <p class="chatbox__send--footer" onclick="sendMessage()">Send</p>
                </div>
            </div>
            <div class="chatbox__button">
                <button>
                    <img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">
                </button>
            </div>
        </div>
    </div>

    {{-- <div class="container">
        <div class="chatbox">
            <div class="chatbox__support">
                <div class="chatbox__header">
                    <div class="chatbox__image--header">
                        <img src="chatbot/images/image.png" alt="image">
                    </div>
                    <div class="chatbox__content--header">
                        <h4 class="chatbox__heading--header">Chat support</h4>
                        <p class="chatbox__description--header">Ask us anything about our services</p>
                    </div>
                </div>
                <div class="chatbox__messages" id="content-box"></div>
                <div class="chatbox__footer">
                    <input type="text" id="chat-input" placeholder="Write a message...">
                    <p class="chatbox__send--footer" onclick="sendMessage()">Send</p>
                </div>
            </div>
            <div class="chatbox__button">
                <button>
                    <img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">
                </button>
            </div>
        </div>
    </div> --}}

    {{-- Scroll Reveal effect  --}}
    <!-- Home Section Starts -->
    <section class="home" id="home">

        <div class="content">
            <h3>Welcome to A global icon of luxury</h3>
            <p class="awaits">Discover new places with us, luxury awaits</p>
            <a href="{{ url('/') }}" class="btn">Discover More</a>
        </div>

        <div class="controls">
            <span class="vid-btn active" data-src="{{ asset('new/img/vid-1.mp4') }}"></span>
            <span class="vid-btn" data-src="{{ asset('new/img/vid-2.mp4') }}"></span>
            <span class="vid-btn" data-src="{{ asset('new/img/vid-3.mp4') }}"></span>
            <span class="vid-btn" data-src="{{ asset('new/img/vid-4.mp4') }}"></span>
            <span class="vid-btn" data-src="{{ asset('new/img/vid-5.mp4') }}"></span>
        </div>

        <div class="video-container">
            <video src="{{ asset('new/img/vid-1.mp4') }}" id="video-slider" loop autoplay muted></video>
        </div>

    </section>
    <!-- Home Section Ends -->

    <!-- About Section Starts-->
    <section class="about" id="about">
        <div class="row">
            <div class="image" data-sr>
                <img src="{{ asset('new-card-ui/images/about.jpg') }}" alt="">
            </div>
            <div class="content" data-sr>
                <h3>About Us</h3>
                <p>Welcome to SUC Travel Website, your premier platform for finding and booking the perfect getaway. Whether
                    you're searching for a cozy resort, a luxurious hotel, or a delightful restaurant, our system provides
                    you with a seamless experience from registration to booking.</p>
                <p>At SUC Travel Website, we empower users to not only discover the best accommodations and dining options
                    but also to take control of their experiences. With an easy-to-use dashboard, users can register and
                    manage their own resorts, hotels, and restaurants, making it simple to share their unique offerings with
                    the world.</p>
                <p>Whether you are planning a weekend escape or a special dining experience, SUC Travel Website connects you
                    with a wide range of options to suit your needs. Our mission is to make booking and managing
                    accommodations and restaurants as effortless and enjoyable as possible.</p>
            </div>
        </div>
    </section>
    <!-- About Section Ends-->

    <!-- Card Section Starts -->
    <div class="pin">

        <section class="breadcumb-area bg-img bg-overlay"
            style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;" data-sr>
            <div class="bradcumbContent">
                <h2>Recommendation</h2>
            </div>
        </section>

        <!-- 判断用户是否已登录，已登录则显示推荐内容 -->
        @auth
            <section class="room" id="room" data-sr>
                <div class="swiper room-slider">
                    <div class="swiper-wrapper">
                        @if ($recommendations)
                            @foreach ($recommendations as $recommendation)
                                <div class="swiper-slide slide"
                                    id="{{ $recommendation['place_type'] }}_card_{{ $recommendation['place_id'] }}">
                                    <div class="image">
                                        @if (!empty($recommendation['place_price']))
                                            <span class="price">${{ $recommendation['place_price'] }}</span>
                                        @endif
                                        <img src="{{ asset('images/' . $recommendation['image']) }}"
                                            alt="{{ $recommendation['place_type'] }}">
                                    </div>
                                    <div class="content"><br>
                                        <p id="www">Name: {{ $recommendation['place_name'] }}</p>
                                        <p id="www">Type: {{ $recommendation['place_type'] }}</p>
                                        <p id="www">Recommendation Score: {{ $recommendation['recommendation_score'] }}
                                        </p>
                                        <p id="www">Description: {{ $recommendation['description'] }}</p>
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $recommendation['averageRating'])
                                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                                @elseif ($i - 0.5 <= $recommendation['averageRating'])
                                                    <i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>
                                                @else
                                                    <i class="far fa-star" style="font-size: 20px; color: black;"></i>
                                                @endif
                                            @endfor
                                            <span>({{ number_format($recommendation['averageRating'], 1) }})</span>
                                        </div>
                                        <div class='concert-info'>
                                            @if ($recommendation['status'] == 0)
                                                <div class="concert-action-container">
                                                    <a href="{{ url($recommendation['url']) }}" class="btn">Book Now</a>
                                                </div>
                                            @else
                                                <a href="#" class="btn" class="concert-action">Closed</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="show" style="margin-top:40px; font-size:24px; display:block; color:white;">No
                                Recommendations Found</p>
                        @endif
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </section>
        @endauth

        <!-- 未登录用户显示的内容 -->
        @guest
            <section class="room" id="room" data-sr>
                <div class="swiper room-slider">
                    <div class="swiper-wrapper">
                        <p style="margin-top:40px; font-size:24px; display:block">Please log in to view recommendations</p>
                    </div>
                </div>
            </section>
        @endguest

        {{-- Scroll Reveal effect  --}}
        {{-- New Resort Card UI --}}
        <section class="breadcumb-area bg-img bg-overlay"
            style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;" data-sr>
            <div class="bradcumbContent">
                <h2>Resort</h2>
            </div>
        </section>

        <section class="room" id="resort-room" data-sr>
            <div class="swiper room-slider">
                <div class="swiper-wrapper" data-sr="slide-up">
                    @if ($resorts->where('register_status', 1)->count() > 0)
                        @foreach ($resorts->where('register_status', 1) as $resort)
                            <div class="swiper-slide slide" id="resortcard_{{ $resort->id }}">

                                <span class="price" id="price">${{ $resort->price }}</span>

                                <div class="image"
                                    style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                    @if ($resort->images->count() > 0)
                                        <img src="{{ asset('images/' . $resort->images->first()->image) }}"
                                            class="d-block w-100" alt="Resort Image"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="color: #777;">No Image</span>
                                    @endif
                                </div>

                                <div class="content">
                                    <p id="www">{{ $resort->name }}</p>
                                    <p id="www">{{ $resort->description }}</p>
                                    <div class="stars">
                                        @if (isset($resortRatings[$resort->id]['averageRating']) && $resortRatings[$resort->id]['averageRating'] > 0)
                                            @php $averageRating = $resortRatings[$resort->id]['averageRating']; @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $averageRating)
                                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                                @elseif ($i - 0.5 <= $averageRating)
                                                    <i class="fas fa-star-half-alt"
                                                        style="color: gold; font-size: 20px;"></i>
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
                                </div>

                                <div class="concert-info">
                                    @if ($resort->status == 0)
                                        <div class="concert-action-container">
                                            <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}
                                            </p>
                                            <div class="actions">
                                                <form id="wishlistForm"
                                                    action="{{ url('/wishlist/add/resort') }}/{{ $resort->id }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" id="wishlist" class="concert-action"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ url('Resortdetail/' . $resort->id) . '/view' }}"
                                                    class="btn" id="viewresort{{ $resort->id }}">Book Now</a>
                                            </div>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed"
                                            class="concert-action">Closed</a>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    @else
                        <p style="margin-top:40px; font-size:24px; display:block; color:white;">No Resort Found</p>
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <hr>

        {{-- New Hotel Card UI --}}
        <section class="breadcumb-area bg-img bg-overlay"
            style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;" data-sr>
            <div class="bradcumbContent">
                <h2>Hotel</h2>
            </div>
        </section>

        <section class="room" id="hotel-room" data-sr>
            <div class="swiper room-slider">
                <div class="swiper-wrapper" data-sr="slide-up">
                    <!-- Add data-sr="slide-up" to trigger Scroll Reveal effect on the whole swiper-wrapper -->
                    @if ($hotels->where('register_status', 1)->count() > 0)
                        @foreach ($hotels->where('register_status', 1) as $hotel)
                            <div class="swiper-slide slide" id="hotelcard_{{ $hotel->id }}">

                                <div class="image"
                                    style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                    @if ($hotel->images->count() > 0)
                                        <img src="{{ asset('images/' . $hotel->images->first()->image) }}"
                                            class="d-block w-100" alt="Hotel Image"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="color: #777;">No Image</span>
                                    @endif
                                </div>

                                <div class="content">
                                    <p id="www">{{ $hotel->name }}</p>
                                    <p id="www">{{ $hotel->description }}</p>

                                    <div class="stars">
                                        @if (isset($hotelRatings[$hotel->id]['averageRating']) && $hotelRatings[$hotel->id]['averageRating'] > 0)
                                            @php $averageRating = $hotelRatings[$hotel->id]['averageRating']; @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $averageRating)
                                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                                @elseif ($i - 0.5 <= $averageRating)
                                                    <i class="fas fa-star-half-alt"
                                                        style="color: gold; font-size: 20px;"></i>
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
                                </div>

                                <div class='concert-info'>
                                    @if ($hotel->status == 0)
                                        <div class="concert-action-container">
                                            <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}
                                            </p>
                                            <div class="actions">
                                                <form id="wishlistForm"
                                                    action="{{ url('/wishlist/add/hotel') }}/{{ $hotel->id }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" id="wishlist" class="concert-action"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ url('Hoteldetail/' . $hotel->id) . '/view' }}" class="btn"
                                                    id="viewhotel{{ $hotel->id }}">Book Now</a>
                                            </div>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed">Closed</a>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    @else
                        <p style="margin-top:40px; font-size:24px; display:block; color:white;">No Hotel Found</p>
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <hr>

        {{-- New Restaurant Card UI --}}
        <section class="breadcumb-area bg-img bg-overlay"
            style="background-image: url(img/bg-img/breadcumb3.jpg); height: 200px;" data-sr>
            <div class="bradcumbContent">
                <h2>Restaurant</h2>
            </div>
        </section>

        <section class="room" id="restaurant-room" data-sr>
            <div class="swiper room-slider">
                <div class="swiper-wrapper" data-sr="slide-up">
                    <!-- Add data-sr="slide-up" to trigger Scroll Reveal effect on the whole swiper-wrapper -->
                    @if ($restaurants->where('register_status', 1)->count() > 0)
                        @foreach ($restaurants->where('register_status', 1) as $restaurant)
                            <div class="swiper-slide slide" id="restaurantcard_{{ $restaurant->id }}">

                                <div class="image"
                                    style="width: 100%; height: 250px; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; background-color: #f9f9f9;">
                                    @if ($restaurant->images->count() > 0)
                                        <img src="{{ asset('images/' . $restaurant->images->first()->image) }}"
                                            class="d-block w-100" alt="Restaurant Image"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <span style="color: #777;">No Image</span>
                                    @endif
                                </div>

                                <div class="content">
                                    <p id="www">{{ $restaurant->name }}</p>
                                    <p id="www">{{ $restaurant->description }}</p>

                                    <div class="stars">
                                        @if (isset($restaurantRatings[$restaurant->id]['averageRating']) &&
                                                $restaurantRatings[$restaurant->id]['averageRating'] > 0)
                                            @php $averageRating = $restaurantRatings[$restaurant->id]['averageRating']; @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $averageRating)
                                                    <i class="fas fa-star" style="color: gold; font-size: 20px;"></i>
                                                @elseif ($i - 0.5 <= $averageRating)
                                                    <i class="fas fa-star-half-alt"
                                                        style="color: gold; font-size: 20px;"></i>
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
                                </div>

                                <div class='concert-info'>
                                    @if ($restaurant->status == 0)
                                        <div class="concert-action-container">
                                            <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}
                                            </p>
                                            <div class="actions">
                                                <form id="wishlistForm"
                                                    action="{{ url('/wishlist/add/restaurant') }}/{{ $restaurant->id }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" id="wishlist" class="concert-action"
                                                        style="background: none; border: none; cursor: pointer;">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ url('Restaurantdetail/' . $restaurant->id) . '/view' }}"
                                                    class="btn" id="viewrestaurant{{ $restaurant->id }}">Book Now</a>
                                            </div>
                                        </div>
                                    @else
                                        <p>{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('D, M d, Y h:i A') }}</p>
                                        <a href="#" class="btn" id="closed">Closed</a>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    @else
                        <p style="margin-top:40px; font-size:24px; display:block; color:white;">No Restaurant Found</p>
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

    </div>
    <!-- Card Section Ends -->

    <!-- discount Section Starts-->
    <section class="section discount" data-sr>
        <div class="overlay">
            <video class="video">
                <source src="{{ asset('morehome/images/hero-2.m4v') }}" type="video/mp4" />
                <source src="{{ asset('morehome/images/hero-2.webm') }}" type="video/webm" />
            </video>
        </div>
        <div class="content">
            <h1 id="travel">
                Get 15% Off On Tour <br />
                Next Travel
            </h1>
            <a href="#" id="travel" class="btn">Explore the Tour</a>
            <span class="video-control d-flex"><i class="bx bx-play"></i></span>
        </div>
    </section>
    <!-- discount Section Ends-->

    <!-- Review Section Starts -->
    <section class="review" id="review">
        <h1 class="heading" data-sr="slide-up">
            <span>R</span>
            <span>e</span>
            <span>v</span>
            <span>i</span>
            <span>e</span>
            <span>w</span>
        </h1>

        <div class="revswiper-container">
            <div class="swiper-wrapper review-slider">
                @foreach ($comments as $comment)
                    <div class="swiper-slide">
                        <div class="box">
                            <img src="{{ asset('new/img/p-1.jpg') }}" alt="">
                            <h3 style="color: black">{{ $comment->name }}</h3>
                            <p style="color: black">{{ $comment->comment }}</p>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Review Section Ends -->

    <!-- More Section Starts-->
    <section class="travel-section" data-sr>
        <div class="travel-container">
            <div class="travel-content">
                <div class="travel-title">
                    <h1>
                        More Places for <br />
                        Your Next Travel
                    </h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Consequatur enim iste autem laboriosam distinctio!
                        Reprehenderit.
                    </p>
                </div>
                <div class="travel-tours">
                    <div class="box">
                        <img src="{{ asset('morehome/images/pic-2.jpg') }}" alt="" />
                        <h3>Visit to Bali</h3>
                        <h4>$6000</h4>
                    </div>
                    <div class="box">
                        <img src="{{ asset('morehome/images/pic-3.jpg') }}" alt="" />
                        <h3>Visit to Russia</h3>
                        <h4>$8000</h4>
                    </div>
                </div>
                {{-- <a href="#" class="travel-btn">Explore more tours now</a> --}}
            </div>
            <div class="travel-image">
                <img src="{{ asset('morehome/images/pic-4.jpg') }}" class="image-travel" alt="Beach" />
            </div>
        </div>
    </section>
    <!-- More Section Ends-->

    <!-- 3D Section Starts -->
    <section class="card-3D" id="card-3D">
        <h1 class="heading">
            <span>L</span>
            <span>a</span>
            <span>n</span>
            <span>d</span>
            <span class="space"></span>
            <span>S</span>
            <span>c</span>
            <span>a</span>
            <span>p</span>
        </h1>

        <div class="box-3D">
            <span style="--i:1"><img src="{{ asset('3D-Card/images/pic-1.jpg') }}"></span>
            <span style="--i:2"><img src="{{ asset('3D-Card/images/pic-2.jpg') }}"></span>
            <span style="--i:3"><img src="{{ asset('3D-Card/images/pic-3.jpg') }}"></span>
            <span style="--i:4"><img src="{{ asset('3D-Card/images/pic-4.jpg') }}"></span>
            <span style="--i:5"><img src="{{ asset('3D-Card/images/pic-5.jpg') }}"></span>
            <span style="--i:6"><img src="{{ asset('3D-Card/images/pic-6.jpg') }}"></span>
            <span style="--i:7"><img src="{{ asset('3D-Card/images/vert-1.jpg') }}"></span>
            <span style="--i:8"><img src="{{ asset('3D-Card/images/vert-2.jpg') }}"></span>
            <span style="--i:9"><img src="{{ asset('3D-Card/images/vert-3.jpg') }}"></span>
            <span style="--i:10"><img src="{{ asset('3D-Card/images/vert-4.jpg') }}"></span>
        </div>

    </section>
    <!-- 3D Section Ends -->

    <!-- Contact Section Starts-->
    <section class="section contact" id="contact" data-sr>
        <div class="title">
            <h1>Our Location</h1>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                quaerat repellendus quae laudantium porro sunt consequatur eaque
                fugiat expedita provident.
            </p>
        </div>

        <div class="location container" data-no-sr>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.389126124463!2d103.67928727472494!3d1.5336266984520133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da73c109632e0b%3A0x74cda51bf210c304!2z5Y2X5pa55aSn5a2m5a2m6Zmi!5e0!3m2!1szh-CN!2smy!4v1716961611004!5m2!1szh-CN!2smy"
                width="600" height="550" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>
    <!-- Contact Section Ends-->

    {{-- --------------------------------------------------JS Area------------------------------------------------------------ --}}
    {{-- More Home UI Slider JS --}}
    <script src="https://unpkg.com/scrollreveal"></script>
    {{-- More Scroll Reveal Effect --}}
    <script>
        // Initialize ScrollReveal for sections with [data-sr]
        ScrollReveal().reveal('[data-sr]', {
            duration: 1000,
            distance: '50px',
            easing: 'ease-in-out',
            origin: 'bottom',
            reset: true // if you want animations to re-occur on scroll
        });

        // Initialize ScrollReveal for sections without [data-sr]
        ScrollReveal().reveal('[data-no-sr]', {
            duration: 0, // Set duration to 0 for sections without scroll reveal effect
            reset: true // Reset to reveal only once
        });
    </script>

    <!-- Scroll REveal Effect JS -->
    <script>
        // 滑下效果：元素从底部滑入
        ScrollReveal().reveal('.packages .box', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.services .box', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.card-3D .box-3D span', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.review .swiper-slide', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.travel-section .travel-container', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.newsletter-section .newsletter-container', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.contact .location', {
            origin: 'bottom',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });

        // 滑上效果：元素从顶部滑入
        ScrollReveal().reveal('.packages .box', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.services .box', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.card-3D .box-3D span', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.review .swiper-slide', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            interval: 200,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.travel-section .travel-container', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.newsletter-section .newsletter-container', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });

        ScrollReveal().reveal('.contact .location', {
            origin: 'top',
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out'
        });
    </script>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($resorts as $resort)
                var swiper{{ $resort->id }} = new Swiper('#swiper{{ $resort->id }}', {
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                });
            @endforeach
        });
    </script>

    <!-- 引入 Scroll Reveal 库 -->
    <script src="https://unpkg.com/scrollreveal"></script>
    {{-- Letter Scroll Reveal Effect JS --}}
    <script>
        ScrollReveal().reveal('[data-sr="content"]', {
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out',
            origin: 'left',
        });

        ScrollReveal().reveal('[data-sr="form"]', {
            distance: '50px',
            duration: 1000,
            easing: 'ease-in-out',
            origin: 'right',
        });
    </script>

    {{-- Run Video Button JS --}}
    <script>
        // Discount Media
        const video = document.querySelector(".video");
        const button = document.querySelector(".video-control");

        button.addEventListener("click", playpausevideo);

        function playpausevideo() {
            if (video.paused) {
                button.innerHTML = "<i class='bx bx-pause' ></i>";
                video.play();
            } else {
                button.innerHTML = "<i class='bx bx-play' ></i>";
                video.pause();
            }
        }
    </script>

    {{-- Auto Load Video --}}
    <script>
        function autoPlayVideo() {
            const videos = document.querySelectorAll('.vid-btn');
            const videoSlider = document.getElementById('video-slider');
            let currentVideoIndex = 0;

            function playNextVideo() {
                // 获取下一个视频的索引
                currentVideoIndex = (currentVideoIndex + 1) % videos.length;

                // 更新视频源并播放
                const nextVideoSrc = videos[currentVideoIndex].getAttribute('data-src');
                videoSlider.src = nextVideoSrc;
                videoSlider.play();
            }

            // 当视频播放完毕时自动播放下一个视频
            videoSlider.addEventListener('ended', playNextVideo);

            // 初始播放第一个视频
            videoSlider.play();
        }

        // 调用函数开始自动播放视频
        autoPlayVideo();
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

    <!-- Link Swiper's JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    {{-- Recommandation Card Slider --}}
    <script>
        // Initialize Swiper for recommendations
        var recommendationSwiper = new Swiper('.room-slider', {
            // Specify your swiper options here
            loop: true, // Enable looping
            slidesPerView: 'auto', // Set to 'auto' to determine slides per view automatically based on container's width
            autoplay: {
                delay: 2000, // Delay between transitions in milliseconds
                disableOnInteraction: false, // Enable/disable autoplay on user interaction
            },
        });
    </script>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    {{-- Gallery Card Slider --}}
    <script>
        var TrandingSlider = new Swiper('.tranding-slider', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true, // 开启循环
            autoplay: {
                delay: 2000, // 设置自动播放间隔时间为2秒
                disableOnInteraction: false, // 用户交互后不禁用自动播放
            },
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 100,
                modifier: 2.5,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });
    </script>

    {{-- Review Card Slider --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // 初始化评论滑动器
        var reviewSlider = new Swiper('.revswiper-container', {
            effect: 'coverflow', // 使用coverflow效果
            centeredSlides: true, // 居中显示幻灯片
            loop: true, // 启用循环
            autoplay: {
                delay: 2000, // 自动播放间隔时间为2秒
                disableOnInteraction: false, // 用户交互后不禁用自动播放
            },
            slidesPerView: 'auto', // 根据容器宽度自动确定每次显示的幻灯片数
            coverflowEffect: {
                rotate: 0, // 旋转角度
                stretch: 0, // 拉伸
                depth: 100, // 深度
                modifier: 2.5, // 修饰器
            },
        });
    </script>

    {{-- Pusher JS Disabled Resort Function --}}
    <script>
        // JavaScript code here to disable resort cards based on status
        let resortcard; // Declare the variable outside of the loop
        let viewresort;

        @foreach ($resorts as $resort)
            @if ($resort->status == 1)
                // Get the resort card element for the current resort
                resortcard = document.getElementById('resortcard_{{ $resort->id }}');
                viewresort = document.getElementById('viewresort{{ $resort->id }}');

                // Add the "disabled" class to style and disable the card
                if (resortcard) {
                    resortcard.classList.add('disabled');
                }

                // Remove the "disabled" attribute from the View Detail button
                if (viewresort) {
                    viewresort.removeAttribute('disabled');
                }
            @endif
        @endforeach
    </script>

    {{-- Pusher JS Disabled Hotel Function --}}
    <script>
        // JavaScript code here to disable hotel cards based on status
        let hotelcard; // Declare the variable outside of the loop
        let viewhotel;

        @foreach ($hotels as $hotel)
            @if ($hotel->status == 1)
                // Get the hotel card element for the current hotel
                hotelcard = document.getElementById('hotelcard_{{ $hotel->id }}');
                viewhotel = document.getElementById('viewhotel{{ $hotel->id }}');

                // Add the "disabled" class to style and disable the card
                if (hotelcard) {
                    hotelcard.classList.add('disabled');
                }

                // Remove the "disabled" attribute from the View Detail button
                if (viewhotel) {
                    viewhotel.removeAttribute('disabled');
                }
            @endif
        @endforeach
    </script>

    {{-- Pusher JS Disabled Restaurant Function --}}
    <script>
        // JavaScript code here to disable restaurant cards based on status
        let restaurantcard_; // Declare the variable outside of the loop
        let viewrestaurant;

        @foreach ($restaurants as $restaurant)
            @if ($restaurant->status == 1)
                // Get the restaurant card element for the current restaurant
                restaurantcard_ = document.getElementById('restaurantcard_{{ $restaurant->id }}');
                viewrestaurant = document.getElementById('viewrestaurant{{ $restaurant->id }}');

                // Add the "disabled" class to style and disable the card
                if (restaurantcard_) {
                    restaurantcard_.classList.add('disabled');
                }

                // Remove the "disabled" attribute from the View Detail button
                if (viewrestaurant) {
                    viewrestaurant.removeAttribute('disabled');
                }
            @endif
        @endforeach
    </script>

    {{-- Scroll Reveal Effect --}}
    <!-- Include Swiper's JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Include ScrollReveal JS -->
    <script src="https://unpkg.com/scrollreveal"></script>

    {{-- Scroll Reveal Effect From Home To Recommendation --}}
    <script>
        // Initialize ScrollReveal for sections with [data-sr]
        ScrollReveal().reveal('[data-sr]', {
            duration: 1000,
            distance: '50px',
            easing: 'ease-in-out',
            origin: 'bottom',
            reset: true // if you want animations to re-occur on scroll
        });

        // Initialize ScrollReveal for sections without [data-sr]
        ScrollReveal().reveal('[data-no-sr]', {
            duration: 0, // Set duration to 0 for sections without scroll reveal effect
            reset: true // Reset to reveal only once
        });
    </script>

    {{-- Scroll Reveal Effect From Resort To Restaurant --}}
    <script>
        // 初始化度假村的 Swiper
        // function initResortSwiper() {
        //     var resortSwiper = new Swiper('#resort-room .room-slider', {
        //         loop: true, // 启用循环
        //         slidesPerView: 1, // 每次显示一张幻灯片
        //         pagination: {
        //             el: '#resort-room .swiper-pagination', // 分页容器
        //             clickable: true, // 启用可点击的分页指示点
        //         },
        //         autoplay: {
        //             delay: 2000, // 幻灯片之间的切换延迟（以毫秒为单位）
        //             disableOnInteraction: false, // 用户交互后是否禁用自动播放
        //         },
        //     });
        // }

        function initResortSwiper() {
            var resortSwiper = new Swiper('#resort-room .room-slider', {
                loop: true, // Enable loop mode
                slidesPerView: 'auto', // Display slides in a single row
                spaceBetween: 0, // Adjust space between slides
                pagination: {
                    el: '#resort-room .swiper-pagination', // Pagination container
                    clickable: true, // Enable clickable pagination
                },
                autoplay: {
                    delay: 2000, // Delay between slides (in milliseconds)
                    disableOnInteraction: false, // Do not disable autoplay on interaction
                },
            });
        }

        // 初始化酒店的 Swiper
        function initHotelSwiper() {
            var hotelSwiper = new Swiper('#hotel-room .room-slider', {
                loop: true, // 启用循环
                slidesPerView: 1, // 每次显示一张幻灯片
                pagination: {
                    el: '#hotel-room .swiper-pagination', // 分页容器
                    clickable: true, // 启用可点击的分页指示点
                },
                autoplay: {
                    delay: 2000, // 幻灯片之间的切换延迟（以毫秒为单位）
                    disableOnInteraction: false, // 用户交互后是否禁用自动播放
                },
            });
        }

        // 初始化餐厅的 Swiper
        function initRestaurantSwiper() {
            var restaurantSwiper = new Swiper('#restaurant-room .room-slider', {
                loop: true, // 启用循环
                slidesPerView: 1, // 每次显示一张幻灯片
                pagination: {
                    el: '#restaurant-room .swiper-pagination', // 分页容器
                    clickable: true, // 启用可点击的分页指示点
                },
                autoplay: {
                    delay: 2000, // 幻灯片之间的切换延迟（以毫秒为单位）
                    disableOnInteraction: false, // 用户交互后是否禁用自动播放
                },
            });
        }

        // 初始化推荐的 Swiper
        function initRecommendationSwiper() {
            var recommendationSwiper = new Swiper('#room .room-slider', {
                loop: true, // 启用循环
                slidesPerView: 1, // 每次显示一张幻灯片
                pagination: {
                    el: '#room .swiper-pagination', // 分页容器
                    clickable: true, // 启用可点击的分页指示点
                },
                autoplay: {
                    delay: 2000, // 幻灯片之间的切换延迟（以毫秒为单位）
                    disableOnInteraction: false, // 用户交互后是否禁用自动播放
                },
            });
        }

        // 初始化ScrollReveal
        ScrollReveal().reveal('[data-sr="slide-up"]', {
            duration: 1000, // 动画持续时间
            distance: '50px', // 动画距离
            easing: 'ease-in-out', // 动画缓动效果
            origin: 'bottom', // 动画起始位置
            reset: true, // 是否在滚动时重新触发动画
            afterReveal: function(el) {
                // 在ScrollReveal效果之后初始化各部分的Swiper
                if (el.id === 'resort-room') {
                    initResortSwiper();
                } else if (el.id === 'hotel-room') {
                    initHotelSwiper();
                } else if (el.id === 'restaurant-room') {
                    initRestaurantSwiper();
                } else if (el.id === 'room') {
                    initRecommendationSwiper();
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="path/to/slick.min.js"></script>

    <script>
        class InteractiveChatbox { // 定义交互式聊天框类
            constructor(button, chatbox, icons) { // 构造函数，接收按钮、聊天框和图标参数
                this.button = button; // 按钮元素
                this.chatbox = chatbox; // 聊天框元素
                this.icons = icons; // 图标对象
                this.state = false; // 初始状态为关闭
            }

            display() { // 显示聊天框方法
                this.button.addEventListener('click', () => this.toggleState()); // 监听按钮点击事件
            }

            toggleState() { // 切换状态方法
                this.state = !this.state; // 状态取反
                this.showOrHideChatBox(); // 调用显示或隐藏聊天框方法
            }

            showOrHideChatBox() { // 显示或隐藏聊天框方法
                if (this.state) { // 如果状态为打开
                    this.chatbox.classList.add('chatbox--active'); // 添加活动类
                    this.toggleIcon(true); // 切换图标为打开状态
                } else { // 否则
                    this.chatbox.classList.remove('chatbox--active'); // 移除活动类
                    this.toggleIcon(false); // 切换图标为关闭状态
                }
            }

            toggleIcon(state) { // 切换图标方法
                if (state) { // 如果状态为打开
                    this.button.innerHTML = this.icons.isClicked; // 设置按钮 HTML 为打开图标
                } else { // 否则
                    this.button.innerHTML = this.icons.isNotClicked; // 设置按钮 HTML 为关闭图标
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => { // 文档加载完成后执行
            const chatButton = document.querySelector('.chatbox__button button'); // 获取聊天框按钮元素
            const chatContent = document.querySelector('.chatbox__support'); // 获取聊天内容元素
            const icons = { // 图标对象
                isClicked: '<img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">', // 打开状态图标 HTML
                isNotClicked: '<img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">' // 关闭状态图标 HTML
            };

            const chatbox = new InteractiveChatbox(chatButton, chatContent, icons); // 创建聊天框实例
            chatbox.display(); // 显示聊天框

            // 确保页面加载时聊天框关闭
            chatbox.state = false; // 将状态设为关闭
            chatbox.showOrHideChatBox(); // 显示或隐藏聊天框

            const inputField = document.getElementById('chat-input'); // 获取输入框元素
            inputField.addEventListener('keypress', function(event) { // 监听输入框按键事件
                if (event.key === 'Enter') { // 如果按下的是回车键
                    sendMessage(); // 调用发送消息方法
                }
            });
        });

        function sendMessage() { // 发送消息方法
            const input = document.getElementById('chat-input'); // 获取输入框元素
            const message = input.value; // 获取输入框的值

            if (message.trim() === '') return; // 如果消息为空则返回

            const contentBox = document.getElementById('content-box'); // 获取内容盒子元素
            const visitorMessage = document.createElement('div'); // 创建访客消息元素
            visitorMessage.className = 'messages__item messages__item--visitor'; // 添加类名
            visitorMessage.textContent = message; // 设置文本内容为消息内容
            contentBox.appendChild(visitorMessage); // 将访客消息元素添加到内容盒子中
            contentBox.scrollTop = contentBox.scrollHeight; // 滚动内容盒子到底部

            fetch('/chat', { // 发送聊天请求
                    method: 'POST', // POST 方法
                    headers: {
                        'Content-Type': 'application/json', // JSON 格式
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF 令牌
                    },
                    body: JSON.stringify({ // 请求体为 JSON 格式的消息内容
                        message: message // 消息内容
                    })
                })
                .then(response => response.json()) // 解析响应为 JSON 格式
                .then(data => { // 处理响应数据
                    const operatorMessage = document.createElement('div'); // 创建客服消息元素
                    operatorMessage.className = 'messages__item messages__item--operator'; // 添加类名
                    operatorMessage.textContent = data.response; // 设置文本内容为响应的消息内容
                    contentBox.appendChild(operatorMessage); // 将客服消息元素添加到内容盒子中
                    contentBox.scrollTop = contentBox.scrollHeight; // 滚动内容盒子到底部
                    input.value = ''; // 清空输入框的值
                })
                .catch(error => { // 捕获错误
                    console.error('Error:', error); // 输出错误信息到控制台
                });
        }
    </script>
    {{-- <script>
        class InteractiveChatbox { // 定义交互式聊天框类
            constructor(button, chatbox, icons) { // 构造函数，接收按钮、聊天框和图标参数
                this.button = button; // 按钮元素
                this.chatbox = chatbox; // 聊天框元素
                this.icons = icons; // 图标对象
                this.state = false; // 初始状态为关闭
            }

            display() { // 显示聊天框方法
                this.button.addEventListener('click', () => this.toggleState()); // 监听按钮点击事件
            }

            toggleState() { // 切换状态方法
                this.state = !this.state; // 状态取反
                this.showOrHideChatBox(); // 调用显示或隐藏聊天框方法
            }

            showOrHideChatBox() { // 显示或隐藏聊天框方法
                if (this.state) { // 如果状态为打开
                    this.chatbox.classList.add('chatbox--active'); // 添加活动类
                    this.toggleIcon(true); // 切换图标为打开状态
                } else { // 否则
                    this.chatbox.classList.remove('chatbox--active'); // 移除活动类
                    this.toggleIcon(false); // 切换图标为关闭状态
                }
            }

            toggleIcon(state) { // 切换图标方法
                if (state) { // 如果状态为打开
                    this.button.innerHTML = this.icons.isClicked; // 设置按钮 HTML 为打开图标
                } else { // 否则
                    this.button.innerHTML = this.icons.isNotClicked; // 设置按钮 HTML 为关闭图标
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => { // 文档加载完成后执行
            const chatButton = document.querySelector('.chatbox__button button'); // 获取聊天框按钮元素
            const chatContent = document.querySelector('.chatbox__support'); // 获取聊天内容元素
            const icons = { // 图标对象
                isClicked: '<img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">', // 打开状态图标 HTML
                isNotClicked: '<img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat">' // 关闭状态图标 HTML
            };

            const chatbox = new InteractiveChatbox(chatButton, chatContent, icons); // 创建聊天框实例
            chatbox.display(); // 显示聊天框

            // 确保页面加载时聊天框关闭
            chatbox.state = false; // 将状态设为关闭
            chatbox.showOrHideChatBox(); // 显示或隐藏聊天框

            const inputField = document.getElementById('chat-input');
            inputField.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        });

        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if (message === '') return;

            const contentBox = document.getElementById('content-box');
            const visitorMessage = document.createElement('div');
            visitorMessage.className = 'messages__item messages__item--visitor';
            visitorMessage.textContent = message;
            contentBox.appendChild(visitorMessage);
            contentBox.scrollTop = contentBox.scrollHeight;

            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(JSON.stringify(err));
                    });
                }
                return response.json();
            })
            .then(data => {
                const operatorMessage = document.createElement('div');
                operatorMessage.className = 'messages__item messages__item--operator';
                operatorMessage.textContent = data.response;
                contentBox.appendChild(operatorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;
                input.value = '';
            })
            .catch(error => {
                console.error('Error:', error);
                const operatorMessage = document.createElement('div');
                operatorMessage.className = 'messages__item messages__item--operator';
                operatorMessage.textContent = 'Error: ' + error.message;
                contentBox.appendChild(operatorMessage);
            });
        }

    </script> --}}

@endsection
